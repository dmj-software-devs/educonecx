<?php

namespace App\Exceptions;

use RuntimeException;

class InsufficientPracticeCreditsException extends RuntimeException
{
    public function __construct(string $message = 'You do not have enough practice time.')
    {
        parent::__construct($message);
    }
}
