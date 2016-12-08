<?php

namespace App\Domain;

interface AmountValidatorInterface
{
    /**
     * @param $amount float
     * @return void
     * @throws InvalidTransactionAmountException when amount is not valid
     */
    public function validateAmount($amount);
}