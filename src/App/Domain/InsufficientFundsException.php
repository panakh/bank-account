<?php

namespace App\Domain;


class InsufficientFundsException extends \RuntimeException
{

    const MESSAGE = 'Insufficient funds to complete this transaction';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
}