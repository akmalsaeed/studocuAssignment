<?php

namespace App\Models\DataModels;

class PracticeModel{

    private $id;
    private $flashcard_id;
    private $user_id;
    private $user_answer;
    private $status;


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
     * Get the value of flashcard_id
     */ 
    public function getFlashcard_id()
    {
        return $this->flashcard_id;
    }

    /**
     * Set the value of flashcard_id
     *
     * @return  self
     */ 
    public function setFlashcard_id($flashcard_id)
    {
        $this->flashcard_id = $flashcard_id;

        return $this;
    }

    public function hasFlashcard_id(){
        return !empty($this->flashcard_id);
    }


    /**
     * Get the value of user_id
     */ 
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */ 
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function hasUser_id(){
        return !empty($this->user_id);
    }

    /**
     * Get the value of user_answer
     */ 
    public function getUser_answer()
    {
        return $this->user_answer;
    }

    /**
     * Set the value of user_answer
     *
     * @return  self
     */ 
    public function setUser_answer($user_answer)
    {
        $this->user_answer = $user_answer;

        return $this;
    }

    public function hasUser_answer(){
        return !empty($this->user_answer);
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function hasStatus(){
        return !empty($this->status);
    }



    public function fromInput($input = [],$model = null){
        if(!$model){
            $model = new FlashcardModel();
        }

        if(isset($input['id'])){
            $model->setId($input['id']);
        }

        if(isset($input['flashcard_id'])){
            $model->setFlashcard_id($input['flashcard_id']);
        }

        if(isset($input['user_id'])){
            $model->setUser_id($input['user_id']);
        }

        if(isset($input['user_answer'])){
            $model->setUser_answer($input['user_answer']);
        }

        if(isset($input['status'])){
            $model->setStatus($input['status']);
        }

        return $model;
    }

    public function getInputArray($input = []){
        if($this->hasId()){$input['id'] = $this->getId();}
        if($this->hasFlashcard_id()){$input['flashcard_id'] = $this->getFlashcard_id();}
        if($this->hasUser_id()){$input['user_id'] = $this->getUser_id();}
        if($this->hasUser_answer()){$input['user_answer'] = $this->getUser_answer();}
        if($this->hasStatus()){$input['status'] = $this->getStatus();}
        return $input;
    }

}