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
	// $(".block-tweets-queue .item-list + .item-list ul ul li:first-child").each (function () {
	//   if ($(this).text().length > 140)
	//     $(this).text($(this).text().substring(0,140) + '...');
	// });
    var showChar = 140;  // How many characters are shown by default
    var moretext = "More";
    var lesstext = "Less";
    
    $('.block-tweets-queue .item-list + .item-list ul ul li:first-child').each(function() {
        var content = $(this).html();
 
        if(content.length > showChar) {
 
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
            var html = c + '<span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
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

