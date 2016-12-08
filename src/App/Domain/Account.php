<?php

namespace App\Domain;

class Account
{
    private $balance;
    private $closed = false;
    private $overdraftAmount = 0;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function close()
    {
        $this->closed = true;
    }

    public function getBalance()
    {
        if ($this->closed) {
            throw new ClosedAccountException(ClosedAccountException::CANNOT_SEE_BALANCE);
        }

        return $this->balance;
    }

    public function deposit($money)
    {
        if ($this->closed) {
            throw new ClosedAccountException(ClosedAccountException::CANNOT_DEPOSIT_MONEY);
        }

        $this->validateTransactionAmount($money);

        $this->balance += $money;
    }

    public function isClosed()
    {
        return $this->closed == true;
    }

    public function withdraw($money)
    {
        if ($this->closed) {
            throw new ClosedAccountException(ClosedAccountException::CANNOT_WITHDRAW_MONEY);
        }

        $this->validateTransactionAmount($money);
        if ($this->balance < $money) {

            if (!$this->isOverdraftAgreed()) {
                throw new InsufficientFundsException();
            }

            if ($money > $this->balance + $this->overdraftAmount) {
                throw new InsufficientFundsException();
            }

            $this->balance = $this->balance - $money;
        } else {
            $this->balance = $this->balance - $money;
        }
    }

    private function validateTransactionAmount($money)
    {
        if (!is_numeric($money)) {
            throw new InvalidTransactionAmountException(InvalidTransactionAmountException::NON_NUMBER);
        }

        if ($money == 0) {
            throw new InvalidTransactionAmountException(InvalidTransactionAmountException::ZERO_AMOUNT);
        }

        if ($money == -1) {
            throw new InvalidTransactionAmountException(InvalidTransactionAmountException::NEGATIVE_AMOUNT);
        }
    }

    public function agreeOverdraft($amount)
    {
        $this->validateTransactionAmount($amount);
        $this->overdraftAmount = $amount;
    }

    public function isOverdraftAgreed()
    {
        if ($this->overdraftAmount > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getOverdraftAmount()
    {
        return $this->overdraftAmount;
    }

    public function __toString()
    {
        return json_encode(get_object_vars($this), JSON_PRETTY_PRINT);
    }

}