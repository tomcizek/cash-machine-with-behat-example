Feature: Card Holder withdraws cash
  As an Card Holder
  I want to withdraw cash from an ATM
  So that I can get money when the bank is closed

  Scenario: 1: Card has sufficient funds
    Given the card balance is cZK 100
    And the card is valid
    And the machine contains enough money
    When the Card Holder requests cZK 20
    Then the ATM should dispense cZK 20
    And the card balance should be cZK 80
    And the card should be returned


  Scenario: 2: Card has insufficient funds
    Given the card balance is cZK 10
    And the card is valid
    And the machine contains enough money
    When the Card Holder requests cZK 20
    Then the ATM should not dispense any money
    And the ATM should say there are insufficient funds
    And the card balance should be cZK 10
    And the card should be returned


  Scenario: 3: Card has been disabled
    Given the card is disabled
    When the Card Holder requests cZK 20
    Then the ATM should retain the card
    And the ATM should say the card has been retained
