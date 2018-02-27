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
				'default_share_count' => '0',
				'enable_share_incentive' => 'no',
				'share_incentive' => '',
				'hide_on_mobile_top_of_the_content' => 'yes',
				'hide_on_mobile_bottom_of_the_content' => 'yes',
				'hide_on_mobile_sidebar' => 'yes',
				'hide_on_mobile_media' => 'yes',
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
					'buffer' => array('label' => 'Buffer', 'class' => '', 'font_awesome_class' => 'buffer jd-font'),
					'digg' => array('label' => 'Digg', 'class' => '', 'font_awesome_class' => 'digg'),
					'evernote' => array('label' => 'Evernote', 'class' => '', 'font_awesome_class' => 'evernote jd-font'),
					'pinterest' => array('label' => 'Pinterest', 'class' => '', 'font_awesome_class' => 'pinterest-p'),
					'friendfeed' => array('label' => 'FriendFeed', 'class' => '', 'font_awesome_class' => 'friendfeed jd-font'),
					'hackernews' => array('label' => 'Hacker News', 'class' => '', 'font_awesome_class' => 'hacker-news'),
					'livejournal' => array('label' => 'LiveJournal', 'class' => '', 'font_awesome_class' => 'livejournal jd-font'),
					'newsvine' => array('label' => 'Newsvine', 'class' => '', 'font_awesome_class' => 'newsvine jd-font'),
					'aol' => array('label' => 'AOL', 'class' => '', 'font_awesome_class' => 'aol jd-font'),
					'gmail' => array('label' => 'Gmail', 'class' => '', 'font_awesome_class' => 'envelope'),
					'printfriendly' => array('label' => 'Print Friendly', 'class' => '', 'font_awesome_class' => 'printfriendly jd-font'),
					'yahoomail' => array('label' => 'Yahoo Mail', 'class' => '', 'font_awesome_class' => 'envelope'),
					'delicious' => array('label' => 'Delicious', 'class' => '', 'font_awesome_class' => 'delicious'),
					'reddit' => array('label' => 'Reddit', 'class' => '', 'font_awesome_class' => 'reddit-alien'),
					'vkontakte' => array('label' => 'VKontakte', 'class' => '', 'font_awesome_class' => 'vk'),
					'linkedin' => array('label' => 'Linkedin', 'class' => '', 'font_awesome_class' => 'linkedin'),
					'myspace' => array('label' => 'Myspace', 'class' => '', 'font_awesome_class' => 'myspace jd-font'),
					'blogger' => array('label' => 'Blogger', 'class' => '', 'font_awesome_class' => 'blogger jd-font'),
					'stumbleupon' => array('label' => 'StumbleUpon', 'class' => '', 'font_awesome_class' => 'stumbleupon'),
					'tumblr' => array('label' => 'Tumblr', 'class' => '', 'font_awesome_class' => 'tumblr'),
					'whatsapp' => array('label' => 'WhatsApp', 'class' => '', 'font_awesome_class' => 'whatsapp'),
				);

	return $networks;
}

add_action( 'wp_ajax_joomdev_wss_increase_share_count', 'joomdev_wss_increase_share_count' );
add_action( 'wp_ajax_nopriv_joomdev_wss_increase_share_count', 'joomdev_wss_increase_share_count' );
function joomdev_wss_increase_share_count(){
	$id = $_POST['id'];
	$network = $_POST['network'];

	$current_network_count = (int)get_post_meta($id, 'joomdev_wss_' . $network . '_share_count', true);
	$current_total_count = (int)get_post_meta($id, 'joomdev_wss_total_share_count', true);

	$updated_network_count = $current_network_count + 1;
	$updated_total_count = $current_total_count + 1;

	update_post_meta($id, 'joomdev_wss_' . $network . '_share_count', $updated_network_count);
	update_post_meta($id, 'joomdev_wss_total_share_count', $updated_total_count);

	$r = array('status' => 'ok', 'message' => '');
	$json = json_encode($r);
	die($r);
}

