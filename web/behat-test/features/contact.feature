
Feature: To verify the functionality of Contact us page

@1
	Scenario: Click on Contact should navigate to contact-us page
		Given I am on "/"
		And I click "Contact"
		Then the url should match "/contact-us"

@2
	Scenario: To check the elements visible on contactus Page
		Given I am on "/contact-us"
		Then I should see the link "Barbet"
		And I should see the link "Plans"
        And I should see the link "FAQ"
        And I should see the link "Contact"
        And I should see the link "Join Barbet"
        And I should see text matching "Write to us"
        And I should see text matching "Name"
        And I should see text matching "Email"
        And I should see text matching "Message"
        And I should see the button "edit-submit"	
        And I should see text matching "We are also available for your favourite social network"
		And I should see the link "facebook"
		And I should see the link "google plus"
		And I should see the link "instagram"
		And I should see the link "linkedin"
		And I should see the link "twitter"
		And I should see text matching " Subscribe to our newsletter now."
		And I should see the button "edit-subscribe"
		And I should see the link "Contact" in the homepagefooter
		And I should see the link "FAQ" in the homepagefooter
		And I should see the link "How it works?"
		And I should see the link "Privacy Policy"
		And I should see the link "Terms of Use"
		And I should see text matching "© Barbet 2017 | All Rights Reserved | A Product by "
		And I should see the link "Srijan Technologies"

@3
	Scenario: Fetch href of elements and match with the expected URL
		Given I am on "/contact-us"
	    Then I fetch the href of "Barbet"
		And I match the href "/" of "Barbet"
		Then I fetch the href of "Plans"
		And I match the href "/plans" of "Plans"
		Then I fetch the href of "FAQ"
		And I match the href "/faq-page" of "FAQ"
		Then I fetch the href of "Contact"
		And I match the href "/contact-us" of "Contact"
		Then I fetch the href of "Join Barbet"
		And I match the href "/" of "Join Barbet"
		Then I fetch the href of "facebook"
		And I match the href "/facebook" of "facebook"
		Then I fetch the href of "google plus"
		And I match the href "/googlwlplus" of "google plus"
		Then I fetch the href of "instagram"
		And I match the href "/instagram" of "instagram"
		Then I fetch the href of "linkedin"
		And I match the href "/linkedin" of "linkedin"
		Then I fetch the href of "twitter"
		And I match the href "/twitter" of "twitter"
		Then I fetch the href of form "Contact" in "homepagefooter" region
		And I match the href "/contact-us" of form "Contact" in "homepagefooter" region
		Then I fetch the href of form "FAQ" in "homepagefooter" region
		And I match the href "/faq-page" of form "FAQ" in "homepagefooter" region
		Then I fetch the href of "How it works?"
		And I match the href "/how-it-wroks" of "How it works?"
		Then I fetch the href of "Privacy Policy"
		And I match the href "/privacy-policy" of "Privacy Policy"
		Then I fetch the href of "Terms of Use"
		And I match the href "/terms-of-use" of "Terms of Use"

@4
	Scenario: To verify header block ( title, image, 3 links, logo)
		Given I am on "/contact-us"
		Then I should see element with xpath "//div[@id='block-aproductofsrijantechnologies']/div/div[6]/img"
		And I should see element with xpath "//div[@id='block-aproductofsrijantechnologies']/div/div[1]/img"
		And I should see element with xpath "//div[@id='block-aproductofsrijantechnologies']/div/div[2]/p"
		And I should see element with xpath "//div[@id='block-aproductofsrijantechnologies']/div/div[3]/a"
		And I should see element with xpath "//div[@id='block-aproductofsrijantechnologies']/div/div[4]/a"
		And I should see element with xpath "//div[@id='block-aproductofsrijantechnologies']/div/div[5]/a"

@5
	Scenario: To verify write to us block 
		Given I am on "/contact-us"
		Then I fill in "edit-field-name-0-value" with "Neha Singh"
		And I fill in "edit-field-email-0-value" with "neha.singh@srijan.net"
		And I fill in "edit-field-message-0-value" with "Query to test"
		Then I press "edit-submit"
		And I wait for 5 seconds
		And I should see text matching "Thank you for reaching out to us."
		And the url should match "/thanku-contact-us"


