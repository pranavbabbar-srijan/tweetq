@javascript
Feature: Create a tweet functionality

  @1

 Scenario: To create a tweet with less than 140 charachters 

    Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    And I wait for 5 seconds
	When I fill in some unique text
	And I press "Tweet Now"
	Then I should see text matching "Tweet shared and stored in valid tweets successfully."

@2
 Scenario: To create tweet more than 140 charachters 
	Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    And I wait for 5 seconds
	When I fill in "edit-message" with "First invalid tweet to be be createdFirst invalid tweet to be be createdFirst invalid tweet to be be createdFirst invalid tweet to be be created"
	
 @3
 Scenario: To check if valid tweet created ,then total tweets and valid tweets should be incremented by 1
    Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    Then I fetch text for valid tweet  
    When I fill in some unique text
	And I press "Tweet Now"
	Then Valid Tweet and Total tweet should get incremented

	@4
 Scenario: To check if invalid tweet created ,then total tweets and invalid tweets should be incremented and Tweet now is disabled
    Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    Then I fetch text for invalid tweet 
    When I fill in "edit-message" with "First invalid tweet to be be createdFirst invalid tweet to be be createdFirst invalid tweet to be be createdFirst invalid tweet to be be createddfdccd"
    And I press "edit-save"
    Then InValid Tweet should get incremented
    And I check Tweet Now is disabled

    @5
 Scenario: Click on Create Tweet should navigate to different page
    Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    Then I should be on "/dashboard"

  