@javascript
Feature: Create a tweet functionality

  @1

 Scenario: To create a tweet with less than 140 charachters 
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
	When I fill in some unique text
	And I press "Tweet Now"
    And I wait for 5 seconds
	Then I should see text matching "Tweet shared and stored in valid tweets successfully."


 @2
 Scenario: Click on Create Tweet should navigate to create tweet block
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    Then I should be on "/dashboard"

    @3
Scenario: Upload Image functionality
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I fill in some unique text
    And I attach the file "Import/index.png" to "edit-images-upload"
    And I press "edit-submit"
    And I wait for 5 seconds
    Then I should see text matching "Tweet shared and stored "

    @4
Scenario: Functionality to upload maximum image (4) to create tweet 
   Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I fill in some unique text
    And I upload the file "Import/download.jpg" in path ".class='js-form-file form-file']"
    And I wait for 5 seconds
    And I upload the file "Import/images.jpg" in path ".class='js-form-file form-file']"
    And I wait for 5 seconds
    And I upload the file "Import/download1.jpg" in path ".class='js-form-file form-file']"
    And I wait for 5 seconds
    And I upload the file "Import/index.png" in path ".class='js-form-file form-file']"
    And I wait for 5 seconds
    And I press "edit-submit"
    And I wait for 5 seconds
    Then I should see text matching "Tweet shared and stored "

    @5
    Scenario: Functionality to upload more tha 4 images, and tweet now button is disabled 
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I fill in some unique text
    And I upload the file "Import/download.jpg" in path ".class='js-form-file form-file']"
    And I wait for 5 seconds
    And I upload the file "Import/images.jpg" in path ".class='js-form-file form-file']"
    And I wait for 5 seconds
    And I upload the file "Import/download1.jpg" in path ".class='js-form-file form-file']"
    And I wait for 5 seconds
    And I upload the file "Import/index.png" in path ".class='js-form-file form-file']"
    And I wait for 5 seconds
    And I upload the file "Import/index.png" in path ".class='js-form-file form-file']"
    And I wait for 3 seconds
    And I check button is disabled "//input[@id='edit-submit']"

    @6
    Scenario: Functionality limit exceeds 140 and tweet contains pattern of URL -tweet now button is not disabled.
    Given I am on "/"
    And I login with valid username and password
    And I wait for 5 seconds
    When I fill in "edit-message" with "https://ajbmsnacndgdjsfcjmdchjkdcjdchdjkcdkxsxdxedxdeeedededededjkdshkjhjkhdsjhsdkjdhkjhuiheiwuhjkhidhiuhkjhkjhiojeoijsijnjkdhoidhewiohsklxhdkhihekhkjededeen.com"
    And I wait for 5 seconds
    Then I check button is disabled "//input[@id='edit-submit']"

    