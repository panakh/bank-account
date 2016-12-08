<?php
namespace App\Domain;

class InvalidTransactionAmountException extends \RuntimeException
{
    const ZERO_AMOUNT = 'Zero given as the amount';
    const NEGATIVE_AMOUNT = 'Negative amount given as the amount';
    const NON_NUMBER = 'Non numeric value given as the amount';

    /**
     * InvalidAmountException constructor.
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}