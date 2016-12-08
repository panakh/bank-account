#!/usr/bin/env php
<?php

use App\Domain\Account;
use App\Domain\ClosedAccountException;
use App\Domain\Customer;
use App\Domain\InsufficientFundsException;

require __DIR__.'/vendor/autoload.php';

//In addition to this try changing parameters in behat feature files to see the behaviour

$account = new Account(new Customer());
$account->deposit(10);
echo $account;
echo "\n";

$account->agreeOverdraft(20);
echo $account;
echo "\n";

$account->withdraw(10);
echo $account;
echo "\n";

$account->withdraw(20);
echo $account;
echo "\n";

try {
    $account->withdraw(10);
} catch (InsufficientFundsException $e) {
    echo $e->getMessage() . "\n";
}
echo "\n";

$account->close();
echo $account;
echo "\n";

try {
    $account->withdraw(10);
} catch (ClosedAccountException $e) {
    echo $e->getMessage() . "\n";
}
echo "\n";


try {
    $account->deposit(10);
} catch (ClosedAccountException $e) {
    echo $e->getMessage() . "\n";
}
echo "\n";

