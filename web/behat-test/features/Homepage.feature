@javascript
Feature: To check the functionality of homepage 
@1
Scenario: Elements visible on hero header
   Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    And I wait for 10 seconds
    Then I should see the link "Barbet"
    And I should see element with css "#notification-display"
    And I should see text matching "Neha singh"
    And I should see text matching "Total Tweets"
    And I should see text matching "Valid Tweets"
    And I should see text matching "Invalid Tweets"
    And I should see text matching "Archived Tweets"


@2
  Scenario:To verify Total tweets is sum of Valid,Invalid,Archived Tweets
   Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    Then Total tweet matches with sum of other tweets