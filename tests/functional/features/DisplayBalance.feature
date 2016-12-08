Feature: Display Balance
  In order to manage my money
  As a customer
  I need to be able to see my balance

  Scenario: Zero opening balance
    Given an account with balance
    Then opening balance is zero

  Scenario Outline: Zero opening balance
    Given an account with balance
    And I deposit <amount>
    Then account balance is <amount>
    Examples:
      | amount |
      | 10     |
      | 20     |
      | 30     |

