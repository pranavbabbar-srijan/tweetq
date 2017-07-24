@javascript
Feature: To verify the functionality of recent activity module

@1
Scenario: Create a tweet and the status gets updated in recent activity
	Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
	When I fill in some unique text
	And I press "Tweet Now"
    And I wait for 5 seconds
    And I click on the element with css selector "#notification-display"
    And I wait for 3 seconds
    Then I should see "New Tweet" in the recent_activity
    And I click on the element with css selector "#notification-display"
    And I should see element with xpath "//div[@class='notification-message-list']//div[2]/span[@class='time']"
    And I should see element with xpath "//div[@class='notification-message-list']//div[2]/span[@class='message']"

@2
Scenario:Import file should get updated in recent activity
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@class='import_tweets']/span/a"
    And I wait for 5 seconds
    And I attach the file "Import/Sample.csv" to "edit-managed-file-upload"
    And I press "edit-submit"
    And I wait for 5 seconds
    And I click on the element with css selector "#notification-display"
    And I wait for 3 seconds
    Then I should see "Import" in the recent_activity
    And I click on the element with css selector "#notification-display"
    And I should see element with xpath "//div[@class='notification-message-list']//div[2]/span[@class='time']"
    And I should see element with xpath "//div[@class='notification-message-list']//div[2]/span[@class='message']"

@3
Scenario: Password changed status update in recent activity
	Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@class='profile']/a"
    And I wait for 3 seconds
    And I click on the element with xpath "//a[@class='profile-my-profile']"
    When I fill in "edit-changeuser-password" with "Srijan@123"
    And I click on the element with xpath "//div[@id='change-password']/span"
    And I wait for 10 seconds
    And I click on the element with css selector "#notification-display"
    Then I should see "Password" in the recent_activity
    And I click on the element with css selector "#notification-display"
    And I should see element with xpath "//div[@class='notification-message-list']//div[2]/span[@class='time']"
    And I should see "Password has been changed" in the recent_activity

@4
Scenario: Profile update status in recent activity module
	Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@class='profile']/a"
    And I wait for 3 seconds
    And I click on the element with xpath "//a[@class='profile-my-profile']"
    When I fill in "edit-field-mobile-number" with "9800000000"
    And I fill in "edit-field-job-title" with "Architect"
    And I fill in "edit-field-organization" with "ABC"
    And I fill in "edit-field-website" with "https://twitter.com/"
    And I press the "edit-submit" button
    And I wait for 10 seconds
    And I click on the element with css selector "#notification-display"
    Then I should see "Profile" in the recent_activity
    And I click on the element with css selector "#notification-display"
    And I should see element with xpath "//div[@class='notification-message-list']//div[2]/span[@class='time']"
    And I should see "Profile has been updated"

@5
Scenario: Invite to friend functionality should be updated in recent activity
	Given I am on "/"
	And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@class='profile']/a"
    And I wait for 3 seconds
    And I click on the element with xpath "//a[@class='profile-settings']"
    And I wait for 5 seconds
    When I fill in "edit-invite-friend-list" with "neha.singh@srijan.net"
    And I click on the element with xpath "//div[@id='invite-friends']/span"
    And I wait for 10 seconds
    And I click on the element with css selector "#notification-display"
    Then I should see "Invitation" in the recent_activity
    And I click on the element with css selector "#notification-display"
    And I should see element with xpath "//div[@class='notification-message-list']//div[2]/span[@class='time']"
    And I should see "Invitation sent to neha.singh@srijan.net"




	