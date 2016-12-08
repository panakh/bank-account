<?php

namespace App\Domain;

class InvalidTransactionAmountExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateToRepresentZeroAmount()
    {
        $e = new InvalidTransactionAmountException(InvalidTransactionAmountException::ZERO_AMOUNT);
        $this->assertEquals('Zero given as the amount', $e->getMessage());
    }

    public function testCanCreateToRepresentNegativeAmount()
    {
        $e = new InvalidTransactionAmountException(InvalidTransactionAmountException::NEGATIVE_AMOUNT);
        $this->assertEquals('Negative amount given as the amount', $e->getMessage());
    }

    public function testCanCreateToRepresentANonNumber()
    {
        $e = new InvalidTransactionAmountException(InvalidTransactionAmountException::NON_NUMBER);
        $this->assertEquals('Non numeric value given as the amount', $e->getMessage());
    }
}