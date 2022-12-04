<?php


namespace App\Models;

use App\Models\DataModels\FlashcardModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Flashcard extends Model
{
    protected $fillable = [
      'question', 'answer'
    ];

    public function practices(): HasMany
    {
        return $this->hasMany('App\Models\Practice');
    }

    public function fromDataModel(FlashcardModel $flashcardModel){
        if($flashcardModel->hasQuestion()){$this->question = $flashcardModel->getQuestion();}
        if($flashcardModel->hasAnswer()){$this->answer = $flashcardModel->getAnswer();}
    }
}
