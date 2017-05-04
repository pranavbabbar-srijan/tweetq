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
		var password_character_msg = 'Enter password between 6 and 12 characters<br>Please Enter At least one Uppercase Letter: A-Z,<br> At least one Lowercase Letter: a-z, <br>At least one Numerical Character: 0-9, <br>At least one of the following special character "!", "@", "#"';
		var password_length_msg = "Enter password between 6 and 12 characters";
		var password_minimum_length = 6;
		var password_maximum_length = 12;
		var website_invalid_msg = 'please enter valid website';
		var signup_error = '';
		var email_validation_path = '/dashboard/validateEmail';
		// var email_validation_path = '/tweetQ11Apr/_www/dashboard/validateEmail';

		$( "#foo" ).trigger( "click" );

		$('#signup-form').submit (function() {
			var passed = true;

	 		var name = $('#signup-form #edit-field-full-name').val();
	 		var alphabet = /^[a-zA-Z ]+$/.test(name);
			
			//Full Name check.
			$("#fname-validation-error").remove();
			if (name.length > 0) {
	    		if (!alphabet) {
	    			passed = false;
	    			$("<span id='fname-validation-error' class='validation-error'>" + alphabet_msg + "</p>").insertAfter( "#edit-field-full-name" );
	    		}
	    	}
	    	if (name.length == 0) {
	    		$("#fname-validation-error").remove();
	    		passed = false;
	    		$("<span id='fname-validation-error' class='validation-error'>" + full_name_missing_msg + "</p>").insertAfter( "#edit-field-full-name" );
	    	}

	    	//Check for error
	    	var email_failed = $("#signup-form #email-validation-error").hasClass('validation-error');
			if (email_failed) {
				return false;
			}

	    	//Password check.
	    	var password = $('#signup-form #edit-user-password').val();
	    	var regex = /^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{6,12}$/;
  			var valid = regex.test(password);
  			$("#password-validation-error").remove();
  			if (!valid) {
  				$("#password-validation-error").remove();
  				passed = false;
	    		$("<span id='password-validation-error' class='validation-error'>" + password_character_msg + "</p>").insertAfter( "#signup-form #edit-user-password" );
  			}
  			if (password.length == 0) {
	    		$("#password-validation-error").remove();
	    		passed = false;
	    		$("<span id='password-validation-error' class='validation-error'>" + password_missing_msg + "</p>").insertAfter( "#signup-form #edit-user-password" );
	    	}

	    	//Website validation.
	    	var website = $('#signup-form #edit-field-website').val();
	   		var valid = /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(website);
	   		$("#website-validation-error").remove();
	    	if (website.length > 0) {
	    		if (!valid) {
	    			passed = false;
	    			$("<span id='website-validation-error' class='validation-error'>" + website_invalid_msg + "</p>").insertAfter( "#signup-form #edit-field-website" );
	    		}
	    	}
		 	return passed;
		});

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

	    $("#signup-form #edit-email").focusout(function() {
	   		var email = $('#signup-form #edit-email').val();
	   		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  			var valid = regex.test(email);

  			$("#email-validation-error").remove();
	    	if (email.length == 0) {
	    		$("<span id='email-validation-error' class='validation-error'>" + email_missing_msg + "</p>").insertAfter( "#signup-form #edit-email" );
	    	}

  			if (email.length > 0) {
	    		if (!valid) {
	    			$("#email-validation-error").remove();
	    			$("<span id='email-validation-error' class='validation-error'>" + email_msg + "</p>").insertAfter( "#signup-form #edit-email" );
	    		}
	    		if (valid) {
	    			$("#email-validation-error").remove();
	    			$.post(email_validation_path, {'email' : email}, function(data) {
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
	    	var regex = /^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{6,12}$/;
  			var valid = regex.test(password);
  			$("#password-validation-error").remove();
  			if (!valid) {
  				$("#password-validation-error").remove();
	    		$("<span id='password-validation-error' class='validation-error'>" + password_character_msg + "</p>").insertAfter( "#signup-form #edit-user-password" );
  			}
	  	});

	    $("#signup-form #edit-user-password").focusout(function() {
	   		var password = $('#signup-form #edit-user-password').val();
	    	if (password.length == 0) {
	    		$("#password-validation-error").remove();
	    		$("<span id='password-validation-error' class='validation-error'>" + password_missing_msg + "</p>").insertAfter( "#signup-form #edit-user-password" );
	    	}
	  	});

	  	//Valid url check
	    $("#signup-form #edit-field-website").focusout(function() {
	   		var website = $('#signup-form #edit-field-website').val();
	   		var valid = /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(website);
	   		$("#website-validation-error").remove();
	    	if (website.length > 0) {
	    		if (!valid) {
	    			$("<span id='website-validation-error' class='validation-error'>" + website_invalid_msg + "</p>").insertAfter( "#signup-form #edit-field-website" );
	    		}
	    	}
	  	});

		//Twitter tweet message character count as per twitter.
	    $("#send-tweets-form #edit-message").on('keyup', function(e) {
	    	var tweet_msg = $('#send-tweets-form #edit-message').val();
	    	var tweet_msg_length = twttr.txt.getTweetLength(tweet_msg);
	    	$("#send-tweets-form #edit-display-box").val(140-tweet_msg_length);
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
	    	if (tweet_msg_length > 900) {
	    		$("#send-tweets-form #edit-save").attr('disabled', 'true');
	    	}
	    	else {
	    		$("#send-tweets-form #edit-save").removeAttr('disabled');
	    	}
	    });

		//Edit tweet message character count as per twitter.
	    $("#tweets-queue-tweet-form #edit-message").on('keyup', function(e) {
	    	var tweet_msg = $('#tweets-queue-tweet-form #edit-message').val();
	    	var tweet_msg_length = twttr.txt.getTweetLength(tweet_msg);
	    	$("#tweets-queue-tweet-form #edit-display-box").val(140-tweet_msg_length);
	    	if (tweet_msg_length > limit_chars) {
	    		$("#tweets-queue-tweet-form #edit-submit").attr('disabled', 'true');
	    	}
	    	else {
	    		$("#tweets-queue-tweet-form #edit-submit").removeAttr('disabled');
	    	}
	    });

	    $("#tweets-queue-tweet-form #edit-message").on('keyup', function(e) {
	    	var tweet_msg = $('#tweets-queue-tweet-form #edit-message').val();
	    	var tweet_msg_length = tweet_msg.length;
	    	if (tweet_msg_length > 900) {
	    		$("#tweets-queue-tweet-form #edit-save").attr('disabled', 'true');
	    	}
	    	else {
	    		$("#tweets-queue-tweet-form #edit-save").removeAttr('disabled');
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

		if ($('form').hasClass('-form-tweets-queue-csv-upload')) {
		    $('body').addClass('import-tweet-page');
		}

	     $("#block-usersdashboardheaderblock .profile + a").click(function(e) {
	        $(".notification-message-list").toggleClass("active");
	        e.stopPropagation();
	    });

	     $("#block-usersdashboardheaderblock .profile > a").click(function(e) {
	     	event.preventDefault();
	        $(".profile-links").toggleClass("active");
	        e.stopPropagation();
	    });

	    $(document).click(function(e) {
	        if (!$(e.target).is('.notification-message-list, #notification-display, .profile-links')) {
	            $(".notification-message-list, #notification-display, .profile-links").removeClass("active");
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
		// $(".messages--error").text('Unrecognized Email and Password');

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

	    var user_history_path = '/dashboard/user-history';
	    // var user_history_path = '/tweetQ11Apr/_www/dashboard/user-history';
		$("#notification-display").click(function(){
            $.ajax({
                type: 'POST',
                url: user_history_path,
                success: function(data) {
                }
            });
   		});

		// ripple effect
		  $(".block-users-tweets-statistics-block .content > div a, .send-tweets-form #edit-submit, .-form-tweets-queue-csv-upload #edit-submit").click(function (e) {

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
		$('.messages, .messages--error').delay(8000).fadeOut(300);

		// Message position changes.
		$(".messages").appendTo(".item-list + .item-list").insertBefore(".item-list + .item-list > ul");

		// text overlimit color change.
		// $('.send-tweets-form #edit-message').on({
		//     focus: function() {
		        
		//         if (this.value.length >= 20) $('#edit-message').focus(){
		//         	$(this).addClass("red");
		//         };
		//     }
		// })

	});

})(jQuery);


