<?php

namespace App\Domain;

class InsufficientFundsExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testInsufficientFundsExceptionHasCorrectMessageWhenCreated()
    {
        $e = new InsufficientFundsException();
        $this->assertEquals(
            'Insufficient funds to complete this transaction',
            $e->getMessage(),
            'Incorrect insufficient funds message');
    }
}