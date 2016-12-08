<?php


use App\Domain\Account;
use App\Domain\Customer;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class OpenAccountFeatureContext implements Context
{
    private $customer;

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
     * @Given a customer
     */
    public function aCustomer()
    {
        $this->customer = new Customer();
    }

    /**
     * @Then I can open an account
     */
    public function iCanOpenAnAccount()
    {
        $this->account = new Account($this->customer);
    }

}
