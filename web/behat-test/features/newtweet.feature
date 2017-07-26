@javascript
Feature: To check the functionality of New tweets

@1
Scenario: Click on valid tweets then 'New tweets' will be active
    Given I am on "/"
	And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[2]"
 	Then I should see element with css ".new_tweets.active"

 @2
 Scenario: Create a valid tweet and click on save for later , tweet moved to New tweet
 Given I am on "/"
 	And I login with valid username and password
    And I wait for 5 seconds
    Then I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[2]"
    And I fetch text for new tweet
    Then I click on the element with xpath "//div[@class='create_tweets']//a"
	When I fill in some unique text
	And I press "edit-save"
	And I wait for 5 seconds
	Then I should see text matching "Tweet has been moved to valid tweets and saved for later."
	And I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[2]"
	And new tweet incremented

@3
Scenario: User will upload csv file then all the valid tweets will move to 'new tweets'.
Given I am on "/"
	And I login with valid username and password
    And I wait for 5 seconds
    Then I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[2]"
    And I fetch text for new tweet
    When I click on the element with xpath "//div[@class='import_tweets']/span/a"
    And I attach the file "Import/Sample3.csv" to "edit-managed-file-upload"
    And I press "edit-submit"
    Then I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[2]"	
    Then new tweet updated

@4
Scenario: Edit the 'tweeted' tweet upto 140 character then tweet moves to 'new tweets'
    Given I am on "/"
	And I login with valid username and password
    And I wait for 5 seconds
    Then I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[2]"
    And I click on the element with xpath "//div[@class='valid-tweets-header']//a[2]"
    And I fetch text for tweeted tweet
    And I fetch text for new tweet
    When I click on the element with xpath "//div[@id='block-userstweetedtweetsblock']//div[@class='item-list'][2]/ul/li[1]//a[contains(@href,'edit')]"
    And I wait for 5 seconds
    And I fill in some unique text 
    And I press "edit-clone"
    Then tweeted decremented
    And new tweet incremented
