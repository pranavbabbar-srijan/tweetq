@javascript
Feature: Signout functionality

Scenario: To verify the functionality of Signout feature
	Given I am on "/"
	And I login with valid username and password
    And I wait for 5 seconds
    And the url should match "/dashboard"
    When I click on the element with xpath "//div[@class='profile']/a"
    And I click on the element with xpath "//a[@class='profile-logout']"
    And I wait for 5 seconds
    Then the url should match "/"
