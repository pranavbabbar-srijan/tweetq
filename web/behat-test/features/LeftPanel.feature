@javascript
Feature: To check the functionality of elements on the Left panel 
	
Scenario: To check the elements on left panel of homepage
Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    And I wait for 5 seconds
    Then I should see text matching "Barbet"
    And I should see text matching "Neha singh"
    And I should see text matching "@Nehasin05727670"
    And I should see text matching "Create a Tweet"
    And I should see text matching "Import Tweets"
    And I should see text matching "Valid Tweets"
    And I should see text matching "Invalid Tweets"
    And I should see text matching "Archived Tweets"
    And I should see text matching "Profile & Settings"

 Scenario: Click on create a tweet 
    Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@id='block-usersleftsidebarblock']//div[@class='create_tweets']"
    Then I should see text matching "What's happening?"
    And I should see text matching "Browse"
    And I should see "Save for Later"
    And I should see "Tweet Now"
    And I should see text matching "140"

  Scenario: Click on Valid Tweets
    Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@id='block-usersleftsidebarblock']//div[@class='valid_tweets']"
    Then I should see text matching "New Tweets"
    And I should see text matching "Tweeted"
    And I should see text matching "Message"
    And I should see text matching "Size"
    And I should see text matching "Created On"
    And I should see text matching "Updated On"
    And I should see text matching "Modify"

    Scenario: Click on Invalid Tweets
    Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@id='block-usersleftsidebarblock']//div[@class='invalid_tweets']"
    And I should see text matching "Message"
    And I should see text matching "Size"
    And I should see text matching "Created On"
    And I should see text matching "Updated On"
    And I should see text matching "Modify"

    Scenario: Click on archived Tweet when no tweet is archived 
    Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@id='block-usersleftsidebarblock']//div[@class='archived_tweets']"
    Then I should see text matching "No Tweets Found"
    And I should see text matching "Create a Tweet"
    And I should see text matching "Import Tweets"

    # Scenario: Click on profile Settings
    # Given I am on "/"
    # And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    # And I press "Log in"
    # And I wait for 5 seconds
    # When I click on the element with xpath "//div[@id='block-usersleftsidebarblock']//div[@class='profile_settings']"
    # Then I should see text matching "Profile"
    # And I should see text matching "Full Name"
    # And I should see text matching "Neha Singh"
    # And I should see text matching "Twitter Username"
    # And I should see text matching "@Nehasin05727670"
    # And I should see text matching "Email"
    # And I should see text matching "nehasingh767@gmail.com"
    # And I should see text matching ""
    # And I should see text matching "Password"




