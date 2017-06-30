@javascript
Feature: To verify the functionality of archived tweet

@1
Scenario: Click on valid tweet should navigate to different page
    Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[4]"
   Then the url should match "/dashboard/archived-tweets"

@2
    Scenario: Verify columns listed on archived page
    Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[4]"
   Then the url should match "/dashboard/archived-tweets"
    Then I should see "Message" in the "header"
    And I should see "Size" in the "header"
    And I should see "Created On" in the "header"
    And I should see "Tweeted On" in the "header"
    And I should see "Updated On" in the "header"
    And I should see "Retweeted" in the "header"
    And I should see "Modify" in the "header"


@3
 Scenario: Verify the hover text of delete element
 	Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[4]"
   Then the url should match "/dashboard/archived-tweets"
    When I hover over the element by Xpath "//div[@id='block-usersarchivedtweetsblock']//div[@class='item-list'][2]/ul/li[1]//a[contains(@href,'delete')]"
    And I wait for 5 seconds
    Then I should see text matching "Click here to delete your Tweet"


@4
Scenario: Verify the delete functionality
Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[4]"
   Then the url should match "/dashboard/archived-tweets"
    And I fetch text for archived tweet
    When I click on the element with xpath "//div[@id='block-usersarchivedtweetsblock']//div[@class='item-list'][2]/ul/li[1]//a[contains(@href,'delete')]"
    And I wait for 5 seconds
    And I should see text matching "This will permanently delete your tweet"
    And I press the "Delete Anyway" button
    Then I should see text matching "Tweet Deleted Successfully"
    And archived tweet gets decremented 

@5
Scenario: Cancel button functionality
Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    When I click on the element with xpath "//div[@id='block-userstweetsstatisticsblock']//a[4]"
   Then the url should match "/dashboard/archived-tweets"
    And I fetch text for archived tweet
    When I click on the element with xpath "//div[@id='block-usersarchivedtweetsblock']//div[@class='item-list'][2]/ul/li[1]//a[contains(@href,'delete')]"
    And I wait for 5 seconds
    And I should see text matching "This will permanently delete your tweet"
    And I press the "Cancel" button
    Then the url should match "/dashboard/archived-tweets"