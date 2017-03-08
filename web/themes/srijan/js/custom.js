//custom js.

(function ($) {
	$(document).ready(function(){
		$(".-form-tweets-queue-csv-upload .description").insertAfter(".-form-tweets-queue-csv-upload #edit-submit");
		$("#block-usersdashboardheaderblock .content").append("<a href='#;'></a>");
		$("#block-usersdashboardheaderblock .profile + a").click(function() {
			$(this).toggleClass("active");
			$(this).siblings(".notifications").children(".notification-message-list").toggleClass("active");
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

	    // profile dropdown.
	    $("#block-usersdashboardheaderblock .profile a").click(function() {
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
	});

})(jQuery);
