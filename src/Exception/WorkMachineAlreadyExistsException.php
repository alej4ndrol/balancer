<?php

namespace App\Exception;

use RuntimeException;

class WorkMachineAlreadyExistsException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Work-machine already exists');
    }
}
