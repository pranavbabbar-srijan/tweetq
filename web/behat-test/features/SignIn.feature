
Feature: Sign in Functionaity

@javascript @1
Scenario: Sign in the application with valid username
		Given I am on "./"
		And I wait for 5 seconds
		When I fill in "edit-name" with "nehasingh767@gmail.com"
		And I fill in "edit-pass" with "Srijan@123"
		And I press "Log in"
		And I wait for 5 seconds
        Then the url should match "/dashboard" 

@javascript @2
Scenario: Sign in the application with invalid username
		Given I am on "./"
		And I wait for 5 seconds
		When I fill in "edit-name" with "nehasingh77@gmail.com"
		And I fill in "edit-pass" with "abc"
		And I wait for 5 seconds
		Then I should see text matching "You are yet to sign-up with us"

Scenario: Sign in the application with invalid password
		Given I am on "./"
		When I fill in "edit-name" with "nehasingh767@gmail.com"
		And I fill in "edit-pass" with "Srian@123"
		And I press "Log in"
		And I wait for 5 seconds
		Then I should see text matching "Unrecognized username or password."

@javascript @4
Scenario:When user login for !st time , should authorise by twitter
		Given I am on "./"
		And I wait for 5 seconds
		When I fill in "edit-name" with "nehasingh767@gmail.com"
		And I fill in "edit-pass" with "Srijan@123"
		And I press "Log in"
		And I wait for 5 seconds
        Then the url should match "/dashboard"
        Then I click on the element with xpath "//div[@id='block-signinwithtwitterblock']//span[@class='twitter-connect']"
        And I wait for 5 seconds
        When I fill in "edit-name" with "nehasingh767@gmail.com"
		And I fill in "edit-pass" with "Srijan@123"
