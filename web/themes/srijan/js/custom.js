//custom js.

(function($) {
	$(document).ready(function(){
		$(".-form-tweets-queue-csv-upload .button").insertAfter("#edit-managed-file-upload #edit-managed-file-upload");
		$("#block-usersdashboardheaderblock .content").append("<a href='#;'></a>");
		$("#block-usersdashboardheaderblock .profile + a").click(function() {
			$(this).toggleClass("active");
			$(this).siblings(".notifications").toggleClass("active");
		});
	});
})(jQuery);


var titleBox = document.getElementById('edit-message');
var tData;
var tweetMaxLimit = 140;
titleBox.onkeyup = function(){
  tData = parseInt(titleBox.value.length);
  left = tweetMaxLimit - tData;
  extra = tData - tweetMaxLimit;
  document.getElementById('edit-display-box').value = left;
}

