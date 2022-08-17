<?php

namespace App\Exception;

use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

class WorkMachineNotFoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Work-machine not found', Response::HTTP_NOT_FOUND);
    }
}
