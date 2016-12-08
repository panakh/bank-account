<?php

use App\Domain\Account;
use App\Domain\ClosedAccountException;
use App\Domain\Customer;
use App\Domain\InsufficientFundsException;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use PHPUnit_Framework_Assert as Assert;

/**
 * Defines application features from the specific context.
 */
class OverdraftFeatureContext implements Context
{
    private $account;


    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {

    }

    /**
     * @Given an overdraft eligible account
     */
    public function anOverdraftEligibleAccount()
    {
        $this->account = new Account(new Customer());
    }

    /**
     * @Then I can agree an overdraft amount with my bank
     */
    public function iCanAgreeAnOverdraftAmountWithMyBank()
    {
        $amount = 500;
        $this->account->agreeOverdraft($amount);
        Assert::assertTrue($this->account->isOverdraftAgreed(), 'Overdraft not agreed');
        Assert::assertEquals($amount,
            $this->account->getOverdraftAmount(),
            'Overdraft agreed amount does n\'t match the one requested');
    }

    /**
     * @Given an account with balance :arg1
     */
    public function anAccountWithBalance($balance)
    {
        $this->anOverdraftEligibleAccount();
        $this->account->deposit((float)$balance);
    }

    /**
     * @Then I can not withdraw money :amount because of insufficient funds
     */
    public function iCanNotWithdrawMoneyBecauseOfInsufficientFunds($amount)
    {
        $amount = (float)$amount;

        try {
            $this->account->withdraw($amount);
            Assert::assertTrue(
                false,
                'Attempting to withdraw money when no funds available did not throw an error');
        } catch (InsufficientFundsException $e) {

        }
    }

    /**
     * @Given overdraft is agreed for amount :amount
     */
    public function overdraftIsAgreedForAmount($amount)
    {
        $amount = (float)$amount;
        $this->account->agreeOverdraft($amount);
    }

    /**
     * @Then I can withdraw money :amount
     */
    public function iCanWithdrawMoney($amount)
    {
        $this->account->withdraw((float)$amount);
    }

    /**
     * @Then account balance after overdraft withdrawal is :amount
     */
    public function accountBalanceAfterOverdraftWithdrawalIs($amount)
    {
        $amount = (float)$amount;
        Assert::assertEquals(
            $amount,
            $this->account->getBalance(),
            'Account balance after overdraft withdraw does n\'t match expected value');
    }

}
