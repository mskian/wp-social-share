jQuery(function($){
	$(document).on('click', '.joomdev-networks-popup-open', function(e){
		e.preventDefault();

		$('.joomdev-networks-popup-outlay').removeClass('joomdev-networks-popup-outlay-toggle');
	});

	$(document).on('click', '.joomdev-networks-popup-close', function(e){
		e.preventDefault();

		$('.joomdev-networks-popup-outlay').addClass('joomdev-networks-popup-outlay-toggle');
	});

	$(document).on('click', '.joomdev-networks-single-button', function(){
		$(this).closest('.joomdev-networks-single').toggleClass('joomdev-networks-single-selected');
	});

	$(document).on('click', '.joomdev-wss-options-box-menubar a', function(){
		$('.joomdev-wss-options-box-menubar ul li').removeClass('active');
		$(this).closest('li').addClass('active');

		$('.joomdev-wss-options-box-options-single').fadeOut('fast');
		var t = $(this).data('tab-name');
		$(document).find('[data-tab="'+t+'"]').fadeIn('slow');
	});
});