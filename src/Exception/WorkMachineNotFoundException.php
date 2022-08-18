<?php

namespace App\Exception;

use RuntimeException;

class WorkMachineNotFoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Work-machine not found');
    }
}
