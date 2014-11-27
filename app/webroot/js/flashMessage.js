$(document).ready(function(){
	// fade out good flash messages after 3 seconds
	$('#flashMessages .error').animate({opacity: 1.0}, 1000).fadeOut();
        $('#flashMessages .notice').animate({opacity: 1.0}, 2000).fadeOut();
        $('#flashMessages .success').animate({opacity: 1.0}, 3000).fadeOut();
        $('#flashMessages .warning').animate({opacity: 1.0}, 4000).fadeOut();
});