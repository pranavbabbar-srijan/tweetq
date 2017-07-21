@javascript
Feature: To verify the functionality of archived tweet

@1
Scenario: Click on valid tweet should navigate to different page
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[4]"
   Then the url should match "/dashboard/archived-tweets"


@2
Scenario: Verify if tweeted tweet is modified, it should move in archived tweet list
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    And I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[2]"
    And I click on the element with xpath "//div[@id='block-usersvalidtweetsblock']//a[2]"
    And I fetch text for archived tweet
    When I click on the element with xpath "//div[@id='block-userstweetedtweetsblock']//div[@class='item-list'][2]/ul/li[1]//a[contains(@href,'edit')]"
    And I wait for 5 seconds
    And I fill in some unique text 
    And I press "edit-clone"
    And I wait for 5 seconds
    Then I should see text matching "Tweet have been saved successfully"
    And I wait for 5 seconds
    And Archived Tweet incremented



@3
    Scenario: Verify columns listed on archived page
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[4]"
   Then the url should match "/dashboard/archived-tweets"
    Then I should see "Message" in the "header"
    And I should see "Size" in the "header"
    And I should see "Created On" in the "header"
    And I should see "Tweeted On" in the "header"
    And I should see "Updated On" in the "header"
    And I should see "Retweeted" in the "header"
    And I should see "Modify" in the "header"


@4
 Scenario: Verify the hover text of delete element
 	Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[4]"
   Then the url should match "/dashboard/archived-tweets"
    When I hover over the element by Xpath "//div[@id='block-usersarchivedtweetsblock']//div[@class='item-list'][2]/ul/li[1]//a[contains(@href,'delete')]"
    And I wait for 5 seconds
    Then I should see text matching "Click here to delete your Tweet"


@5
Scenario: Verify the delete functionality
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[4]"
   Then the url should match "/dashboard/archived-tweets"
    And I fetch text for archived tweet
    When I click on the element with xpath "//div[@id='block-usersarchivedtweetsblock']//div[@class='item-list'][2]/ul/li[1]//a[contains(@href,'delete')]"
    And I wait for 10 seconds
    And I should see text matching "This will permanently delete your tweet"
    And I press the "Delete Anyway" button
    And I wait for 10 seconds
    Then I should see text matching "Tweet Deleted Successfully"
    And archived tweet gets decremented 

@6
Scenario: Cancel button functionality
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[4]"
   Then the url should match "/dashboard/archived-tweets"
    When I click on the element with xpath "//div[@id='block-usersarchivedtweetsblock']//div[@class='item-list'][2]/ul/li[1]//a[contains(@href,'delete')]"
    And I wait for 10 seconds
    And I should see text matching "This will permanently delete your tweet"
    And I press the "Cancel" button
    Then the url should match "/dashboard/archived-tweets"

@7
Scenario: To fetch count of Archived tweet
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    And I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[2]"
    And I click on the element with xpath "//div[@id='block-usersvalidtweetsblock']//a[2]"
    And I fetch text for archived tweet
