Feature: To check the import tweet functionality 

@javascript
Scenario: Click on Import tweet link should navigate to different page
    Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    And I wait for 5 seconds
	  When I click on the element with xpath "//div[@id='block-usersleftsidebarblock']//div[@class='import_tweets']"	
	  Then I should be on "/dashboard/import-tweets"

@javascript @2
Scenario: Import a csv file and number of Total tweets and valid tweet should get increased
    Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    When I click on the element with xpath "//div[@id='block-usersleftsidebarblock']//div[@class='import_tweets']"	
    And I wait for 5 seconds
    Then I fetch text for valid tweet
    And I fetch text for invalid tweet
    And I attach the file "Import/Sample_Csv.csv" to "edit-managed-file-upload"
    And I press "edit-submit"
    And I wait for 5 seconds
    Then I should see text matching "Import completed successfully"
    And tweets should get updated

  
@javascript @3
Scenario: To check the number of new valid and invalid tweet updated on left panel
	Given I am on "/"
    And I am logged in as "nehasingh767@gmail.com" with password "Srijan@123"
    And I press "Log in"
    When I click on the element with xpath "//div[@id='block-usersleftsidebarblock']//div[@class='import_tweets']"
    And I attach the file "Import/Sample_Csv.csv" to "edit-managed-file-upload"
    And I press "edit-submit"
    And I wait for 5 seconds
    Then I fetch new valid and invalid tweet
