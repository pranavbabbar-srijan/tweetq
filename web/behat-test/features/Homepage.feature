@javascript
Feature: To check the functionality of login page
	
	@1
	Scenario: To check the elements visible on Login Page
		Given I am on "./"
		Then I should see the link "Barbet"
		And I should see the link "Plans"
        And I should see the link "FAQ"
        And I should see the link "Contact"
        And I should see the link "Sign in with Twitter"
        And I should see text matching "Email"
		And I should see text matching "Password"
		And I should see the button "edit-submit"
		And I should see the link "Sign up Now"
		And I should see text matching "Forgot your password"
		And I should see text matching "WE ARE ALSO AVAILABLE FOR YOUR FAVOURITE SOCIAL NETWORK"
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


	@2
	Scenario: Fetch href of elements and match with the expected one
		Given I am on "./"
	    Then I fetch the href of "Sign in with Twitter"
		And I match the href "/authorize_twitter_login" of "Sign in with Twitter"
		Then I fetch the href of "Plans"
		And I match the href "/plans" of "Plans"
		Then I fetch the href of "FAQ"
		And I match the href "/faq" of "FAQ"
		Then I fetch the href of "Contact"
		And I match the href "/contact-us" of "Contact"
		Then I fetch the href of "Sign up Now"
		And I match the href "/signup" of "Sign up Now"
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
		And I match the href "/faq" of form "FAQ" in "homepagefooter" region
		Then I fetch the href of "How it works?"
		And I match the href "/how-it-wroks" of "How it works?"
		Then I fetch the href of "Privacy Policy"
		And I match the href "/privacy-policy" of "Privacy Policy"
		Then I fetch the href of "Terms of Use"
		And I match the href "/terms-of-use" of "Terms of Use"


    @3
	Scenario: Forgot Password Functionality
		Given I am on "/das"
		When I click on the element with xpath "//span[@id='forgot-password']"
		And I should see "Enter Your Registered Email Id"
		And I fill in "Email" with "nehasingh767@gmail.com"
		And I click on the element with xpath "//div[@id='forgot-password-submit']"
		And I wait for 5 seconds
		And I should see text matching "An email to change the password has been sent to your Email ID"	
    
   
	@5
	Scenario: To check the carousel functionality on home page
		Given I am on "./"
		When I click on the element with xpath "//div[@id='flexslider-1']/ol/li[1]/a"
		When I should see element with css ".slider-content>h2"
		And I should see element with css ".slider-content>p"
		And I should see element with css ".image-style-flexslider-full"
		Then I set browser window size to "1024" x "768"
		When I click on the element with xpath "//div[@id='flexslider-1']/ol/li[2]/a"
		When I should see element with css ".slider-content>h2"
		And I should see element with css ".slider-content>p"
		And I should see element with css ".image-style-flexslider-full"

 	@6
 	Scenario: To verify maximum 2 sliders can be added in carousel
 		Given I am on "./"
 		Then I should see element with css ".flex-control-nav.flex-control-paging>li>a"
 		And I should see element with css ".flex-control-nav.flex-control-paging>li>a"
 		

 	@7
 	Scenario: To verify the What Barbet section
 		Given I am on "./"
 		Then I should see element with css ".clearfix.text-formatted.field.field--name-field-title.field--type-text-long.field--label-hidden.field__item"
 		And I should see element with css ".clearfix.text-formatted.field.field--name-body.field--type-text-with-summary.field--label-hidden.field__item>p"

 	@8
 	Scenario: To verify Automate, Schedule, Bulk store section
 		Given I am on "./"
 		Then I should see element with xpath "//div[@id='block-views-block-bulk-store-automate-block-block-1']//div[@class='views-row'][1]//div[@class='views-field views-field-field-section-image']"
 		And I should see element with xpath "//div[@id='block-views-block-bulk-store-automate-block-block-1']//div[@class='views-row'][1]//div[@class='views-field views-field-title']"
 		And I should see element with xpath "//div[@id='block-views-block-bulk-store-automate-block-block-1']//div[@class='views-row'][1]//div[@class='views-field views-field-body']"
 		Then I should see element with xpath "//div[@id='block-views-block-bulk-store-automate-block-block-1']//div[@class='views-row'][2]//div[@class='views-field views-field-field-section-image']"
 		And I should see element with xpath "//div[@id='block-views-block-bulk-store-automate-block-block-1']//div[@class='views-row'][2]//div[@class='views-field views-field-title']"
 		And I should see element with xpath "//div[@id='block-views-block-bulk-store-automate-block-block-1']//div[@class='views-row'][2]//div[@class='views-field views-field-body']"
 		Then I should see element with xpath "//div[@id='block-views-block-bulk-store-automate-block-block-1']//div[@class='views-row'][3]//div[@class='views-field views-field-field-section-image']"
 		And I should see element with xpath "//div[@id='block-views-block-bulk-store-automate-block-block-1']//div[@class='views-row'][3]//div[@class='views-field views-field-title']"
 		And I should see element with xpath "//div[@id='block-views-block-bulk-store-automate-block-block-1']//div[@class='views-row'][3]//div[@class='views-field views-field-body']"

 	@9
 	Scenario: To verify Our Vision block
 		Given I am on "./"
 		Then I should see element with xpath "//div[@class='views-row'][2]//div[@class='section__mission--text']/p[1]"
 		Then I should see element with xpath "//div[@class='views-row'][2]//div[@class='section__mission--text']/p[2]"
 		And I should see element with xpath "//div[@class='views-row'][2]//div[@class='section__mission-image']"

 	@10
 	Scenario: To verify Our Mission block
 		Given I am on "./"
 		Then I should see element with xpath "//div[@class='views-row'][1]//div[@class='section__mission--text']/p[1]"
 		Then I should see element with xpath "//div[@class='views-row'][1]//div[@class='section__mission--text']/p[2]"
 		And I should see element with xpath "//div[@class='views-row'][1]//div[@class='section__mission-image']"

	@11
	Scenario: To verify copyright block
		Given I am on "./"
		Then I should see text matching "© Barbet 2017 | All Rights Reserved | A Product by "
		And I should see the link "Srijan Technologies"



		

