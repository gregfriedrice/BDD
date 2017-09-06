Feature: Transferring money between current and premium accounts
  In order to manage my finances
  As a bank customer
  I want to be able to transfer funds between my Current and Premium accounts

  Background:
    Given I have a Current account with balance 200 GBP
    And I have a Premium account with balance 180 GBP

  Scenario: I transfer money from Current to Premium account
    When I transfer 10 GBP from my Current account to my Premium account
    Then my Current account balance should be 190 GBP
    And my Premium account balance should be 190 GBP

  Scenario: I fail to transfer an amount greater than the balance
    When I transfer 210 GBP from my Current account to my Premium account
    Then I should be told I do not have sufficient funds to complete the transfer
    And my Current account balance should be 200 GBP
    And my Premium account balance should be 180 GBP

  Scenario: I am charged a 1% fee for transfers over 100 GBP
    When I transfer 100 GBP from my Current account to my Premium account
    Then my Current account balance should be 99 GBP
    And my Premium account balance should be 280 GBP

  Scenario: I am charged a flat fee of 0.30 GBP to transfer from my Premium account to my Current account
    When I transfer 10 GBP from my Premium account to my Current account
    Then my Current account balance should be 210 GBP
    And my Premium account balance should be 169.70 GBP

  Scenario: I am charged 1% plus a flat fee of 0.30 GBP to transfer more than 100 GBP from Premium to Current
    When I transfer 100 GBP from my Premium account to my Current account
    Then my Current account balance should be 300 GBP
    And my Premium account balance should be 78.70 GBP

  Scenario: Transfers must be a minimum of 5 GBP
    When I transfer 4.99 GBP from my Current account to my Premium account
    Then I should be told the transfer amount is below the minimum
    And my Current account balance should be 200 GBP
    And my Premium account balance should be 180 GBP
