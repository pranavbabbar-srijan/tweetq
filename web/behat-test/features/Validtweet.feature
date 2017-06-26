@javascript
Feature: To check the functionality of ValidTweet

@1
Scenario: Click on valid tweet should navigate to different page
    Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[2]"
   Then the url should match "/dashboard/valid-tweets"

@2
 Scenario: Verify the hover text of edit element
	Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[2]"
    Then I am on "/dashboard/valid-tweets"
    When I hover over the element by Xpath "//div[@id='block-usersvalidtweetsblock']//div[@class='item-list'][2]/ul/li[1]//a[contains(@href,'edit')]"
    And I wait for 5 seconds
    Then I should see text matching "Click here to edit your Tweet"

@3
 Scenario: Verify the hover text of delete element
 	Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[2]"
    Then I am on "/dashboard/valid-tweets"
    When I hover over the element by Xpath "//div[@id='block-usersvalidtweetsblock']//div[@class='item-list'][2]/ul/li[1]//a[contains(@href,'delete')]"
    And I wait for 5 seconds
    Then I should see text matching "Click here to delete your Tweet"

@4
Scenario: If no New tweets found
    Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[2]"
    Then I am on "/dashboard/valid-tweets"
    And I fetch text for no tweet found

@5
Scenario: To verify sum of new tweets and tweeted should be equivalent to valid tweet
   Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[2]"
    Then I am on "/dashboard/valid-tweets"
    Then sum of new tweets and tweeted equivalent to valid tweets

@6
Scenario: To verify on click of Valid tweet in header , valid tweet option in left slider should be active
    Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[2]"
    Then I am on "/dashboard/valid-tweets"
    Then I should see element with css "div.valid_tweets a.active"

    @7
    Scenario: If New tweets found
    Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[2]"
    Then I am on "/dashboard/valid-tweets"
    Then I should see "Message" in the "header"
    And I should see "Size" in the "header"
    And I should see "Created On" in the "header"
    And I should see "Updated On" in the "header"
    And I should see "Modify" in the "header"


@8
Scenario: Edit functionality
    Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[2]"
    Then I am on "/dashboard/valid-tweets"
    When I click on the element with xpath "//div[@id='block-usersvalidtweetsblock']//div[@class='item-list'][2]/ul/li[1]//a[contains(@href,'edit')]"
    And I wait for 5 seconds
    And I fill in some unique text 
    And I press "Save Tweet"
    Then I should see text matching "Tweet have been saved successfully"


@9
Scenario: Delete Functionality
     Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[2]"
    Then I am on "/dashboard/valid-tweets"
    And I fetch text for valid tweet
    When I click on the element with xpath "//div[@id='block-usersvalidtweetsblock']//div[@class='item-list'][2]/ul/li[1]//a[contains(@href,'delete')]"
    And I wait for 5 seconds
    And I press the "Delete Anyway" button
    Then I should see text matching "Tweet Deleted Successfully"
    And valid tweet gets decremented 

@10
    Scenario:Verify the size of tweet
    Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[2]"
    Then I am on "/dashboard/valid-tweets"
    And I click on the element with xpath "//div[@id='block-usersvalidtweetsblock']//a[2]"
    And Size of Tweet "//div[@id='block-userstweetedtweetsblock']//div[@class='item-list'][2]/ul/li[1]//div[@class='item-list']/ul"


@11

Scenario: Latest Created on should be top of the list
    Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[2]"
    And I wait for 5 seconds
    Then the url should match "/dashboard/valid-tweets"
    And I click on the element with xpath "//div[@id='block-usersvalidtweetsblock']//a[2]"
    Then latest created date for Valid Tweet is on top 


