@javascript
Feature: To verify the functionality of settings page
@1
Scenario: Click on settings should navigate to settings page
 	Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    When I click on the element with xpath "//div[@class='profile']/a"
    And I wait for 3 seconds
    And I click on the element with xpath "//a[@class='profile-settings']"
    Then the url should match "/dashboard/settings"

@2
Scenario: Elements visible on settings page
	Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    When I click on the element with xpath "//div[@class='profile']/a"
    And I wait for 3 seconds
    And I click on the element with xpath "//a[@class='profile-settings']"
    Then I should see text matching "Time zone"
    And I should see text matching "Country"
    And I should see text matching "Invite friends to join Barbet"
    And I should see the "Invite" button
    And I should see the "edit-submit" button

@3
Scenario: Invite friends functionality
	Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    When I click on the element with xpath "//div[@class='profile']/a"
    And I wait for 3 seconds
    And I click on the element with xpath "//a[@class='profile-settings']"
    When I fill in "edit-invite-friend-list" with "neha.singh@srijan.net"
    And I wait for 3 seconds
    Then I should see text matching "Friend invitation sent successfully"


