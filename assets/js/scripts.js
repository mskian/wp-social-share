jQuery(function($){
	$(document).on('click', '.joomdev-networks-popup-open', function(e){
		e.preventDefault();

		$('.joomdev-networks-popup-outlay').removeClass('joomdev-networks-popup-outlay-toggle');
	});

	$(document).on('click', '.joomdev-networks-popup-close', function(e){
		e.preventDefault();

		$('.joomdev-networks-popup-outlay').addClass('joomdev-networks-popup-outlay-toggle');
	});
});