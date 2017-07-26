@javascript
Feature: To verify the functionality of invalid tweet

@1
Scenario: Click on invalid tweet should navigate to different page
	Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[3]"
    Then the url should match "dashboard/invalid-tweets"

@2
 Scenario: Verify the hover text of edit element
	Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[3]"
    Then the url should match "dashboard/invalid-tweets"
    When I hover over the element by Xpath "//div[@id='block-usersinvalidtweetsblock']//div[@class='item-list'][2]/ul/li[1]//a[contains(@href,'edit')]"
    And I wait for 5 seconds
    Then I should see text matching "Click here to edit your Tweet"

@3
 Scenario: Verify the hover text of delete element
 	Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[3]"
    Then the url should match "dashboard/invalid-tweets"
    When I hover over the element by Xpath "//div[@id='block-usersinvalidtweetsblock']//div[@class='item-list'][2]/ul/li[1]//a[contains(@href,'delete')]"
    And I wait for 5 seconds
    Then I should see text matching "Click here to delete your Tweet"

@4
 Scenario: When Tweet is more than 140 charachters , then Invalid and Total tweet incremented
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    Then I fetch text for invalid tweet
    And I fetch text for total tweet
	Then I fill in invalid tweet
	And I press "edit-save"
    Then Invalid Tweet incremented
    And Total Tweet incremented

@5
Scenario: To verify on click of invalid tweet in header , invalid tweet option in left slider should be active
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
   When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[3]"
    Then the url should match "dashboard/invalid-tweets"
    Then I should see element with css "div.invalid_tweets a.active"
    
@6

Scenario:If size of tweet is more than 140 , its invalid tweet
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
   When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[3]"
    Then the url should match "dashboard/invalid-tweets"
    And I wait for 10 seconds
    And tweet is invalid "//div[@id='block-usersinvalidtweetsblock']/div/div[2]/ul/li[1]/div/ul/li[4]"

@7
Scenario: Delete Functionality
     Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[3]"
    Then the url should match "dashboard/invalid-tweets"
    And I fetch text for invalid tweet
    When I click on the element with xpath "//div[@id='block-usersinvalidtweetsblock']//div[@class='item-list'][2]/ul/li[1]//a[contains(@href,'delete')]"
    And I wait for 5 seconds
    And I press the "edit-clone" button
    And I wait for 10 seconds
    Then I should see text matching "Tweet Deleted Successfully"
    And invalid tweet gets decremented 

@8
Scenario: Latest Created on should be top of the list
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[3]"
    Then the url should match "dashboard/invalid-tweets"
    Then latest created date for Invalid Tweet is on top 

@9
Scenario: Edit the tweet to less than 140 characters and save as valid tweet
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[2]"
    And I fetch text for new tweet
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[3]"
    Then the url should match "dashboard/invalid-tweets"
    And I fetch text for invalid tweet
    When I click on the element with xpath "//div[@id='block-usersinvalidtweetsblock']//div[@class='item-list'][2]/ul/li[1]//a[contains(@href,'edit')]"
    And I wait for 5 seconds
    # Then invalid tweet can be saved if characters are removed
    And I click on the element with xpath "//textarea[@id='edit-message']"
    # Then I fill in "message" with "Hi Neha123"
   And I fill in some unique text
    And I press the "Save Tweet" button
     And I wait for 10 seconds
     And invalid tweet gets decremented
     Then I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[2]"
    Then new Tweet incremented

@10
Scenario:To edit invalid tweet and save the tweet
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[3]"
    Then the url should match "dashboard/invalid-tweets"
    When I click on the element with xpath "//div[@id='block-usersinvalidtweetsblock']//div[@class='item-list'][2]/ul/li[1]//a[contains(@href,'edit')]"
    And I wait for 5 seconds
    Then tweet is edited
    And I wait for 5 seconds
    And I press the "edit-submit" button
    And I wait for 5 seconds
    Then I should see text matching "Tweet have been saved successfully"

@11
Scenario: To fetch count of Invalid tweet
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[3]"
    And I fetch text for invalid tweet


@12
Scenario: Tweet now button gets enabled when invalid tweet is edited and charchters is less than 140
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[3]"
    Then the url should match "dashboard/invalid-tweets"
    When I click on the element with xpath "//div[@id='block-usersinvalidtweetsblock']//div[@class='item-list'][2]/ul/li[1]//a[contains(@href,'edit')]"
    And I wait for 5 seconds
    And I fill in some unique text
    Then I check button is disabled "//input[@id='edit-tweet-now']"

@13
Scenario: Tweet the invalid tweet 
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[3]"
    Then the url should match "dashboard/invalid-tweets"
    And I fetch text for invalid tweet
    And I fetch text for valid tweet
    When I click on the element with xpath "//div[@id='block-usersinvalidtweetsblock']//div[@class='item-list'][2]/ul/li[1]//a[contains(@href,'edit')]"
    And I wait for 5 seconds
    And I fill in some unique text
    And I press "edit-submit"
    And I wait for 5 seconds
    Then invalid tweet gets decremented
    And Valid Tweet incremented


@14
 Scenario: If tweet is invalid , tweet now button is disabled
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I fill in "edit-message" with "First invalid cddtweet to be be createdFirst invalid tweet to be be createdFirst invalid tweet to be be createdFirst invalid tweet to be be createddfdccd"
    And I wait for 5 seconds
    Then I check button is disabled "//input[@id='edit-submit']"


@15
 Scenario: When tweet is more than 140 charchters , then exceeding text color should be red
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    And I wait for 5 seconds
    When I fill in "edit-message" with "First invalid tweet to be be createdFirst invalid tweet to be be createdFirst invalid tweet to be be createdFirsttweet  First invalid tweet to be be createdFirsttweetjkdhjckjd"
    Then I should see element with css ".js-keeper-placeholder-back>em"
    