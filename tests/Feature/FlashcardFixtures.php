<?php


namespace Tests\Feature;

use App\Helpers\FlashcardHelper;
use App\Models\Flashcard;
use App\Models\Practice;
use App\StatusCodes;

class FlashcardFixtures
{
    public const QUESTION = 'Q1';
    public const ANSWER = 'A1';
    public const WRONG_ANSWER = 'A2';

    public static function createNotAnsweredFlashcard(): Flashcard
    {
        return Flashcard::create([
            'question' => self::QUESTION,
            'answer' => self::ANSWER
        ]);
    }

    public static function createCorrectAnsweredFlashcard(): Flashcard | Practice
    {
        return Flashcard::create([
            'question' => self::QUESTION,
            'answer' => self::ANSWER
        ])->practices()->create([
            'user_id' => FlashcardHelper::USER_ID,
            'user_answer' => self::ANSWER,
            'status' => StatusCodes::CORRECT_STATUS
        ]);
    }

    public static function createIncorrectAnsweredFlashcard(): Flashcard | Practice
    {
        return Flashcard::create([
            'question' => self::QUESTION,
            'answer' => self::ANSWER
        ])->practices()->create([
            'user_id' => FlashcardHelper::USER_ID,
            'user_answer' => "A",
            'status' => StatusCodes::INCORRECT_STATUS
        ]);
    }
}
