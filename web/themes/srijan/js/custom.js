//custom js.

(function($) {
	$(document).ready(function(){
		$(".-form-tweets-queue-csv-upload .button").insertAfter("#edit-managed-file-upload #edit-managed-file-upload");
		$(".block-tweets-queue .content").append("<a href='#;'></a>");
		$(".block-tweets-queue .profile + a").click(function() {
			$(this).toggleClass("active");
			$(this).siblings(".notifications").toggleClass("active");
		});
	});
})(jQuery);