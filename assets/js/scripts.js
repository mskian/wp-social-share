jQuery(function($){

	$(document).on('click', '.joomdev-wss-popup-more', function(e){
        e.preventDefault();
        $(document).find('.joomdev-wss-social-share-popup-more').toggleClass('joomdev-wss-social-share-popup-more-show');
    });
	
});