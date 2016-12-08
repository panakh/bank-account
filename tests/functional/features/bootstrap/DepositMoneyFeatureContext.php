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
class DepositMoneyFeatureContext implements Context
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
     * @Given a deposit amount :amount
     */
    public function aDepositAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @Then I can not make a deposit
     */
    public function iCanNotMakeADeposit()
    {
        try {
            $this->account->deposit($this->amount);
            Assert::assertTrue(false, 'Attempting to deposit an invalid amount did not throw error');
        } catch (InvalidTransactionAmountException $e) {
        }
    }

    /**
     * @When I make a deposit
     */
    public function iMakeADeposit()
    {
        $this->account->deposit($this->amount);
    }

    /**
     * @Then account balance after deposit is :amount
     */
    public function accountBalanceAfterDepositIs($amount)
    {
        Assert::assertEquals((float)$amount, $this->account->getBalance(), 'Unexpected account balance');
    }

    /**
     * @Given existing account balance is :amount
     */
    public function existingAccountBalanceIs($amount)
    {
        $this->account->deposit((float)$amount);

    }


}
