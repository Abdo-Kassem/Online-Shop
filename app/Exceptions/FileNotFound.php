<?php

namespace App\Exceptions;

use Exception;

class FileNotFound extends Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    
    }
}
