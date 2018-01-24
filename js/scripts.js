jQuery(function($){
	$(document).on('click', '.joomdev-networks-popup-open', function(e){
		e.preventDefault();

		$('.joomdev-networks-popup-outlay').css('display', 'block');
	});

	$(document).on('click', '.joomdev-networks-popup-close', function(e){
		e.preventDefault();

		$('.joomdev-networks-popup-outlay').css('display', 'none');
	});
});