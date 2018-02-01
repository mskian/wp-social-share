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

// define('JOOMDEV_WSS_PLUGIN_FILE', 'joomdev-wp-social-share/joomdev-wp-social-share.php');
define('JOOMDEV_WSS_PLUGIN_FILE', __FILE__);

include 'joomdev-wss-functions.php';

// include script fies.
add_action('admin_enqueue_scripts', 'joomdev_wss_admin_enqueue_scripts', 999);
function joomdev_wss_admin_enqueue_scripts(){
	wp_enqueue_style('joomdev-wss-font-awesome', plugins_url('assets/css/font-awesome.min.css', __FILE__));
	wp_enqueue_style('joomdev-wss-admin-styles', plugins_url('assets/css/admin-styles.css', __FILE__));
	wp_enqueue_script('joomdev-wss-admin-scripts', plugins_url('assets/js/admin-scripts.js', __FILE__));
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
    $plugin_data = get_joomdev_wss_plugin_info();
	?>
        <div class="wrap">
            <h2></h2>
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
                <div class="joomdev-wss-options-box">
                    <div class="joomdev-wss-options-box-sidebar">
                        <div class="joomdev-wss-options-box-logo">
                            <a href="<?php echo $plugin_data['AuthorURI']; ?>" target="_BLANK"><h2><big><strong><?php echo $plugin_data['Author']; ?></strong></big></h2></a>
                            <a href="<?php echo $plugin_data['PluginURI']; ?>" target="_BLANK"><h3><small><?php echo $plugin_data['Name']; ?> : <i><?php echo $plugin_data['Version']; ?></i></small></h3></a>
                        </div>
                        <div class="joomdev-wss-options-box-menubar">
                            <ul>
                                <li class="active">
                                    <a href="javascript:;" data-tab-name="network">
                                        <i class="fa fa-sitemap"></i> Network
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" data-tab-name="setup">
                                        <i class="fa fa-cog"></i> Setup
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" data-tab-name="design">
                                        <i class="fa fa-paint-brush"></i> Design
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="joomdev-wss-options-box-main">
                        <div class="joomdev-wss-options-box-actions-header">
                            <!-- <button type="submit" class="button button-primary button-submit">Save Changes</button> -->
                            <a class="joomdev-wss-more-themes-plugins-link" href="<?php echo $plugin_data['AuthorURI']; ?>" target="_BLANK"><i class="fa fa-shopping-cart"></i> More Themes &amp; Plugins</a>
                        </div>
                        <div class="joomdev-wss-options-box-options">
                            <div data-tab="network" class="joomdev-wss-options-box-options-single">
                                <h2 class="joomdev-wss-options-box-options-single-title">Networks</h2>
                                <div class="joomdev-wss-options-box-options-single-option">
                                    <div class="joomdev-wss-options-box-sided first-cell">
                                        <h3>Select Networks</h3>
                                        <small>Add and re-arrange any combination of social network. Selected networks apply to all selected locations in "Button Locations" Settings.</small>
                                    </div>
                                    <div class="joomdev-wss-options-box-sided second-cell">
                                        <button type="button" class="button button-primary joomdev-networks-popup-open">Update Social Networks</button>
                                        <div class="joomdev-networks-selected">
                                            <div class="joomdev-networks-selected-single">
                                                <i class="fa fa-arrows-alt fa-rotate-90"></i>
                                                <a href="javascript:;" class="joomdev-networks-selected-single-button">
                                                    <i class="fa fa-facebook"></i>
                                                    <i class="fa fa-close"></i>
                                                </a>
                                                <input type="text" name="joomdev_wss_options[network][facebook][]" class="joomdev-wss-regular-text">
                                            </div>
                                        </div>
                                        <div class="joomdev-networks-popup-outlay joomdev-networks-popup-outlay-toggle">
                                            <div class="joomdev-networks-popup-outlay-bg"></div>
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
                                                                        <div class="joomdev-networks-single joomdev-networks-single-<?php echo $key; ?> joomdev-wss-<?php echo $key; ?>-holder">
                                                                            <a data-network-name="<?php echo $key; ?>" data-network-label="<?php echo $network['label']; ?>" href="javascript:;" role="button" class="joomdev-networks-single-button joomdev-networks-single-button-<?php echo $key; ?> joomdev-wss-<?php echo $key; ?>" data-network="<?php echo $key; ?>">
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
                                    </div>
                                </div>
                            </div>
                            <div data-tab="setup" class="joomdev-wss-options-box-options-single" style="display:none;">
                                setup
                            </div>
                            <div data-tab="design" class="joomdev-wss-options-box-options-single" style="display:none;">
                                design
                            </div>
                        </div>
                        <div class="joomdev-wss-options-box-actions-footer">
                            <button type="submit" class="button button-primary button-submit">Save Changes</button>
                        </div>
                    </div>
                </div>


    			<table class="form-table">
    				<tbody>
    					<tr>
    						<th>Select Networks</th>
    						<td>
    							
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
    										if(in_array($key, array('attachment', 'revision', 'nav_menu_item', 'custom_css', 'customize_changeset', 'oembed_cache'))){
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
                        <tr>
                            <th>Buttons Format</th>
                            <td>
                                <select name="joomdev_wss_options[buttons_format]">
                                    <option value="text_and_icons">Text and Icons</option>
                                    <option value="icon_only">Text Only</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Button Shape</th>
                            <td>
                                
                            </td>
                        </tr>
                        <tr>
                            <th>Button Animation</th>
                            <td>
                                
                            </td>
                        </tr>
                        <tr>
                            <th>Show Share Count</th>
                            <td>
                                <input type="hidden" name="joomdev_wss_options[show_share_count]" value="no">
                                <input type="checkbox" name="joomdev_wss_options[show_share_count]" value="yes">
    						</td>
    					</tr>
                        <tr>
                            <th>Share Incentive</th>
                            <td>
                                <input type="text" name="joomdev_wss_options[share_incentive]" class="regular-text">
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