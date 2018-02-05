<?php
function get_joomdev_wss_plugin_info(){
	return get_plugin_data(JOOMDEV_WSS_PLUGIN_FILE, false);
}

function get_joomdev_wss_options(){
	$default = array(
				'networks' => array(),
				'button_locations' => array(),
				'display_buttons_in' => array(),
				'url_shorting' => 'bit.ly',
				'bit_ly_username' => '',
				'bit_ly_access_token' => '',
				'goo_gl_api_key' => '',
				'twitter_handler' => '',
				'default_tags' => '',
				'buttons_format' => 'icon_only',
				'button_shape' => 'shape-1',
				'buttons_animation' => 'animation-1',
				'show_share_count' => 'no',
				'share_incentive' => '',
			);

	global $JoomDev_wss_options;
	$options = get_option('joomdev_wss_options', array());

	$JoomDev_wss_options = shortcode_atts($default, $options);
	return $JoomDev_wss_options;
}

function get_joomdev_wss_networks(){
	$networks = array(
					'facebook' => array('label' => 'Facebook', 'class' => '', 'font_awesome_class' => 'facebook'),
					'twitter' => array('label' => 'Twitter', 'class' => '', 'font_awesome_class' => 'twitter'),
					'googleplus' => array('label' => 'Google Plus', 'class' => '', 'font_awesome_class' => 'google-plus'),
					'buffer' => array('label' => 'Buffer', 'class' => '', 'font_awesome_class' => 'buffer'),
					'digg' => array('label' => 'Digg', 'class' => '', 'font_awesome_class' => 'digg'),
					'evernote' => array('label' => 'Evernote', 'class' => '', 'font_awesome_class' => 'evernote'),
					'pinterest' => array('label' => 'Pinterest', 'class' => '', 'font_awesome_class' => 'pinterest-p'),
					'friendfeed' => array('label' => 'FriendFeed', 'class' => '', 'font_awesome_class' => 'friendfeed'),
					'hackernews' => array('label' => 'Hacker News', 'class' => '', 'font_awesome_class' => 'hacker-news'),
					'livejournal' => array('label' => 'LiveJournal', 'class' => '', 'font_awesome_class' => 'livejournal'),
					'newsvine' => array('label' => 'Newsvine', 'class' => '', 'font_awesome_class' => 'newsvine'),
					'aol' => array('label' => 'AOL', 'class' => '', 'font_awesome_class' => 'aol'),
					'gmail' => array('label' => 'Gmail', 'class' => '', 'font_awesome_class' => 'envelope'),
					'printfriendly' => array('label' => 'Print Friendly', 'class' => '', 'font_awesome_class' => 'printfriendly'),
					'yahoomail' => array('label' => 'Yahoo Mail', 'class' => '', 'font_awesome_class' => 'envelope'),
					'delicious' => array('label' => 'Delicious', 'class' => '', 'font_awesome_class' => 'delicious'),
					'reddit' => array('label' => 'Reddit', 'class' => '', 'font_awesome_class' => 'reddit-alien'),
					'vkontakte' => array('label' => 'VKontakte', 'class' => '', 'font_awesome_class' => 'vk'),
					'linkedin' => array('label' => 'Linkedin', 'class' => '', 'font_awesome_class' => 'linkedin'),
					'myspace' => array('label' => 'Myspace', 'class' => '', 'font_awesome_class' => 'myspace'),
					'blogger' => array('label' => 'Blogger', 'class' => '', 'font_awesome_class' => 'blogger'),
					'stumbleupon' => array('label' => 'StumbleUpon', 'class' => '', 'font_awesome_class' => 'stumbleupon'),
					'tumblr' => array('label' => 'Tumblr', 'class' => '', 'font_awesome_class' => 'tumblr'),
					'whatsapp' => array('label' => 'WhatsApp', 'class' => '', 'font_awesome_class' => 'whatsapp'),
				);

	return $networks;
}

add_action('admin_footer', 'joomdev_wss_networks_in_footer', 99);
add_action('wp_footer', 'joomdev_wss_networks_in_footer', 99);
function joomdev_wss_networks_in_footer(){
	$joomdev_wss_networks = get_joomdev_wss_networks();
	?>
		<script type="text/javascript">
            var joomdev_wss_networks = '<?php echo json_encode($joomdev_wss_networks); ?>';
        </script>
	<?Php 
}

// add_action('init', 'joomdev_wss_init_share_buttons', 9999);
// add_action('pre_get_posts', 'joomdev_wss_init_share_buttons', 9999);
// add_filter('template_include', 'joomdev_wss_init_share_buttons', 9999);
add_action('template_redirect', 'joomdev_wss_init_share_buttons', 9999);
function joomdev_wss_init_share_buttons(){
	$joomdev_wss_options = get_joomdev_wss_options();

	$selected_networks = $joomdev_wss_options['networks'];
	if(!empty($selected_networks)){
		$networks = get_joomdev_wss_networks();

		// check if post selected to display the share buttons
		$locations = $joomdev_wss_options['button_locations'];
		$display_in = $joomdev_wss_options['display_buttons_in'];
		global $post;
		if(!empty($display_in)){
			if(is_single() || is_singular()){
				if(in_array(get_post_type($post->ID), $display_in)){
					// check if location selected
					if(is_array($locations) && in_array('top_of_content', $locations)){
						add_filter('the_content', 'joomdev_wss_generate_share_buttons_top_of_content', 999);
					}
					if(is_array($locations) && in_array('bottom_of_content', $locations)){
						add_filter('the_content', 'joomdev_wss_generate_share_buttons_bottom_of_content', 999);
					}
					
					if(is_array($locations) && in_array('sidebar', $locations)){
						add_action('wp_footer', 'joomdev_wss_generate_share_buttons_sidebar', 999);
					}
					
					if(is_array($locations) && in_array('media', $locations)){
						add_action('wp_footer', 'joomdev_wss_generate_share_buttons_media', 999);
					}
				}
			}
		}



	}
}

function joomdev_wss_generate_share_buttons_top_of_content($content){
	// echo 'top of content';
	return 'top of content' . $content;
}

function joomdev_wss_generate_share_buttons_bottom_of_content($content){
	// echo 'bottom of content';
	return $content . 'bottom of content';
}

function joomdev_wss_generate_share_buttons_sidebar(){
	echo 'sidebar';
}

function joomdev_wss_generate_share_buttons_media(){
	global $post;
	// echo 'media';
	$content = $post->post_content;
	$searchimages = '~<img [^>]* />~';
	 
	// Run preg_match_all to grab all the images and save the results in $pics
	 
	preg_match_all( $searchimages, $content, $pics );
	 
	// Check to see if we have at least 1 image
	$number_of_pics = count($pics[0]);
	 
	if ( $number_of_pics > 0 ) {
	     // Your post have one or more images.
	}
 
}

// file ends here...