//custom js.

(function ($) {
 // code to disable button on the basis of length.
	$(document).ready(function(){
		var limit_chars = 140;

		//Signup form validation.
		var alphabet_msg = "Only Letters are allowed";
		var full_name_missing_msg = "Please enter full name";
		var email_msg = "Please enter a valid email ID";
		var email_missing_msg = "Please enter your email ID";
		var existing_email_msg = "Email ID already exist";
		var password_missing_msg = "Please enter the password";
		var password_legth_msg = "Enter password between 6 and 12 characters";
		var password_minimum_length = 6;
		var password_maximum_length = 12;

		//Full name validtaion.
	    $("#signup-form #edit-field-full-name").on('keyup', function(e) {
	    	var name = $('#signup-form #edit-field-full-name').val();
	    	var alphabet = /^[a-zA-Z ]+$/.test(name);
	    	$("#fname-validation-error").remove();
	    	if (name.length > 0) {
	    		if (!alphabet) {
	    			$("<span id='fname-validation-error' class='validation-error'>" + alphabet_msg + "</p>").insertAfter( "#edit-field-full-name" );
	    		}
	    	}
	    });

	    $("#signup-form #edit-field-full-name").focusout(function() {
	   		var name = $('#signup-form #edit-field-full-name').val();
	    	if (name.length == 0) {
	    		$("#fname-validation-error").remove();
	    		$("<span id='fname-validation-error' class='validation-error'>" + full_name_missing_msg + "</p>").insertAfter( "#edit-field-full-name" );
	    	}
	  	});

	    //Email validation.
	    $("#signup-form #edit-email").focusout(function() {
	   		var email = $('#signup-form #edit-email').val();
	   		$("#email-validation-error").remove();
	    	if (email.length == 0) {
	    		$("<span id='email-validation-error' class='validation-error'>" + email_missing_msg + "</p>").insertAfter( "#signup-form #edit-email" );
	    	}
	  	});

	    $("#signup-form #edit-email").blur(function() {
	   		var email = $('#signup-form #edit-email').val();
	   		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  			var valid = regex.test(email);
  			if (email.length > 0) {
	    		if (!valid) {
	    			$("#email-validation-error").remove();
	    			$("<span id='email-validation-error' class='validation-error'>" + email_msg + "</p>").insertAfter( "#signup-form #edit-email" );
	    		}
	    		if (valid) {
	    			$("#email-validation-error").remove();
	    			$.post('/tweetQ11Apr/_www/dashboard/validateEmail', {'email' : email}, function(data) {
	    				if  (data == "exist") {
							$("<span id='email-validation-error' class='validation-error'>" + existing_email_msg + "</p>").insertAfter( "#signup-form #edit-email" );	    					
	    				}
				    });
	    			
	    		}
	    	}
	  	});

	    //Password validation.
	    $("#signup-form #edit-user-password").focusout(function() {
	   		var password = $('#signup-form #edit-user-password').val();
	   		$("#password-validation-error").remove();
	    	if (password.length == 0) {
	    		$("<span id='password-validation-error' class='validation-error'>" + password_missing_msg + "</p>").insertAfter( "#signup-form #edit-user-password" );
	    	}
	  	});

	    $("#signup-form #edit-user-password").focusout(function() {
	   		var password = $('#signup-form #edit-user-password').val();
	    	if (password.length < password_minimum_length || password.length > password_maximum_length) {
	    		$("#password-validation-error").remove();
	    		$("<span id='password-validation-error' class='validation-error'>" + password_legth_msg + "</p>").insertAfter( "#signup-form #edit-user-password" );
	    	}
	  	});

	    $("#send-tweets-form #edit-message").on('keyup', function(e) {
	    	var tweet_msg = $('#send-tweets-form #edit-message').val();
	    	var tweet_msg_length = tweet_msg.length;
	    	if (tweet_msg_length > limit_chars) {
	    		$("#send-tweets-form #edit-submit").attr('disabled', 'true');
	    	}
	    	else {
	    		$("#send-tweets-form #edit-submit").removeAttr('disabled');
	    	}
	    });

	    $("#send-tweets-form #edit-message").on('keyup', function(e) {
	    	var tweet_msg = $('#send-tweets-form #edit-message').val();
	    	var tweet_msg_length = tweet_msg.length;
	    	if (tweet_msg_length > 300) {
	    		$("#send-tweets-form #edit-save").attr('disabled', 'true');
	    	}
	    	else {
	    		$("#send-tweets-form #edit-save").removeAttr('disabled');
	    	}
	    });


		$(".-form-tweets-queue-csv-upload .description").insertAfter(".-form-tweets-queue-csv-upload #edit-submit");
		$("#block-usersdashboardheaderblock .content").append("<a id='notification-display' href='#;'></a>");
		$("#block-usersdashboardnontwitterheaderblock .content").append("<a id='notification-display' href='#;'></a>");
		$("#block-usersdashboardheaderblock .profile + a").click(function() {
			$(this).toggleClass("active");
			// $(this).siblings(".notifications").children(".notification-message-list").toggleClass("active");
		});

		// code to trim text and add more link.
	    var showChar = 140;
	    var moretext = "...";
	    var lesstext = "Less";

	    $('.block-tweets-queue .item-list + .item-list ul ul li:first-child').each(function() {
	        var content = $(this).html();

	        if(content.length > showChar) {

	            var c = content.substr(0, showChar);
	            var h = content.substr(showChar, content.length - showChar);
	            var html = c + '<span class="morecontent"><span>' + h + '</span><a href="" class="morelink">' + moretext + '</a></span>';
	            $(this).html(html);
	        }
	    });

	    var showChar = 95;
	    var moretext = "...";
	    var lesstext = "Less";

	    $('.notifications .notification-message-list > div span.message').each(function() {
	        var content = $(this).html();

	        if(content.length > showChar) {

	            var c = content.substr(0, showChar);
	            var h = content.substr(showChar, content.length - showChar);
	            var html = c + '<span class="morecontent"><span>' + h + '</span></span><span class="ellipsis">' + moretext + '</span>';
	            $(this).html(html);
	        }
	    });

	    if($('#block-signinwithtwitterblock').length > 0){
	    	$('body').addClass('signinwithtwitterblock');
		}

		if ($('div').hasClass('no-tweet-found')) {
		    $('body').addClass('no-tweet');
		}

	     $("#block-usersdashboardheaderblock .profile + a").click(function(e) {
	        $(".notification-message-list").toggleClass("active");
	        e.stopPropagation();
	    });

	    $(document).click(function(e) {
	        if (!$(e.target).is('.notification-message-list, #notification-display')) {
	            $(".notification-message-list, #notification-display").removeClass("active");
	        }
	    });

	    $(".morelink").click(function(){
	        if($(this).hasClass("less")) {
	            $(this).removeClass("less");
	            $(this).html(moretext);
	        } else {
	            $(this).addClass("less");
	            $(this).html(lesstext);
	        }
	        $(this).parent().prev().toggle();
	        $(this).prev().toggle();
	        return false;
	    });
	    // Change an error message
	    $(".messages--error").text('Unrecognized Email and Password');


	    $("#forgot-password-section").hide();
	    $("#forgot-password").click(function() {
	    	$("#forgot-password-section").show();
	    	$("#user-login-prefix").hide();
	    	$("#edit-actions").hide();
		});
	    $("#forgot-password-cancel").click(function() {
	    	$("#forgot-password-section").hide();
	    	$("#user-login-prefix").show();
	    	$("#edit-actions").show();
		});

	    $(".create-header #ajax-wrapper").click(function() {
	    	var blankMessage = '';
	    	$(".messages--error").remove();
		});

	    // profile dropdown.
	    $("#block-usersdashboardheaderblock .profile > a").click(function() {
	    	event.preventDefault();
				$(this).toggleClass("active");

				$(this).siblings(".profile-links").toggleClass("active");
			});
	    $("#block-usersdashboardnontwitterheaderblock .profile > a").click(function() {
	    	event.preventDefault();
			$(this).toggleClass("active");
			$(this).siblings(".profile-links").toggleClass("active");
		});

		var left = "140";
		var textSize = 0;
		$("#edit-message").keyup(function() {
		    textSize = $(this).val().length;
		    document.getElementById('edit-display-box').value = left - textSize;
		});

		$("#notification-display").click(function(){
            $.ajax({
                type: 'POST',
                url: '/dashboard/user-history',
                success: function(data) {
                }
            });
   		});

		// ripple effect
		  $(".block-users-tweets-statistics-block .content > div a").click(function (e) {

		  // Remove any old one
		  $(".ripple").remove();

		  // Setup
		  var posX = $(this).offset().left,
		      posY = $(this).offset().top,
		      buttonWidth = $(this).width(),
		      buttonHeight =  $(this).height();

		  // Add the element
		  $(this).prepend("<span class='ripple'></span>");


		 // Make it round!
		  if(buttonWidth >= buttonHeight) {
		    buttonHeight = buttonWidth;
		  } else {
		    buttonWidth = buttonHeight;
		  }

		  // Get the center of the element
		  var x = e.pageX - posX - buttonWidth / 2;
		  var y = e.pageY - posY - buttonHeight / 2;


		  // Add the ripples CSS and start the animation
		  $(".ripple").css({
		    width: buttonWidth,
		    height: buttonHeight,
		    top: y + 'px',
		    left: x + 'px'
			}).addClass("rippleEffect");
		});
		  $(".path-frontpage .region-content .messages--error").insertBefore("#user-login-prefix #forgot-password");

		  // Fadeout messages.
		$('.messages').delay(5000).fadeOut(400);

	});

})(jQuery);
