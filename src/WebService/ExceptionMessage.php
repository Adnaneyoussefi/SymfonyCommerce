<?php

namespace App\WebService;

class ExceptionMessage extends \Exception
{
    private $codeM;

    public function __construct($message, $codeM)
    {
        parent::__construct($message);
        $this->codeM = $codeM;
    }

    public function getCodeM()
    {
        return $this->codeM;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function __toString()
    {
        return $this->message;
    }
}