<?php

use App\Domain\Account;
use App\Domain\ClosedAccountException;
use App\Domain\Customer;
use App\Domain\InvalidTransactionAmountException;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use PHPUnit_Framework_Assert as Assert;

/**
 * Defines application features from the specific context.
 */
class WithdrawMoneyFeatureContext implements Context
{
    private $account;
    private $amount;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->account = new Account(new Customer());
    }

    /**
     * @Given a withdrawal amount :amount
     */
    public function aWithdrawalAmount($amount)
    {
        $this->amount = (float)$amount;
    }

    /**
     * @Then I can not make a withdraw
     */
    public function iCanNotMakeAWithdraw()
    {
        try {
            $this->account->withdraw($this->amount);
            Assert::assertTrue(false, 'Attempting to withdraw an invalid amount did not throw error');
        } catch (InvalidTransactionAmountException $e) {
        }
    }
}
