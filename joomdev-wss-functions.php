<?php 
function get_joomdev_wss_options(){
	$default = array(
				'networks' => array(),
				'button_locations' => array(),
				'display_buttons_in' => array(),
				'url_shorting' => 'bit.ly',
				'bit.ly_username' => '',
				'bit.ly_access_token' => '',
				'goo.gl_api_key' => '',
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


// file ends here...