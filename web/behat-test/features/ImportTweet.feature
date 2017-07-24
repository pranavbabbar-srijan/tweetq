@javascript
Feature: To check the import tweet functionality 

@javascript @1
Scenario: Click on Import tweet link should navigate to different page
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
	When I click on the element with xpath "//div[@class='import_tweets']/span/a"	
    And I wait for 5 seconds
	Then I should be on "/dashboard/import-tweets"

@javascript @2
Scenario: Import a csv file and number of Total,valid and invalid tweets should get increased
    Given I am on "/"
    And I login with valid username and password
    When I click on the element with xpath "//div[@class='import_tweets']/span/a"
    And I wait for 5 seconds
    Then I fetch text for valid tweet
    And I fetch text for invalid tweet
    And I fetch text for total tweet
    And I attach the file "Import/Sample.csv" to "edit-managed-file-upload"
    And I press "edit-submit"
    And I wait for 5 seconds
    Then I should see text matching "Import completed successfully"
    And tweets should get updated after import

  
@javascript @3
Scenario: To check the number of new valid and invalid tweet updated on left panel
	Given I am on "/"
    And I login with valid username and password
    When I click on the element with xpath "//div[@class='import_tweets']/span/a"
    And I attach the file "Import/Sample1.csv" to "edit-managed-file-upload"
    And I press "edit-submit"
    And I wait for 3 seconds
    And I click on the element with xpath "//div[@id='my_tweets']/span"
    And I wait for 3 seconds
    Then I fetch new valid and invalid tweet

@4
Scenario: To check the success message on importing the tweets
    Given I am on "/"
    And I login with valid username and password
    When I click on the element with xpath "//div[@class='import_tweets']/span/a"
    And I attach the file "Import/Sample1.csv" to "edit-managed-file-upload"
    And I press "edit-submit"
    And I wait for 5 seconds
    Then I should see text matching "Import completed successfully"
    And I should see text matching "Total : 7 Imported: 7 Valid: 5 Invalid : 2 Duplicate: 0 Skipped: 0"
    And I should see text matching "Skipped shows the tweets whose character limit exceeds"





