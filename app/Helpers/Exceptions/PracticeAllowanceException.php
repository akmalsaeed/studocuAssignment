<?php


namespace App\Helpers\Exceptions;


class PracticeAllowanceException extends \Exception
{

    /**
     * NotFoundException constructor.
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
