<?php

namespace App\Models;

use App\Models\DataModels\PracticeModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Practice extends Model
{
    use HasFactory;

    protected $fillable = ['flashcard_id', 'user_id', 'user_answer', 'status' ];

    public function flashcard(){
        return $this->belongsTo('App\Models\Flashcard');
    }

    public function fromDataModel(PracticeModel $practiceModel){
        if($practiceModel->hasFlashcard_id()){$this->flashcard_id = $practiceModel->getFlashcard_id();}
        if($practiceModel->hasUser_id()){$this->user_id = $practiceModel->getUser_id();}
        if($practiceModel->hasUser_answer()){$this->user_answer = $practiceModel->getUser_answer();}
        if($practiceModel->hasStatus()){$this->status = $practiceModel->getStatus();}
    }

    public static function getUserPractice($userId, $flashcardId){
        return $practice = Practice::where("flashcard_id", $flashcardId)->where("user_id", $userId)->get()->first();
    }

    public static function resetUserPractice($userId){
        Practice::where("user_id", $userId)->delete();
    }
}
