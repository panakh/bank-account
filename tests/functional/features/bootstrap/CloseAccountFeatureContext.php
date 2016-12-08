<?php

use App\Domain\Account;
use App\Domain\ClosedAccountException;
use App\Domain\Customer;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use PHPUnit_Framework_Assert as Assert;

/**
 * Defines application features from the specific context.
 */
class CloseAccountFeatureContext implements Context
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
     * @Given an account
     */
    public function anAccount()
    {
        $this->account = new Account(new Customer());
    }

    /**
     * @Then I can close the account
     */
    public function iCanCloseTheAccount()
    {
        $this->account->close();
    }

    /**
     * @Given a closed account
     */
    public function aClosedAccount()
    {
        $this->anAccount();
        $this->account->close();
    }

    /**
     * @Then I can not see the balance
     */
    public function iCanNotSeeTheBalance()
    {
        try {
            $this->account->getBalance();
            Assert::assertTrue(false, 'Attempting to see balance of a closed account did not throw error');
        } catch (ClosedAccountException $e) {
            Assert::assertEquals(ClosedAccountException::CANNOT_SEE_BALANCE, $e->getMessage());
        }
    }

    /**
     * @Then I can not deposit money
     */
    public function iCanNotDepositMoney()
    {
        try {
            $this->account->deposit(100.00);
            Assert::assertTrue(false, 'Attempting to deposit money to a closed account did not throw error');
        } catch (ClosedAccountException $e) {
            Assert::assertEquals(ClosedAccountException::CANNOT_DEPOSIT_MONEY, $e->getMessage());
        }
    }

    /**
     * @Then I can not withdraw money for this closed account
     */
    public function iCanNotWithdrawMoneyForThisClosedAccount()
    {
        try {
            $this->account->withdraw(100.00);
            Assert::assertTrue(false, 'Attempting to withdraw money from a closed account did not throw error');
        } catch (ClosedAccountException $e) {
            Assert::assertEquals(ClosedAccountException::CANNOT_WITHDRAW_MONEY, $e->getMessage());
        }
    }
}
