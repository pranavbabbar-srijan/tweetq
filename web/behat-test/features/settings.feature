@javascript

Feature: To verify the functionality of settings page

@1
Scenario: Click on settings should navigate to settings page 
# ( edited for different user as the page url will vary on users)
 	Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@class='profile']/a"
    And I wait for 3 seconds
    And I click on the element with xpath "//a[@class='profile-settings']"
    And I wait for 5 seconds
    Then the url should match "user/390/edit"

@2
Scenario: Elements visible on settings page
	Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@class='profile']/a"
    And I wait for 3 seconds
    And I click on the element with xpath "//a[@class='profile-settings']"
    And I wait for 5 seconds
    Then I should see text matching "Time zone"
    And I should see text matching "Country"
    And I should see text matching "Invite friends to join Barbet"
    And I should see element with css ".invite-friend"
    And I should see the "edit-submit" button

@3
Scenario: Invite friends functionality
	Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@class='profile']/a"
    And I wait for 3 seconds
    And I click on the element with xpath "//a[@class='profile-settings']"
    And I wait for 5 seconds
    When I fill in "edit-invite-friend-list" with "neha.singh@srijan.net"
    And I click on the element with xpath "//div[@id='invite-friends']/span"
    Then I should see "Friend invitation email sent successfully"
     Then I should see "Friend invitation email sent successfully"


