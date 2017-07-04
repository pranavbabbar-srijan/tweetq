Feature:Sign up functionality

@1
Scenario: Sign up functionality
Given I am on "./"
When I click "Sign up"
Then the url should match "/signup"

@javascript @2
Scenario: Fill all the fields and click on submit button
Given I am on "/signup"
When I fill in "Full Name" with "Neha Singh"
And I fill in "Email" with "nehasingh767@gmail.com"
And I fill in "Password" with "Srijan@123"
#And I fill in "Website" with "http://Twitter.com"
And I fill in "Organization Name" with "srijan"
And I press "Submit"
Then I should see text matching "An email notification has been sent to nehasingh767@gmail.com"

@3
Scenario: To check the elements visible on Signup page
Given I am on "/signup"
Then I should see text matching "barbet"
And I should see text matching "Sign up with Twitter"
And I should see text matching "Sign up"
And I should see text matching "Full Name"
And I should see text matching "Email"
And I should see text matching "Password"
And I should see text matching "Website"
And I should see text matching "Organization Name"
And I should see the button "Submit"   

@javascript @4
Scenario:To check if able to sign up with optional field blank
Given I am on "/signup"
When I fill in "edit-field-full-name" with "Surbhi gupta"
And I fill in "Email" with "surbhi.gupta@srijan.net"
And I fill in "Password" with "Srijan@123"
And I press "Submit"
And I wait for 5 seconds
Then I should see text matching "An email notification has been sent to surbhi.gupta@srijan.net"

@javascript @5
Scenario: To get error during sign up while keeping all the field empty
Given I am on "/signup"
When I press "Submit"
Then I should see text matching "Please enter full name"
And I should see text matching "Please enter your email ID"
And I should see text matching "Please enter the password"


@javascript @6
Scenario:To get error when sign up with existing user
Given I am on "/signup"
When I fill in "edit-field-full-name" with "Neha Singh"
And I fill in "Email" with "neha.singh@srijan.net"
And I fill in "Password" with "Srijan@123"
And I press "Submit"
And I wait for 5 seconds
Then I should see text matching "Email ID already exist"

