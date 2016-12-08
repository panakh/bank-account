Feature: Withdraw Money
  In order to spend money
  As a customer
  I need to be able to withdraw money from my bank account

  Scenario Outline: Can not withdraw an invalid amount
    Given a withdrawal amount <amount>
    Then I can not make a withdraw
    Examples:
      | amount |
      | 0      |
      | -1     |

  Scenario Outline: Can deposit a valid amount
    Given a deposit amount <amount>
    When I make a deposit
    Then account balance after deposit is <amount>
    Examples:
      | amount |
      | 100    |
      | 200    |