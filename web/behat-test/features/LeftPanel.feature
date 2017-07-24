@javascript
Feature: To check the functionality of elements on the Left panel 

@1	
Scenario: To check the elements on left panel of homepage
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    Then I should see text matching "Barbet"
    And I should see text matching "Neha singh"
    And I should see text matching "@Nehasin05727670"
    And I should see text matching "Create a Tweet"
    And I should see text matching "Import Tweets"
    And I should see text matching "Valid Tweets"
    And I should see text matching "Invalid Tweets"
    And I should see text matching "Archived Tweets"
    And I should see text matching "Total Tweets"
 
 @2
 Scenario: To verify elements on click create a tweet 
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@class='create_tweets']"
    And I wait for 5 seconds
    And I should see the button "Save for Later"
    And I should see the button "Tweet Now"
    And I should see the button "edit-images-upload-button"


  @3
  Scenario: To verify elements on click Valid Tweets
    Given I am on "/"
    And I login with valid username and password
    And I wait for 10 seconds
    And I click on the element with xpath "//div[@id='my_tweets']/span"
    And I wait for 3 seconds
    When I click "Valid Tweets"
    And I wait for 10 seconds
    Then I should see text matching "New Tweets"
    And I should see text matching "Tweeted"
    Then I should see "Message" in the "header"
    And I should see "Size" in the "header"
    And I should see "Created On" in the "header"
    And I should see "Updated On" in the "header"
    And I should see "Modify" in the "header"


   @4
    Scenario: To verify elements on click Invalid Tweets
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    And I click on the element with xpath "//div[@id='my_tweets']/span"
    And I wait for 3 seconds
    When I click "Invalid Tweets"
    And I wait for 5 seconds
    Then I should see "Message" in the "header"
    And I should see "Size" in the "header"
    And I should see "Created On" in the "header"
    And I should see "Updated On" in the "header"
    And I should see "Modify" in the "header"


    @5
    Scenario:To verify elements on click archived tweet
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    And I click on the element with xpath "//div[@id='my_tweets']/span"
    And I wait for 3 seconds
    When I click "Archived Tweets"
    And I wait for 5 seconds
    Then I should see "Message" in the "header"
    And I should see "Size" in the "header"
    And I should see "Created On" in the "header"
    And I should see "Tweeted On" in the "header"
    And I should see "Updated On" in the "header"
    And I should see "Retweeted" in the "header"
    And I should see "Modify" in the "header"
    # Then I should see text matching "No Tweets Found"
    # And I should see text matching "Create a Tweet"
    # And I should see text matching "Import Tweets"

    @6
    Scenario: To verify elements on click Import tweets
    Given I am on "/"
    And I login with valid username and password
    And I wait for 10 seconds
    When I click on the element with xpath "//a[text()='Import']"
    And I wait for 10 seconds
    When I click on the element with xpath "//div[@id='block-usersleftsidebarblock']/div/div/div[4]/div[1]/span/a"
    And I wait for 5 seconds
    And I should see the button "edit-submit"
    And I should see the button "edit-managed-file-upload-button"

@7
Scenario: To verify elements on Total Tweets
    Given I am on "/"
    And I login with valid username and password
    And I wait for 10 seconds
    And I click on the element with xpath "//div[@id='my_tweets']/span"
    And I wait for 5 seconds
    When I click on the element with xpath "//div[@id='my_tweets']/div[1]/span"
    And I wait for 10 seconds
    Then I should see "Message" in the "header"
    And I should see "Size" in the "header"
    And I should see "Created On" in the "header"
    And I should see "Tweeted On" in the "header"
    And I should see "Updated On" in the "header"
    And I should see "Retweeted" in the "header"
    And I should see "Modify" in the "header"
