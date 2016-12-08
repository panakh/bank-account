<?php

namespace App\Domain;


class ClosedAccountException extends \RuntimeException
{
    const CANNOT_SEE_BALANCE = 'Can not see balance of a closed account';
    const CANNOT_DEPOSIT_MONEY = 'Can not deposit money to a closed account';
    const CANNOT_WITHDRAW_MONEY = 'Can not withdraw money from a closed account';

    public function __construct($message)
    {
        parent::__construct($message);
    }
}