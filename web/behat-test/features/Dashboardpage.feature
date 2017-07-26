@javascript

Feature: To check the functionality of dashboard page 

@1
    Scenario: Elements visible on hero header
    Given I am on "/"
    And I login with valid username and password
    And I wait for 10 seconds
    Then I should see the link "Barbet"
    And I should see element with css "#notification-display"
    And I should see text matching "Neha singh"
    And I should see text matching "Total Tweets"
    And I should see text matching "Valid Tweets"
    And I should see text matching "Invalid Tweets"
    And I should see text matching "Archived Tweets"

 @2
    Scenario: Elements visible on my tweets section
    Given I am on "/"
    And I login with valid username and password
    And I wait for 10 seconds
    When I click on the element with xpath "//div[@id='my_tweets']/span"
    And I wait for 5 seconds
    Then I should see the link "Valid Tweets" in the mytweets
    And I should see "Invalid Tweets" in the mytweets
    And I should see "Archived Tweets" in the mytweets


@3
    Scenario:To verify Total tweets is sum of Valid,Invalid,Archived Tweets
    Given I am on "/"
    And I login with valid username and password
    Then Total tweet matches with sum of other tweets

@4
    Scenario: Verify the hover text of save for later button
    Given I am on "/"
    And I login with valid username and password
    Then the url should match "/dashboard"
    And I wait for 5 seconds
    When I hover over the element by Xpath "//input[@id='edit-save']"
    And I wait for 5 seconds
    Then I should see text matching "Click here to save your message for the Barbet to post on Twitter"

@5
    Scenario: Verify the hover text of Tweet Now button
    Given I am on "/"
    And I login with valid username and password
    Then the url should match "/dashboard"
    And I wait for 5 seconds
    When I hover over the element by Xpath "//input[@id='edit-submit']"
    And I wait for 5 seconds
    Then I should see text matching "Click here to post your message on Twitter"

