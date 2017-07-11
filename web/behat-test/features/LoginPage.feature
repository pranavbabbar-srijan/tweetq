Feature: To check the functionality of login page
	In order to check the functionality of login page
	As a user
	I need to be on "http://master-7rqtwti-na2rj6uui4vei.eu.platform.sh/das"

	@1
	Scenario: To check the elements visible on Login Page
		Given I am on "./"
		Then I should see the link "Barbet"
		And I should see the link "Plans"
        And I should see the link "FAQ"
        And I should see the link "Contact"
        And I should see the heading "Let your Twitter handle be at work 24x7"
        And I should see the link "Sign in with Twitter"
        And I should see text matching "Email"
		And I should see text matching "Password"
		And I should see the button "edit-submit"
		And I should see the link "Sign up Now"
		And I should see text matching "Forgot your password"
		And I should see text matching "What barbet is"
		And I should see text matching "automate"
		And I should see text matching "schedule"
		And I should see text matching "bulk store"
		And I should see text matching "our mission"
		And I should see text matching "our vision"
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
		And I should see the link "How it works?" in the homepagefooter
		And I should see the link "Privacy Policy" in the homepagefooter
		And I should see the link "Terms of Use" in the homepagefooter

	@2
	Scenario: Fetch href of elements and match 
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
		Then I fetch the href of "Contact"
		And I match the href "/contact-us" of "Contact"
		Then I fetch the href of "Contact"
		And I match the href "/contact-us" of "Contact"


			

		 @3
	Scenario: Forgot Password Functionality
		Given I am on "/das"
		When I click on the element with xpath "//span[@id='forgot-password']"
		And I should see "Enter Your Registered Email Id"
		And I fill in "Email" with "nehasingh767@gmail.com"
		And I click on the element with xpath "//div[@id='forgot-password-submit']"
		And I wait for 5 seconds
		And I should see "An email to change the password has been sent to your Email ID"	

	