@javascript
Feature: To check the functionality of Corn Job.

Scenario: To check after cron job all the new tweets should be moved to Tweeted
Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    When I click on the element with xpath "//div[@id='block-usersleftsidebarblock']//div[@class='import_tweets']"	
    And I wait for 5 seconds
    And I attach the file "Import/Sample_Csv.csv" to "edit-managed-file-upload"
    And I press "edit-submit"
    And I wait for 60 seconds
    