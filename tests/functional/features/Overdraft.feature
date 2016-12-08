Feature: Overdraft
  In order to cover my bills when my account balance is insufficient
  As a customer
  I need to be able to use my overdraft facility

  Scenario: Agreeing to an overdraft
    Given an overdraft eligible account
    Then I can agree an overdraft amount with my bank

  Scenario Outline: Withdrawing when balance is insufficient and overdraft does n't cover
    Given an account with balance <balance>
    Then I can not withdraw money <withdrawal_amount> because of insufficient funds
    Examples:
      | balance | withdrawal_amount |
      | 10      | 20                |
      | 15      | 30                |

  Scenario Outline: Can not withdraw over the overdraft limit
    Given an account with balance <balance>
    And overdraft is agreed for amount <overdraft_amount>
    Then I can not withdraw money <withdrawal_amount> because of insufficient funds
    Examples:
      | balance | overdraft_amount | withdrawal_amount |
      | 10      | 20               | 40                |
      | 15      | 30               | 50                |

  Scenario Outline: Can withdraw when overdraft is available
    Given an account with balance <balance>
    And overdraft is agreed for amount <overdraft_amount>
    Then I can withdraw money <withdrawal_amount>
    And account balance after overdraft withdrawal is <new_balance>
    Examples:
      | balance | overdraft_amount | withdrawal_amount | new_balance |
      | 10      | 20               | 15                | -5          |
      | 15      | 30               | 40                | -25         |