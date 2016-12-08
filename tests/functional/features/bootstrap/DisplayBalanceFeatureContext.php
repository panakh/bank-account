<?php

use App\Domain\Account;
use App\Domain\Customer;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use PHPUnit_Framework_Assert as Assert;

/**
 * Defines application features from the specific context.
 */
class DisplayBalanceFeatureContext implements Context
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
     * @Given an account with balance
     */
    public function anAccountWithBalance()
    {
        $this->account = new Account(new Customer());
    }

    /**
     * @Then opening balance is zero
     */
    public function openingBalanceIsZero()
    {
        $balance = $this->account->getBalance();
        Assert::assertEquals(0, $balance, 'Balance not zero');
    }

    /**
     * @Given I deposit :arg1
     */
    public function iDeposit($money)
    {
        $money = (float)$money;
        $this->account->deposit($money);
    }

    /**
     * @Then account balance is :expectedBalance
     */
    public function accountBalanceIs($expectedBalance)
    {
        $balance = $this->account->getBalance();
        $expectedBalance = (float)$expectedBalance;
        Assert::assertEquals($expectedBalance, $balance, 'Unexpected balance');
    }

}
