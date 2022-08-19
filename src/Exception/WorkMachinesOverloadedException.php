<?php

namespace App\Exception;

use RuntimeException;

class WorkMachinesOverloadedException extends RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct($message.'work-machines overloaded.');
    }
}
