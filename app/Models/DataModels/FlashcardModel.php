<?php

namespace App\Models\DataModels;

class FlashcardModel{

    private $id;
    private $question;
    private $answer;


    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function hasId(){
        return !empty($this->id);
    }

    /**
     * Get the value of question
     */ 
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set the value of question
     *
     * @return  self
     */ 
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    public function hasQuestion(){
        return !empty($this->question);
    }

    /**
     * Get the value of answer
     */ 
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set the value of answer
     *
     * @return  self
     */ 
    public function setAnswer($answer)
    {
        $this->answer = $answer;

        return $this;
    }

    public function hasAnswer(){
        return !empty($this->answer);
    }

    public static function fromInput($input = [],$model = null){
        if(!$model){
            $model = new FlashcardModel();
        }

        if(isset($input['id'])){
            $model->setId($input['id']);
        }

        if(isset($input['question'])){
            $model->setQuestion($input['question']);
        }

        if(isset($input['answer'])){
            $model->setAnswer($input['answer']);
        }

        return $model;
    }

    public function getInputArray($input = []){
        if($this->hasId()){$input['id'] = $this->getId();}
        if($this->hasQuestion()){$input['question'] = $this->getQuestion();}
        if($this->hasAnswer()){$input['answer'] = $this->getAnswer();}
        return $input;
    }
}