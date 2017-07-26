Feature: To verify functionaity of FAQ page

@1
Scenario: Click on terms of use should navigate FAQ page
	Given I am on "./"
	And I click "FAQ"
	Then the url should match "/faq"

@2
Scenario: To check the elements visible on Page
	Given I am on "/faq-page"
	And I wait for 5 seconds
	Then I should see the link "Barbet"
	And I should see the link "Plans"
    And I should see the link "FAQ"
    And I should see the link "Contact"
    And I should see the link "Join Barbet"
    And I should see "Account Settings"
    And I should see the link "Billing"
    And I should see the link "Get Started"
    And I should see the link "Imports"
    And I should see the link "Pricing & Plans"
    And I should see the link "Queued Post"
    And I should see the link "Security"
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
		Given I am on "/faq-page"
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
		Then I fetch the href of "Account Settings"
		And I match the href "/faq/5" of "Account Settings"
		Then I fetch the href of "Billing"
		And I match the href "/faq/6" of "Billing"
		Then I fetch the href of "Get Started"
		And I match the href "/faq/1" of "Get Started" 
		Then I fetch the href of "Imports"
		And I match the href "/faq/4" of "Imports"
		# Then I fetch the href of "Pricing & Plans"
		# And I match the href "/faq/2" of "Pricing & Plans"
		Then I fetch the href of "Queued Post" 
		And I match the href "/faq/7" of "Queued Post"
		Then I fetch the href of "Security" 
		And I match the href "/faq/3" of "Security"
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

@4 @javascript
Scenario: To verify content block (:aragraph, image, Question , Answer )
		Given I am on "/faq-page"
		And I wait for 5 seconds
		Then I should see element with xpath "//div[@id='block-faqbannerimage']/div/div[2]/img"
		And I should see element with xpath "//div[@id='block-faqbannerimage']/div/div[1]/p"
		And I should see element with xpath "//div[@class='faq-qa-hide collapsible']//div[@class='faq-question'][1]"
		And I should see element with xpath "//div[@id='block-srijan-content']/div/div/div/div[2]/div/div[2]"
		And I should see element with xpath "//div[@id='block-srijan-content']/div/div/div/div[2]/div/div[3]"
		And I should see element with xpath "//div[@id='block-srijan-content']/div/div/div/div[2]/div/div[4]"