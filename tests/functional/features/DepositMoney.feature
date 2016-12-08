Feature: Deposit Money
  In order to save money
  As a customer
  I need to be able to deposit money into my account

  Scenario Outline: Can not deposit an invalid amount
    Given a deposit amount <amount>
    Then I can not make a deposit
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

  Scenario Outline: Can deposit a valid amount
    Given existing account balance is <balance>
    And a deposit amount <amount>
    When I make a deposit
    Then account balance after deposit is <new_balance>
    Examples:
      | balance | amount                       | new_balance                  |
      | 100     | 20                           | 120                          |
      | 1       | 1000000000000000000000000000 | 1000000000000000000000000001 |
      | -10     | 10                           | 0                            |


