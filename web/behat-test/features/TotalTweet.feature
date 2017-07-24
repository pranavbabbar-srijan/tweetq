@javascript
Feature: To check the functionality of Total Tweet 

Scenario: Click on Total Tweets should navigate to all tweets page
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[1]"
    Then the url should match "dashboard/all-tweets"

@2
Scenario: Verify columns listed on All Tweets page
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[1]"
    And I am on "dashboard/all-tweets"
    Then I should see "Message" in the "header"
    And I should see "Size" in the "header"
    And I should see "Created On" in the "header"
    And I should see "Tweeted On" in the "header"
    And I should see "Updated On" in the "header"
    And I should see "Retweeted" in the "header"
    And I should see "Modify" in the "header"
   
@3
  Scenario: Verify the hover text of edit element
	Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[1]"
    And I am on "dashboard/all-tweets"
    When I hover over the element by Xpath "//div[@id='block-usersalltweetsblock']//div[@class='item-list'][2]/ul/li[1]//a[contains(@href,'edit')]"
    And I wait for 5 seconds
    Then I should see text matching "Click here to edit your Tweet"

@4
 Scenario: Verify the hover text of delete element
 	Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[1]"
    And I am on "dashboard/all-tweets"
    When I hover over the element by Xpath "//div[@id='block-usersalltweetsblock']//div[@class='item-list'][2]/ul/li[1]//a[contains(@href,'delete')]"
    And I wait for 5 seconds
    Then I should see text matching "Click here to delete your Tweet"

@5
 Scenario: Latest Created On should be top of the list
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[1]"
    And I wait for 5 seconds
    Then latest created date for Total Tweet is on top 


@6
Scenario: Edit functionality
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[1]"
    And I am on "dashboard/all-tweets"
    When I click on the element with xpath "//div[@id='block-usersalltweetsblock']//div[@class='item-list'][2]/ul/li[1]//div[@class='item-list']//a[contains(@href,'edit')]"
    And I wait for 5 seconds
    And I fill in some unique text 
    And I press "Save"
    And I wait for 5 seconds
    Then I should see text matching "Tweet have been saved successfully. "


@7
Scenario: Delete Functionality
     Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[1]"
    And I am on "dashboard/all-tweets"
    And I fetch text for total tweet
    When I click on the element with xpath "//div[@id='block-usersalltweetsblock']//div[@class='item-list'][2]/ul/li[1]//a[contains(@href,'delete')]"
    And I wait for 5 seconds
    And I press the "Delete Anyway" button
    And I wait for 5 seconds
    Then I should see text matching "Tweet Deleted Successfully"
    And total tweet gets decremented 

   @8
  Scenario:Verify the size of tweet
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[1]"
    And I am on "dashboard/all-tweets"
    And Size of Tweet "//div[@id='block-usersalltweetsblock']//div[@class='item-list'][2]/ul/li[1]//ul"  


 @9
 Scenario: Verify the count of Total tweet
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[1]"
    And I fetch text for total tweet

@10
Scenario: Functionality for multiple deletion
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[1]"
    And I wait for 5 seconds
    Then I fetch text for total tweet
    And I click on the element with css selector "div.content>.item-list:nth-child(2)>ul>li:nth-child(1)>div>ul>li:nth-child(1)>span"
    And I click on the element with css selector "div.content>.item-list:nth-child(2)>ul>li:nth-child(2)>div>ul>li:nth-child(1)>span"
    And I click on the element with css selector "div.content>.item-list:nth-child(2)>ul>li:nth-child(3)>div>ul>li:nth-child(1)>span"
    And I press "Delete Selected"
    And I wait for 10 seconds
    Then total tweet after deletion

@11
Scenario: Functionality for check all to delete all tweets on a page
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[1]"
    And I wait for 5 seconds
    Then I fetch text for total tweet
    And I click on the element with xpath "//div[@id='block-usersalltweetsblock']//ul[@class='header']/li[8]"
    And I wait for 5 seconds
    And I press "Delete Selected"
    And I wait for 10 seconds 
    Then all tweets on a page is deleted

@12
Scenario: Functionality to verify that on a page only 10 tweets will be shown
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[1]"
    And I wait for 5 seconds  
    Then I should see element with xpath "//div[@id='block-usersalltweetsblock']//div[@class='item-list'][2]/ul/li[10]"  

@13
Scenario: To verify if there will be more then 10 tweets then it'll show pagination
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[1]"
    Then I fetch text for total tweet
    Then I should see pagination on css ".pager"








