Feature: Close Account
  In order to make my life easier
  As a customer
  I need to be able to close a bank account when needed

  Scenario: Successful closing
    Given an account
    Then I can close the account

  Scenario: Can not see balance of a closed account
    Given a closed account
    Then I can not see the balance

  Scenario: Can not see deposit funds to a closed account
    Given a closed account
    Then I can not deposit money

  Scenario: Can not see withdraw funds from closed account
    Given a closed account
    Then I can not withdraw money for this closed account