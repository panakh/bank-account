<?php

namespace App\Domain;

class ClosedAccountExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateWithCanNotSeeBalance()
    {
        $e = new ClosedAccountException(ClosedAccountException::CANNOT_SEE_BALANCE);
        $this->assertEquals('Can not see balance of a closed account', $e->getMessage());
    }

    public function testCanCreateWithCanNotDepositMoney()
    {
        $e = new ClosedAccountException(ClosedAccountException::CANNOT_DEPOSIT_MONEY);
        $this->assertEquals('Can not deposit money to a closed account', $e->getMessage());
    }

    public function testCanCreateWithCanNotWithdrawMoney()
    {
        $e = new ClosedAccountException(ClosedAccountException::CANNOT_WITHDRAW_MONEY);
        $this->assertEquals('Can not withdraw money from a closed account', $e->getMessage());
    }
}