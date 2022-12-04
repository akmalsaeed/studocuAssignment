<?php

namespace App\Helpers;

use App\Helpers\Exceptions\NotFoundException;
use App\Helpers\Exceptions\PracticeAllowanceException;
use App\Models\DataModels\FlashcardModel;
use App\Models\DataModels\PracticeModel;
use App\Models\Flashcard;
use App\Models\Practice;
use App\StatusCodes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class FlashcardHelper{


    // TODO:: based-on requirment of assignment, User Auth will be implemented in the future.
    public const USER_ID = 1;

    /**
     * @throws \Throwable
     */
    public static function create($input): Flashcard{
        $rules = [
            'question' => 'required',
            'answer' => 'required',
        ];

        $validator = Validator::make($input, $rules);
        throw_if($validator->fails(), new ValidationException($validator));
        $flashcardData = FlashcardModel::fromInput($input);
        return Flashcard::create($flashcardData->getInputArray());            

    }

    public static function list(): array{
        return Flashcard::select('question','answer')->get()->toArray();
    }

    public static function listWithPracticeStatus(): array{
        $practices = DB::table('flashcards')
            ->select(['flashcards.id','question','status'])
            ->distinct()
            ->leftJoin('practices', function($join)
            {
                $join->on('flashcards.id', '=', 'practices.flashcard_id');
                $join->on('practices.user_id', '=', DB::raw(self::USER_ID));
            })->get();

        $result = [];
        foreach ($practices as $practice){
            $status = ($practice->status != null) ? $practice->status : StatusCodes::NOT_ANSWERED_STATUS;
            $result[] = array(
                'ID' => $practice->id,
                'Question' => $practice->question,
                'Status' => __("label.flashcard.practice.status.".$status),
            );
        }

        return $result;
    }

    /**
     * @throws \Throwable
     */
    public static function fetchFlashcardForPractice($id) : Flashcard{
        $flashcard = Flashcard::find($id);
        throw_if($flashcard == null, new NotFoundException(__("label.flashcard.practice.not_found_question")));
        $practice = $flashcard->practices()->where('user_id', self::USER_ID)->get()->first();
        throw_if($practice?->status == StatusCodes::CORRECT_STATUS, new PracticeAllowanceException(__("label.flashcard.practice.cannot_answer")));

        return $flashcard;
    }

    public static function answerQuestion($flashcard, $answer): string{
        if (trim($flashcard->answer) == trim($answer)){
            $status = StatusCodes::CORRECT_STATUS;
        }else{
            $status = StatusCodes::INCORRECT_STATUS;
        }

        $practiceDataModel = new PracticeModel();
        $practiceDataModel->setFlashcard_id($flashcard->id);
        $practiceDataModel->setUser_answer($answer);
        $practiceDataModel->setUser_id(self::USER_ID);
        $practiceDataModel->setStatus($status);

        $practice = Practice::getUserPractice(self::USER_ID,$flashcard->id);
        if ($practice != null){
            $practice->fromDataModel($practiceDataModel);
            $practice->save();
        }else{
            $createPractice = new Practice();
            $createPractice->fromDataModel($practiceDataModel);
            $createPractice->save();

        }

        return $status;
    }

    public static function getPercentageOfCompletion(): float
    {
        $flashcards = self::listWithPracticeStatus();
        $percentage = count(array_filter($flashcards, function($v) { return $v['Status'] == __("label.flashcard.practice.status.correct"); })) / count($flashcards) * 100;
        return round($percentage);
    }

    public static function stats(): array{
        return [
          "Questions" => self::flashcardCount(),
          "Answered" => self::answeredQuestionPercentage(),
          "Correct" => self::getPercentageOfCompletion()
        ];
    }

    public static function reset(): void{
        Practice::resetUserPractice(self::USER_ID);
    }

    private static function flashcardCount(): int{
        return Flashcard::all()->count();
    }

    private static function answeredQuestionPercentage(): float{
        $flashcards = self::listWithPracticeStatus();
        $percentage = count(array_filter($flashcards, function($v) {
            return ($v['Status'] != __("label.flashcard.practice.status.not_answered"));
        })) / count($flashcards) * 100;
        return round($percentage);
    }

}