<?php

namespace App\Exceptions;

use RuntimeException;

class InsufficientPracticeCreditsException extends RuntimeException
{
    public function __construct(string $message = 'You do not have enough practice credits.')
    {
        parent::__construct($message);
    }
}
