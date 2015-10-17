Feature: Get recommendations

  Scenario: gets valid recommendations
    Given I have a service description
    When I request recommendations for id "1" and with a limit of "30"
    Then I should receive 2 recommendations

  Scenario: handles 404
    Given I have a service description
    When I request recommendations for id "5" and with a limit of "30"
    Then I should have an exception for an unknown id

  Scenario: gets valid recommendations
    Given I have a service description
    When I request recommendations for id "6" and with a limit of "30"
    Then I should have an exception for a server failure
