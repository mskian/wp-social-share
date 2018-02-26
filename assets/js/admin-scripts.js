jQuery(function($){
    // manage tabs
	$(document).on('click', '.joomdev-wss-options-box-menubar a', function(){
		$('.joomdev-wss-options-box-menubar ul li').removeClass('active');
		$(this).closest('li').addClass('active');

		$('.joomdev-wss-options-box-options-single').fadeOut('fast');
		var t = $(this).data('tab-name');

        var d = new Date();
        d.setTime(d.getTime() + (1*24*60*60*1000)); // for 1 day
        var expires = "expires="+ d.toUTCString();

        document.cookie = 'joomdev_wss_admin_tab' + "=" + t + ";" + expires + ";path=/";

		$(document).find('[data-tab="'+t+'"]').fadeIn('slow');
	});

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

    var _sortable_selections = function(action){
    	if(action == 'destroy'){
    		$( ".joomdev-networks-selected" ).sortable('destroy');
    	}
    	else if(action == 'refresh'){
    		$( ".joomdev-networks-selected" ).sortable('refresh');
    	}
    	else{
			$( ".joomdev-networks-selected" ).sortable({
		      	placeholder: "ui-state-highlight"
		    });
		    $( ".joomdev-networks-selected" ).disableSelection();
    	}
    };
    _sortable_selections(false);

    var network_string = '<div class="joomdev-networks-selected-single joomdev-wss-networks-[network]">'+
                            '<i class="fa fa-ellipsis-v"></i>'+
                            '<a href="javascript:;" class="joomdev-networks-selected-single-button joomdev-networks-[network]"  data-network="[network]">'+
                                '<i class="fa fa-[class]"></i>'+
                                '<i class="fa fa-close"></i>'+
                            '</a>'+
                            '<input type="text" name="joomdev_wss_options[networks][[network]]" class="joomdev-wss-regular-text" value="[label]">'+
                        '</div>';

    $(document).on('click', '.joomdev-networks-popup-save', function(e){
    	e.preventDefault();

    	$('.joomdev-networks-selected').html('');
    	$(document).find('.joomdev-networks-single.joomdev-networks-single-selected').each(function(){

    		var network_name = $(this).find('a.joomdev-networks-single-button').data('network-name');
    		var network_label = $(this).find('a.joomdev-networks-single-button').data('network-label');
    		var network_class = $(this).find('a.joomdev-networks-single-button').data('network-class');

    		var network_s = network_string.replace(/\[network\]/g, network_name);
    		network_s = network_s.replace(/\[label\]/g, network_label);
    		network_s = network_s.replace(/\[class\]/g, network_class);

    		_sortable_selections('destroy');
    		$('.joomdev-networks-selected').append(network_s);
    		_sortable_selections(false);
    		$('.joomdev-networks-popup-outlay').addClass('joomdev-networks-popup-outlay-toggle');

    	});
    });

    $(document).on('click', '.joomdev-networks-selected-single-button', function(){
    	var network = $(this).data('network');
    	$(this).closest('.joomdev-networks-selected-single').remove();
    	$('.joomdev-networks-single.joomdev-networks-single-' + network).removeClass('joomdev-networks-single-selected');
    	_sortable_selections('refresh');
    });

    $(document).on('change', '.joomdev-wss-url_shorting', function(){
    	var url_shorting = '';
    	$('.joomdev-wss-url_shorting-box').slideUp('fast');
    	$(document).find('.joomdev-wss-url_shorting').each(function(){
    		if($(this).is(':checked')){
    			url_shorting = $(this).val();
    		}
    	});
        url_shorting = url_shorting.replace('.', '_');
    	$('.joomdev-wss-url_shorting-box.url_shorting_' + url_shorting).slideDown('slow');
    });
});