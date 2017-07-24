
@javascript
Feature: Sign in Functionaity

@1
Scenario: Sign in the application with valid username
		Given I am on "./"
		And I wait for 5 seconds
		When I fill in "edit-name" with "nehasingh767@gmail.com"
		And I fill in "edit-pass" with "Srijan@123"
		And I press "Log in"
		And I wait for 5 seconds
        Then the url should match "/dashboard" 

 @2
Scenario: Sign in the application with invalid username
		Given I am on "./"
		And I wait for 5 seconds
		When I fill in "edit-name" with "nehasingh77@gmail.com"
		And I fill in "edit-pass" with "abc"
		And I wait for 5 seconds
		Then I should see text matching "You are yet to sign-up with us"

@3
Scenario: Sign in the application with invalid password
		Given I am on "./"
		When I fill in "edit-name" with "nehasingh767@gmail.com"
		And I fill in "edit-pass" with "Srian@123"
		And I press "Log in"
		And I wait for 5 seconds
		Then I should see text matching "Unrecognized username or password."

 @4
Scenario:When user login for 1st time , should authorise by twitter and all the tabs are disabled
		Given I am on "./"
		And I wait for 5 seconds
		When I fill in "edit-name" with "barbet1@mailinator.com"
		And I fill in "edit-pass" with "123"
		And I press "Log in"
		And I wait for 5 seconds
        Then the url should match "/dashboard"
        And I wait for 5 seconds
        And I should see element with xpath "//div[@id='non-twitter-profile']"
        Then I click "Connect with Twitter"
        And I wait for 5 seconds
        When I fill in "username_or_email" with "usertesting14"
		And I fill in "password" with "Srijan@123"
		And I press the "Authorize app" button 
		Then the url should match "/dashboard"
