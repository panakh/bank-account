<?php

namespace App\Domain;

class AccountTest extends \PHPUnit_Framework_TestCase
{
    private $account;

    public function __construct()
    {
        $this->account = new Account(\Mockery::mock(Customer::class));
    }

    public function testCanGetBalance()
    {
        $this->assertEquals(0, $this->account->getBalance(), 'Balance is not zero');
    }

    public function testCanDepositMoney()
    {
        $account = $this->account;
        $money = 100.00;
        $account->deposit($money);
        $this->assertEquals($money, $account->getBalance(), 'Deposited amount does not equal balance');
    }

    /**
     * @expectedException App\Domain\InvalidTransactionAmountException
     * @expectedExceptionMessage App\Domain\InvalidTransactionAmountException::ZERO_AMOUNT
     */
    public function testDepositFailsWhenAZeroAmountIsGiven()
    {
        $this->account->deposit(0);
    }

    /**
     * @expectedException App\Domain\InvalidTransactionAmountException
     * @expectedExceptionMessage App\Domain\InvalidTransactionAmountException::NEGATIVE_AMOUNT
     */
    public function testDepositFailsWhenANegativeAmountIsGiven()
    {
        $this->account->deposit(-1);
    }

    /**
     * @expectedException App\Domain\InvalidTransactionAmountException
     * @expectedExceptionMessage App\Domain\InvalidTransactionAmountException::NON_NUMBER
     */
    public function testDepositFailsWhenANonNumberIsGiven()
    {
        $this->account->deposit('string');
    }

    /**
     * @expectedException App\Domain\InvalidTransactionAmountException
     * @expectedExceptionMessage App\Domain\InvalidTransactionAmountException::NON_NUMBER
     */
    public function testDepositFailsWhenNullIsGiven()
    {
        $this->account->deposit(null);
    }

    /**
     * @expectedException App\Domain\ClosedAccountException
     */
    public function testGetBalanceThrowsErrorWhenAccountIsClosed()
    {
        $account = $this->account;
        $account->close();
        $account->getBalance();
    }

    public function testCloseMarksAccountAsClosed()
    {
        $account = $this->account;
        $account->close();
        $this->assertTrue($account->isClosed(), 'Account is not closed');
    }

    public function testIsClosedReturnsFalseWhenAccountIsNotClosed()
    {
        $this->assertFalse($this->account->isClosed(), 'Account is closed');
    }

    /**
     * @expectedException App\Domain\ClosedAccountException
     */
    public function testDepositThrowsExceptionWhenAccountIsClosed()
    {
        $account = $this->account;
        $account->close();
        $account->deposit(100.00);
    }

    /**
     * @expectedException App\Domain\InvalidTransactionAmountException
     * @expectedExceptionMessage App\Domain\InvalidTransactionAmountException::ZERO_AMOUNT
     */
    public function testWithdrawFailsWhenZeroAmountIsGiven()
    {
        $this->account->withdraw(0);
    }

    /**
     * @expectedException App\Domain\InvalidTransactionAmountException
     * @expectedExceptionMessage App\Domain\InvalidTransactionAmountException::NEGATIVE_AMOUNT
     */
    public function testWithdrawFailsWhenNegativeAmountIsGiven()
    {
        $this->account->withdraw(-1);
    }

    /**
     * @expectedException App\Domain\InvalidTransactionAmountException
     * @expectedExceptionMessage App\Domain\InvalidTransactionAmountException::NON_NUMBER
     */
    public function testWithdrawalFailsWhenANonNumberIsGiven()
    {
        $this->account->withdraw('string');
    }

    /**
     * @expectedException App\Domain\InsufficientFundsException
     */
    public function testWithdrawalFailsWhenThereAreNoFundsAvailable()
    {
        $this->account->withdraw(10);
    }

    /**
     * @expectedException App\Domain\InvalidTransactionAmountException
     * @expectedExceptionMessage App\Domain\InvalidTransactionAmountException::NON_NUMBER
     */
    public function testAgreeOverdraftFailsWhenANonNumberIsGiven()
    {
        $this->account->agreeOverdraft('string');
    }

    /**
     * @expectedException App\Domain\InvalidTransactionAmountException
     * @expectedExceptionMessage App\Domain\InvalidTransactionAmountException::ZERO_AMOUNT
     */
    public function testAgreeOverdraftFailsWhenZeroIsGiven()
    {
        $this->account->agreeOverdraft(0);
    }

    /**
     * @expectedException App\Domain\InvalidTransactionAmountException
     * @expectedExceptionMessage App\Domain\InvalidTransactionAmountException::NEGATIVE_AMOUNT
     */
    public function testAgreeOverdraftFailsWhenANegativeAmountIsGiven()
    {
        $this->account->agreeOverdraft(-1);
    }

    public function testIsOverdraftAgreedReturnsTrueWhenOverdraftIsAgreed()
    {
        $account = $this->account;
        $account->agreeOverdraft(10);
        $this->assertTrue(
            $account->isOverdraftAgreed(),
            'isOverdraftAgreed does not return true when overdraft is agreed');
    }

    public function testIsOverdraftAgreedReturnsFalseWhenOverdraftIsNotAgreed()
    {
        $account = $this->account;
        $this->assertFalse(
            $account->isOverdraftAgreed(),
            'isOverdraftAgreed returns true when overdraft is not agreed');
    }

    public function testGetOverdraftAmountReturnsZeroWhenNoOverdraftIsAgreed()
    {
        $this->assertEquals(
            0,
            $this->account->getOverdraftAmount(),
            'getOverdraftAmount does not return zero when no overdraft is agreed');
    }

    public function testGetOverdraftAmountReturnsOverdraftAmountWhenOverdraftIsAgreed()
    {
        $account = $this->account;
        $overdraftAmount = 100;
        $account->agreeOverdraft($overdraftAmount);
        $this->assertEquals(
            $overdraftAmount,
            $account->getOverdraftAmount(),
            'getOverdraftAmount does not return the agreed overdraft amount');
    }

}