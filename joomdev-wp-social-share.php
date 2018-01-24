<?php 
/*
	Plugin Name: WP Social Share
	Plugin URI: https://joomdev.com/wordpress-plugins/wp-social-share
	Description: This plugin is very helpful to add social link to your website based on some conditions. Like you can add social links on posts, pages and categories.
	Version: 1.0.0
	Author: JoomDev
	Author URI: https://joomdev.com
*/


global $JoomDev_wss_options;
$JoomDev_wss_options = array();

include 'joomdev-wss-functions.php';

// include script fies.
add_action('admin_enqueue_scripts', 'joomdev_wss_admin_enqueue_scripts', 999);
function joomdev_wss_admin_enqueue_scripts(){
	wp_enqueue_style('joomdev-wss-font-awesome', plugins_url('css/font-awesome.min.css', __FILE__));
	wp_enqueue_style('joomdev-wss-styles', plugins_url('css/styles.css', __FILE__));
	wp_enqueue_script('joomdev-wss-scripts', plugins_url('js/scripts.js', __FILE__));
}

add_action( 'admin_menu', 'joomdev_wss_register_menu_page' );
function joomdev_wss_register_menu_page() {
    add_menu_page(
        'WP Social Share Options',
        'WP Social Share',
        'manage_options',
        'joomdev-wss-social-share-options',
        'joomdev_wss_register_menu_page_callback'
    );
}

add_action( 'admin_init', 'joomdev_wss_register_setting' );
function joomdev_wss_register_setting() {
    register_setting( 'joomdev_wss_options', 'joomdev_wss_options', 'joomdev_wss_register_setting_callback' ); 
}

function joomdev_wss_register_menu_page_callback(){
	?>
		<div class="wrap">
			<h2>WP Social Share Settings</h2>
			<?php 
    			if($_GET['settings-updated']){
					?>
						<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"> 
							<p><strong>Settings saved.</strong></p>
							<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
						</div>
					<?php 
				}
    		?>

    		<form method="post" action="options.php">
    			<?php 
    				settings_fields('joomdev_wss_options');
    				// $joomdev_wss_options = get_option('joomdev_wss_options', array());
    				$joomdev_wss_options = get_joomdev_wss_options();
    			?>

    			<table class="form-table">
    				<tbody>
    					<tr>
    						<th>Select Networks</th>
    						<td>
    							<button type="button" class="button button-primary joomdev-networks-popup-open">Update Social Networks</button>
    							<div class="joomdev-networks-selected"></div>
    							<div class="joomdev-networks-popup-outlay" style="display:none;">
	    							<div class="joomdev-networks-popup">
	    								<div class="joomdev-networks-popup-header">
	    									<h3 class="joomdev-networks-popup-title">Select network to add</h3>
	    									<button type="button" class="joomdev-networks-popup-close"><i class="fa fa-close"></i></button>
	    								</div>
	    								<div class="joomdev-networks-popup-content">
	    									<div class="joomdev-networks-wrapper">
		    									<?php 
		    										$joomdev_wss_networks = get_joomdev_wss_networks();
		    										if(!empty($joomdev_wss_networks)){
		    											foreach ($joomdev_wss_networks as $key => $network) {
		    												?>
		    													<div class="joomdev-networks-single joomdev-networks-single-<?php echo $key; ?>">
		    														<a href="javascript:;" role="button" class="joomdev-networks-single-button joomdev-networks-single-button-<?php echo $key; ?>" data-network="<?php echo $key; ?>">
		    															<i class="joomdev-networks-single-icon-first fa fa-<?php echo $network['font_awesome_class']; ?>"></i>
		    															<?php echo $network['label']; ?>
		    															<i class="joomdev-networks-single-icon-second fa fa-plus"></i>
		    															<i class="joomdev-networks-single-icon-second fa fa-close"></i>
		    															<i class="joomdev-networks-single-icon-second fa fa-check"></i>
		    														</a>
		    													</div>
		    												<?php 
		    											}
		    										}
		    									?>
	    									</div>
	    								</div>
	    								<div class="joomdev-networks-popup-footer">
	    									<button type="button" class="joomdev-networks-popup-save">Update</button>
	    									<button type="button" class="joomdev-networks-popup-close">Cancel</button>
	    								</div>
	    							</div>
    							</div>
    						</td>
    					</tr>
    					<tr>
    						<th>Buttons Locations</th>
    						<td>
    							<input type="hidden" name="joomdev_wss_options[button_locations]" value="">
    							<div>
    								<label>
    									<input type="checkbox" name="joomdev_wss_options[button_locations][]" value="top_of_content"> Top of content
    								</label>
    							</div>
    							<div>
    								<label>
    									<input type="checkbox" name="joomdev_wss_options[button_locations][]" value="bottom_of_content"> Bottom of content
    								</label>
    							</div>
    							<div>
    								<label>
    									<input type="checkbox" name="joomdev_wss_options[button_locations][]" value="sidebar"> Sidebar
    								</label>
    							</div>
    							<div>
    								<label>
    									<input type="checkbox" name="joomdev_wss_options[button_locations][]" value="media"> Media
    								</label>
    							</div>
    						</td>
    					</tr>
    					<tr>
    						<th>Display Buttons In</th>
    						<td>
    							<input type="hidden" name="joomdev_wss_options[display_buttons_in]" value="">
    							<?php 
    								$post_types = get_post_types(array(), 'objects');
    								if(!empty($post_types)){
    									foreach ($post_types as $key => $value) {
    										if(in_array($key, array('attachment', 'revision', 'nav_menu_item'))){
    											continue;
    										}
    										?>
				    							<div>
				    								<label>
				    									<input type="checkbox" name="joomdev_wss_options[display_buttons_in][]" value="<?php echo $value->name; ?>"> <?php echo $value->label; ?>
				    								</label>
				    							</div>
    										<?php 
    									}
    								}
    							?>
    						</td>
    					</tr>
    					<tr>
    						<th>URL Shorting</th>
    						<td>
    							<select name="joomdev_wss_options[url_shorting]">
    								<option value="bit.ly">Bit.ly</option>
    								<option value="goo.gl">Goo.gl</option>
    							</select>
    						</td>
    					</tr>
    					<tr>
    						<th>Twitter Handler</th>
    						<td>
    							<input type="text" name="joomdev_wss_options[twitter_handler]" class="regular-text">
    						</td>
    					</tr>
    					<tr>
    						<th>Default Tags</th>
    						<td>
    							<input type="text" name="joomdev_wss_options[default_tags]" class="regular-text">
    						</td>
    					</tr>
    				</tbody>
    			</table>
    			<?php submit_button(); ?>
    		</form>
		</div>
	<?php 
}


// file ends here...