add_action('admin_footer', 'joomdev_wss_networks_in_admin_footer', 99);
function joomdev_wss_networks_in_admin_footer(){
	$joomdev_wss_networks = get_joomdev_wss_networks();
	?>
    <script type="text/javascript">
        var joomdev_wss_networks = '<?php echo json_encode($joomdev_wss_networks); ?>';

    </script>
    <?php
}

add_action('wp_footer', 'joomdev_wss_networks_in_footer', 99);
function joomdev_wss_networks_in_footer(){
	$joomdev_wss_networks = get_joomdev_wss_networks();
	?>
        <script type="text/javascript">
            var joomdev_wss_networks = '<?php echo json_encode($joomdev_wss_networks); ?>';

        </script>
        <script type="text/javascript">
            jQuery(function($) {
                $(document).on('click', 'a.joomdev-wss-popup', function(e) {
                    e.preventDefault();
                    var this_link = $(this);

                    var newwindow = window.open(this_link.data("href"), "", "height=470,width=470");
                    if (window.focus) {
                        newwindow.focus();
                    }

                    // run ajax to increase total count
                    var network = this_link.data('network');
                    var id = this_link.data('id');
                    $.ajax({
                        url: '<?php echo admin_url("admin-ajax.php"); ?>',
                        method: 'POST',
                        data: {
                            'action': 'joomdev_wss_increase_share_count',
                            'network': network,
                            'id': id,
                        },
                        dataType: 'JSON',
                        success: function(r) {
                            // do something
                        }
                    });
                });
            });

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

function joomdev_wss_get_network_url($network, $permalink, $title = '', $handler = '', $hashtags = ''){

	$url = '';
	$permalink = urlencode($permalink);
	$hashtags = str_replace('#', '', $hashtags);
	$title = urlencode($title);
	$handler = str_replace('@', '', $handler);
	$handler = urlencode($handler);
	$hashtags = urlencode($hashtags);

	switch ($network) {
		case 'facebook':
			$url = 'http://www.facebook.com/sharer.php?u='.$permalink.'&t='.$title;
			break;

		case 'twitter':
			$url = 'http://twitter.com/share?text='.$title.'&url='.$permalink.'&via='.$handler.'&hashtags='.$hashtags;
			break;

		case 'googleplus':
			$url = 'https://plus.google.com/share?url='.$permalink.'&t='.$title;
			break;

		case 'buffer':
			$url = 'https://bufferapp.com/add?url='.$permalink.'&title='.$title;
			break;

		case 'digg':
			$url = 'http://digg.com/submit?url='.$permalink.'&title='.$title;
			break;

		case 'evernote':
			$url = 'http://www.evernote.com/clip.action?url='.$permalink.'&title='.$title;
			break;

		case 'pinterest':
			$url = 'http://www.pinterest.com/pin/create/button/?url='.$permalink.'&description='.$title;
			break;

		case 'friendfeed':
			$url = 'http://friendfeed.com/?url='.$permalink;
			break;

		case 'hackernews':
			$url = 'https://news.ycombinator.com/submitlink?u='.$permalink.'&t='.$title;
			break;

		case 'livejournal':
			$url = 'http://www.livejournal.com/update.bml?subject='.$title.'&event='.$permalink;
			break;

		case 'newsvine':
			$url = 'http://www.newsvine.com/_tools/seed&save?u='.$permalink.'&h='.$title;
			break;

		case 'aol':
			$url = 'http://webmail.aol.com/Mail/ComposeMessage.aspx?subject='.$title.'&body='.$permalink;
			break;

		case 'gmail':
			$url = 'https://mail.google.com/mail/u/0/?view=cm&fs=1&su='.$title.'&body='.$permalink.'&ui=2&tf=1';
			break;

		case 'printfriendly':
			$url = 'http://www.printfriendly.com/print?url='.$permalink.'&title='.$title;
			break;

		case 'yahoomail':
			$url = 'http://compose.mail.yahoo.com/?body='.$permalink;
			break;

		case 'delicious':
			$url = 'https://delicious.com/post?url='.$permalink.'&title='.$title;
			break;

		case 'reddit':
			$url = 'http://www.reddit.com/submit?url='.$permalink.'&title='.$title;
			break;

		case 'vkontakte':
			$url = 'http://vk.com/share.php?url='.$permalink;
			break;

		case 'linkedin':
			$url = 'http://www.linkedin.com/shareArticle?mini=true&url='.$permalink.'&title='.$title;
			break;

		case 'myspace':
			$url = 'https://myspace.com/post?u='.$permalink;
			break;

		case 'blogger':
			$url = 'https://www.blogger.com/blog_this.pyra?t&u='.$permalink.'&n='.$title;
			break;

		case 'stumbleupon':
			$url = 'http://www.stumbleupon.com/badge?url='.$permalink.'&title='.$title;
			break;

		case 'tumblr':
			$url = 'http://www.tumblr.com/share?t='.$title.'&u='.$permalink;
			break;

		case 'whatsapp':
			$url = 'whatsapp://send?text='.$title.'&'.$permalink;
			break;
		
		default:
			$url = '';
			break;
	}

	return $url;
}

function joomdev_wss_get_short_url($options, $url = ''){
	$short_link = '';
	if($url){
		if($options['url_shorting'] == 'bit.ly'){
			include_once 'lib/bitly.php';
			$bit_ly_username = $options['bit_ly_username'];
			$bit_ly_access_token = $options['bit_ly_access_token'];

			$bitly  =  new Bitly();
			$params = array();
			$params['access_token'] = $bit_ly_access_token;
			$params['longUrl'] = $url;
			$params['domain'] = 'bit.ly';			
			$results = $bitly->bitly_get('shorten', $params); 
			if(isset($results['status_code']) && $results['status_code'] == 200){
				$short_link = (isset($results['data']['url'])) ? $results['data']['url'] : $url;
			}
		}
		if($options['url_shorting'] == 'goo.gl'){
			include_once 'lib/googleurl.php';
			$goo_gl_api_key = $options['goo_gl_api_key'];

			$GoogleUrlApi = new GoogleUrlApi($goo_gl_api_key);
			$short_link = $GoogleUrlApi->shorten($url);
		}
	}

	$short_link = $short_link ? $short_link : $url;
	return $short_link;
}

function joomdev_wss_generate_share_buttons_top_of_content($content){
	$joomdev_wss_options = get_joomdev_wss_options();
	if($joomdev_wss_options['hide_on_mobile_top_of_the_content'] == 'yes' && wp_is_mobile()){
		return '';
	}

	ob_start();
	global $post;

	$selected_networks = $joomdev_wss_options['networks'];
	$networks = get_joomdev_wss_networks();

	$short_link = joomdev_wss_get_short_url($joomdev_wss_options, get_permalink($post->ID));

	if(!empty($selected_networks)){
		?>
        <div class="joomdev-wss-social-share-buttons joomdev-wss-social-share-buttons-top">
            <?php 
					// if($joomdev_wss_options['share_incentive'] && $joomdev_wss_options['enable_share_incentive'] == 'yes'){
					// 	echo '<div class="joomdev-wss-social-share-incentive">'.$joomdev_wss_options['share_incentive'].'</div>';
					// }

					if($joomdev_wss_options['show_share_count'] == 'yes'){
						$meta_name = 'joomdev_wss_total_share_count';
						$meta_value = (int)get_post_meta($post->ID, $meta_name, true);
						$meta_value = $meta_value + $joomdev_wss_options['default_share_count'];
						?>
            <div class="joomdev-wss-share-count-total">
                <?php echo $meta_value; ?> Shares
            </div>
            <?php 
					}
				
					foreach ($selected_networks as $key => $value) {
						$network = $networks[$key];

						$button_label = '<i class="fa fa-'.$network['font_awesome_class'].'"></i>';
						$button_label = $button_label . ' <span>'.$value.'</span>';
						if($joomdev_wss_options['buttons_animation'] == 'animation-2'){
							$button_label = $button_label . ' <i class="fa fa-'.$network['font_awesome_class'].'"></i>';
						}
						if($joomdev_wss_options['buttons_animation'] == 'animation-1'){
							$button_label = '<i class="fa fa-'.$network['font_awesome_class'].'"></i> ' . $value;
						}

						$classes = 'joomdev-wss-button-'.$key.' joomdev-wss-button-'.$joomdev_wss_options['buttons_format'].' joomdev-wss-button-'.$joomdev_wss_options['button_shape'].' joomdev-wss-button-'.$joomdev_wss_options['buttons_animation'];
						$network_url = joomdev_wss_get_network_url($key, $short_link, get_the_title($post->ID), $joomdev_wss_options['twitter_handler'], $joomdev_wss_options['default_tags']); //$network['url'];

						echo '<div class="joomdev-wss-social-share-button joomdev-wss-social-share-'.$joomdev_wss_options['buttons_format'].'">';
						/*if($joomdev_wss_options['show_share_count'] == 'yes'){
							$meta_name = 'joomdev_wss_' . $key . '_share_count';
							$meta_value = (int)get_post_meta($post->ID, $meta_name, true);
							?>
            <div class="joomdev-wss-share-count">
                <?php echo $meta_value; ?>
            </div>
            <?php 
						}*/
						?>
            <a data-network="<?php echo $key; ?>" data-id="<?php echo $post->ID; ?>" class="joomdev-wss-popup <?php echo $classes; ?>" href="javascript:;" data-href="<?php echo $network_url; ?>">
                <?php echo $button_label; ?>
            </a>
            <?php 
						echo '</div>';
 
					}
				?>
            <!-- <a href="javascript:;" class="joomdev-wss-social-share-more-buttons joomdev-wss-button-<?php echo $joomdev_wss_options['button_shape'] ?>"><i class="fa fa-plus"></i></a> -->
        </div>
        <?php 
	}

	echo $content;
	return ob_get_clean();
}

function joomdev_wss_generate_share_buttons_bottom_of_content($content){
	$joomdev_wss_options = get_joomdev_wss_options();
	if($joomdev_wss_options['hide_on_mobile_bottom_of_the_content'] == 'yes' && wp_is_mobile()){
		return '';
	}

	ob_start();
	echo $content;

	global $post;

	$selected_networks = $joomdev_wss_options['networks'];
	$networks = get_joomdev_wss_networks();

	$short_link = joomdev_wss_get_short_url($joomdev_wss_options, get_permalink($post->ID));

	if(!empty($selected_networks)){
		?>
        <div class="joomdev-wss-social-share-buttons joomdev-wss-social-share-buttons-bottom">
            <?php 
					if($joomdev_wss_options['share_incentive'] && $joomdev_wss_options['enable_share_incentive'] == 'yes'){
						echo '<div class="joomdev-wss-social-share-incentive">'.$joomdev_wss_options['share_incentive'].'</div>';
					}

					if($joomdev_wss_options['show_share_count'] == 'yes'){
						$meta_name = 'joomdev_wss_total_share_count';
						$meta_value = (int)get_post_meta($post->ID, $meta_name, true);
						$meta_value = $meta_value + $joomdev_wss_options['default_share_count'];
						?>
            <div class="joomdev-wss-share-count-total">
                <?php echo $meta_value; ?> Shares
            </div>
            <?php 
					}
				
					foreach ($selected_networks as $key => $value) {
						$network = $networks[$key];

						$button_label = '<i class="fa fa-'.$network['font_awesome_class'].'"></i>';
						$button_label = $button_label . ' <span>'.$value.'</span>';
						if($joomdev_wss_options['buttons_animation'] == 'animation-2'){
							$button_label = $button_label . ' <i class="fa fa-'.$network['font_awesome_class'].'"></i>';
						}
						if($joomdev_wss_options['buttons_animation'] == 'animation-1'){
							$button_label = '<i class="fa fa-'.$network['font_awesome_class'].'"></i> ' . $value;
						}

						$classes = 'joomdev-wss-button-'.$key.' joomdev-wss-button-'.$joomdev_wss_options['buttons_format'].' joomdev-wss-button-'.$joomdev_wss_options['button_shape'].' joomdev-wss-button-'.$joomdev_wss_options['buttons_animation'];
						$network_url = joomdev_wss_get_network_url($key, $short_link, get_the_title($post->ID), $joomdev_wss_options['twitter_handler'], $joomdev_wss_options['default_tags']); //$network['url'];

						echo '<div class="joomdev-wss-social-share-button joomdev-wss-social-share-'.$joomdev_wss_options['buttons_format'].'">';
						/*if($joomdev_wss_options['show_share_count'] == 'yes'){
							$meta_name = 'joomdev_wss_' . $key . '_share_count';
							$meta_value = (int)get_post_meta($post->ID, $meta_name, true);
							?>
            <div class="joomdev-wss-share-count">
                <?php echo $meta_value; ?>
            </div>
            <?php 
						}*/
						?>
            <a data-network="<?php echo $key; ?>" data-id="<?php echo $post->ID; ?>" class="joomdev-wss-popup <?php echo $classes; ?>" href="javascript:;" data-href="<?php echo $network_url; ?>">
                <?php echo $button_label; ?>
            </a>
            <?php 
						echo '</div>';
 
					}
				?>
            <!-- <a href="javascript:;" class="joomdev-wss-social-share-more-buttons joomdev-wss-button-<?php echo $joomdev_wss_options['button_shape'] ?>"><i class="fa fa-plus"></i></a> -->
        </div>
        <?php 
	}

	return ob_get_clean();
}

function joomdev_wss_generate_share_buttons_sidebar(){
	$joomdev_wss_options = get_joomdev_wss_options();
	if($joomdev_wss_options['hide_on_mobile_sidebar'] == 'yes' && wp_is_mobile()){
		return '';
	}

	ob_start();
	global $post;

	$selected_networks = $joomdev_wss_options['networks'];
	$networks = get_joomdev_wss_networks();

	$short_link = joomdev_wss_get_short_url($joomdev_wss_options, get_permalink($post->ID));

	if(!empty($selected_networks)){
		?>
        <div class="joomdev-wss-social-share-buttons joomdev-wss-social-share-buttons-sidebar">
            <div class="joomdev-wss-social-share-buttons-sidebar-inner-container">
                <?php 
					if($joomdev_wss_options['share_incentive']){
						// echo '<div class="joomdev-wss-social-share-incentive">'.$joomdev_wss_options['share_incentive'].'</div>';
						// echo '<div class="joomdev-wss-social-share-incentive">&nbsp;&nbsp;<i class="fa fa-share-alt"></i></div>';
					}

					if($joomdev_wss_options['show_share_count'] == 'yes'){
						$meta_name = 'joomdev_wss_total_share_count';
						$meta_value = (int)get_post_meta($post->ID, $meta_name, true);
						$meta_value = $meta_value + $joomdev_wss_options['default_share_count'];
						?>
                <div class="joomdev-wss-share-count-total">
                    <?php echo $meta_value; ?> Shares
                </div>
                <?php 
					}
				
					$total_networks_selected = count($selected_networks);
					$n = 0;
					$class_more = '';
					foreach ($selected_networks as $key => $value) {
						$network = $networks[$key];

						$button_label = '<i class="fa fa-'.$network['font_awesome_class'].'"></i>';
						$button_label = $button_label . ' <span>'.$value.'</span>';
						if($joomdev_wss_options['buttons_animation'] == 'animation-2'){
							$button_label = $button_label . ' <i class="fa fa-'.$network['font_awesome_class'].'"></i>';
						}
						if($joomdev_wss_options['buttons_animation'] == 'animation-1'){
							$button_label = '<i class="fa fa-'.$network['font_awesome_class'].'"></i> ' . $value;
						}

						$class_more = $classes = 'joomdev-wss-button-'.$key.' joomdev-wss-button-'.$joomdev_wss_options['buttons_format'].' joomdev-wss-button-'.$joomdev_wss_options['button_shape'].' joomdev-wss-button-'.$joomdev_wss_options['buttons_animation'];
						$network_url = joomdev_wss_get_network_url($key, $short_link, get_the_title($post->ID), $joomdev_wss_options['twitter_handler'], $joomdev_wss_options['default_tags']); //$network['url'];

						echo '<div class="joomdev-wss-social-share-button joomdev-wss-social-share-'.$joomdev_wss_options['buttons_format'].'">';
						/*if($joomdev_wss_options['show_share_count'] == 'yes'){
							$meta_name = 'joomdev_wss_' . $key . '_share_count';
							$meta_value = (int)get_post_meta($post->ID, $meta_name, true);
							?>
				                <div class="joomdev-wss-share-count">
				                    <?php echo $meta_value; ?>
				                </div>
			                <?php 
						}*/
						?>
			                <a data-network="<?php echo $key; ?>" data-id="<?php echo $post->ID; ?>" class="joomdev-wss-popup <?php echo $classes; ?>" href="javascript:;" data-href="<?php echo $network_url; ?>">
			                    <?php echo $button_label; ?>
			                </a>
		                <?php 
							echo '</div>';


						$n = $n + 1; 
						if($n >= 5){
							break;
						}
					}

					if($n >= 5){
						echo '<div class="joomdev-wss-social-share-button joomdev-wss-social-share-'.$joomdev_wss_options['buttons_format'].'">';
							?>
				                <a data-network="more" data-id="more" class="joomdev-wss-popup-more <?php echo $class_more; ?>" href="javascript:;" data-href="javascript:;">
				                    <i class="fa fa-ellipsis-h"></i>
				                    <?php 
				                    	/*if($joomdev_wss_options['share_incentive']){
											echo '<div class="joomdev-wss-social-share-incentive">'.$joomdev_wss_options['share_incentive'].'</div>';
										}*/
				                    ?>
				                </a>
			                <?php 
						echo '</div>';
						?>
							<div class="joomdev-wss-social-share-popup-more">
								<?php 
									$i = 0;
									foreach ($selected_networks as $key => $value) {

										$i = $i + 1;
										if($i <= 5){
											continue;
										}

										$network = $networks[$key];

										$button_label = '<i class="fa fa-'.$network['font_awesome_class'].'"></i>';
										$button_label = $button_label . ' <span>'.$value.'</span>';
										if($joomdev_wss_options['buttons_animation'] == 'animation-2'){
											$button_label = $button_label . ' <i class="fa fa-'.$network['font_awesome_class'].'"></i>';
										}
										if($joomdev_wss_options['buttons_animation'] == 'animation-1'){
											$button_label = '<i class="fa fa-'.$network['font_awesome_class'].'"></i> ' . $value;
										}

										$class_more = $classes = 'joomdev-wss-button-'.$key.' joomdev-wss-button-'.$joomdev_wss_options['buttons_format'].' joomdev-wss-button-'.$joomdev_wss_options['button_shape'].' joomdev-wss-button-'.$joomdev_wss_options['buttons_animation'];
										$network_url = joomdev_wss_get_network_url($key, $short_link, get_the_title($post->ID), $joomdev_wss_options['twitter_handler'], $joomdev_wss_options['default_tags']); //$network['url'];

										echo '<div class="joomdev-wss-social-share-button joomdev-wss-social-share-'.$joomdev_wss_options['buttons_format'].'">';
										?>
							                <a data-network="<?php echo $key; ?>" data-id="<?php echo $post->ID; ?>" class="joomdev-wss-popup <?php echo $classes; ?>" href="javascript:;" data-href="<?php echo $network_url; ?>">
							                    <?php echo $button_label; ?>
							                </a>
						                <?php 
											echo '</div>';
									}
								?>
							</div>
						<?php 
					}
				?>

                <!-- <a href="javascript:;" class="joomdev-wss-social-share-more-buttons joomdev-wss-button-<?php echo $joomdev_wss_options['button_shape'] ?>"><i class="fa fa-plus"></i></a> -->
            </div>
        </div>
        <?php 
	}

	echo ob_get_clean();
}

function joomdev_wss_generate_share_buttons_media(){
	/*global $post;
	// echo 'media';
	$content = $post->post_content;
	$searchimages = '~<img [^>]* />~';
	 
	// Run preg_match_all to grab all the images and save the results in $pics
	 
	preg_match_all( $searchimages, $content, $pics );
	echo '<pre>'; print_r($pics);die;
	// Check to see if we have at least 1 image
	$number_of_pics = count($pics[0]);
	 
	if ( $number_of_pics > 0 ) {
	     // Your post have one or more images.
	}*/
	

	// ob_start();
	global $post;

	$joomdev_wss_options = get_joomdev_wss_options();
	if($joomdev_wss_options['hide_on_mobile_media'] == 'yes' && wp_is_mobile()){
		return '';
	}
	
	$selected_networks = $joomdev_wss_options['networks'];
	$networks = get_joomdev_wss_networks();

	$short_link = joomdev_wss_get_short_url($joomdev_wss_options, get_permalink($post->ID));

	if(!empty($selected_networks)){
		?>
        <div class="joomdev-wss-social-share-buttons-media-box" style="display:none;">
            <div class="joomdev-wss-social-share-buttons joomdev-wss-social-share-buttons-media">
                <?php 
						if($joomdev_wss_options['share_incentive']){
							// echo '<div class="joomdev-wss-social-share-incentive">'.$joomdev_wss_options['share_incentive'].'</div>';
						}

						if($joomdev_wss_options['show_share_count'] == 'yes'){
							$meta_name = 'joomdev_wss_total_share_count';
							$meta_value = (int)get_post_meta($post->ID, $meta_name, true);
							$meta_value = $meta_value + $joomdev_wss_options['default_share_count'];
							?>
                <div class="joomdev-wss-share-count-total">
                    <?php echo $meta_value; ?> Shares
                </div>
                <?php 
						}
					
						foreach ($selected_networks as $key => $value) {
							$network = $networks[$key];

							$button_label = '<i class="fa fa-'.$network['font_awesome_class'].'"></i>';
							$button_label = $button_label . ' <span>'.$value.'</span>';
							if($joomdev_wss_options['buttons_animation'] == 'animation-2'){
								$button_label = $button_label . ' <i class="fa fa-'.$network['font_awesome_class'].'"></i>';
							}
							if($joomdev_wss_options['buttons_animation'] == 'animation-1'){
								$button_label = '<i class="fa fa-'.$network['font_awesome_class'].'"></i> ' . $value;
							}

							$classes = 'joomdev-wss-button-'.$key.' joomdev-wss-button-'.$joomdev_wss_options['buttons_format'].' joomdev-wss-button-'.$joomdev_wss_options['button_shape'].' joomdev-wss-button-'.$joomdev_wss_options['buttons_animation'];
							$network_url = joomdev_wss_get_network_url($key, $short_link, get_the_title($post->ID), $joomdev_wss_options['twitter_handler'], $joomdev_wss_options['default_tags']); //$network['url'];

							echo '<div class="joomdev-wss-social-share-button joomdev-wss-social-share-'.$joomdev_wss_options['buttons_format'].'">';
							/*if($joomdev_wss_options['show_share_count'] == 'yes'){
								$meta_name = 'joomdev_wss_' . $key . '_share_count';
								$meta_value = (int)get_post_meta($post->ID, $meta_name, true);
								?>
                <div class="joomdev-wss-share-count">
                    <?php echo $meta_value; ?>
                </div>
                <?php 
							}*/
							?>
                <a data-network="<?php echo $key; ?>" data-id="<?php echo $post->ID; ?>" class="joomdev-wss-popup <?php echo $classes; ?>" href="javascript:;" data-href="<?php echo $network_url; ?>">
                    <?php echo $button_label; ?>
                </a>
                <?php 
							echo '</div>';
	 
						}
					?>
                <!-- <a href="javascript:;" class="joomdev-wss-social-share-more-buttons joomdev-wss-button-<?php echo $joomdev_wss_options['button_shape'] ?>"><i class="fa fa-plus"></i></a> -->
            </div>
        </div>

        <script type="text/javascript">
            jQuery(function($) {
                $(document).find('img').each(function() {
                    var this_html = $('.joomdev-wss-social-share-buttons-media-box').html();
                    $(this).wrap('<span class="joomdev-wss-social-share-buttons-media-wrapper">' + this_html + '</span>');
                });
            });

        </script>
        <?php 
	}

	// echo ob_get_clean();
}

// file ends here...
