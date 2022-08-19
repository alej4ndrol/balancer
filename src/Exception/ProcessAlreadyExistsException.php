<?php

namespace App\Exception;

use RuntimeException;

class ProcessAlreadyExistsException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Process already exists');
    }
}
