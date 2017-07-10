Feature: To verify the functionality of Profile page

@javascript @1
Scenario: Click on My Profile should navigate to my profile page
	Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    When I click on the element with xpath "//div[@class='profile']/a"
    And I wait for 3 seconds
    And I click on the element with xpath "//a[@class='profile-my-profile']"
    Then the url should match "/dashboard/my-profile"

@2
Scenario: To verify the elements visible on profile page
	Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    When I click on the element with xpath "//div[@class='profile']/a"
    And I wait for 3 seconds
    And I click on the element with xpath "//a[@class='profile-my-profile']"
    Then I should see text matching "Full Name"
    And I should see text matching "Email"
    And I should see text matching "Twitter Username"
    And I should see text matching "Password"
    And I should see text matching "Mobile Number"
    And I should see text matching "Job Title"
    And I should see text matching "Organization Name"
    And I should see text matching "Website"
    And I should see the button "Update Profile"

@3
Scenario: To verify Full name, Email,Twitter Username are read only
	Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    When I click on the element with xpath "//div[@class='profile']/a"
    And I wait for 3 seconds
    And I click on the element with xpath "//a[@class='profile-my-profile']"
	Then element is readonly "//input[@id='edit-field-full-name']"
	Then element is readonly "//input[@id='edit-twitter-screen']"
	Then element is readonly "//input[@id='edit-email']"
	

@javascript @4
Scenario: To verify Password change functionality in profile page
	Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    When I click on the element with xpath "//div[@class='profile']/a"
    And I wait for 3 seconds
    And I click on the element with xpath "//a[@class='profile-my-profile']"
    When I fill in "edit-changeuser-password" with "Srijan@123"
    And I click on the element with xpath "//div[@id='change-password']/span"
    Then I should see text matching "Password Changed successfully"

@5
Scenario: To verify the update profile functionality
	Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    When I click on the element with xpath "//div[@class='profile']/a"
    And I wait for 3 seconds
    And I click on the element with xpath "//a[@class='profile-my-profile']"
    When I fill in "edit-field-mobile-number" with "9800000000"
    And I fill in "edit-field-job-title" with "Architect"
    And I fill in "edit-field-organization" with "ABC"
    And I fill in "edit-field-website" with "https://twitter.com/"
    And I press the "edit-submit" button
    Then I should see text matching "Profile has been updated"
