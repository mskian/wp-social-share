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

    wp_enqueue_script('jquery-ui-sortable');
    wp_enqueue_script('joomdev-wss-admin-scripts', plugins_url('assets/js/admin-scripts.js', __FILE__));
}

add_action('wp_enqueue_scripts', 'joomdev_wss_enqueue_scripts', 99);
function joomdev_wss_enqueue_scripts(){
	wp_enqueue_style('joomdev-wss-font-awesome', plugins_url('assets/css/font-awesome.min.css', __FILE__));
    wp_enqueue_style('joomdev-wss-styles', plugins_url('assets/css/styles.css', __FILE__));

	wp_enqueue_script('joomdev-wss-scripts', plugins_url('assets/js/scripts.js', __FILE__));
}

add_action( 'admin_menu', 'joomdev_wss_register_menu_page' );
function joomdev_wss_register_menu_page() {
    add_menu_page(
        'WP Social Share Options',
        'WP Social Share',
        'manage_options',
        'joomdev-wss-social-share-options',
        'joomdev_wss_register_menu_page_callback',
        plugins_url( 'assets/img/share-1.png', __FILE__ )
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
                    <a href="<?php echo $plugin_data['AuthorURI']; ?>" target="_BLANK">
                        <h2><big><strong><?php echo $plugin_data['Author']; ?></strong></big></h2>
                    </a>
                    <img src="<?php echo plugins_url( 'assets/img/share-1.png', __FILE__ ); ?>">
                    <a href="<?php echo $plugin_data['PluginURI']; ?>" target="_BLANK">
                        <h3><small><?php echo $plugin_data['Name']; ?> : <i><?php echo $plugin_data['Version']; ?></i></small></h3>
                    </a>
                </div>
                <div class="joomdev-wss-options-box-menubar">
                    <?php 
                                $tab = isset($_COOKIE['joomdev_wss_admin_tab']) && !empty($_COOKIE['joomdev_wss_admin_tab']) ? $_COOKIE['joomdev_wss_admin_tab'] : 'network';
                            ?>
                    <ul>
                        <li class="<?php echo $tab == 'network' ? 'active' : ''; ?>">
                            <a href="javascript:;" data-tab-name="network">
                                        <i class="fa fa-sitemap"></i> Network
                                    </a>
                        </li>
                        <li class="<?php echo $tab == 'setup' ? 'active' : ''; ?>">
                            <a href="javascript:;" data-tab-name="setup">
                                        <i class="fa fa-cog"></i> Setup
                                    </a>
                        </li>
                        <li class="<?php echo $tab == 'design' ? 'active' : ''; ?>">
                            <a href="javascript:;" data-tab-name="design">
                                        <i class="fa fa-paint-brush"></i> Design
                                    </a>
                        </li>
                        <li class="<?php echo $tab == 'advanced' ? 'active' : ''; ?>">
                            <a href="javascript:;" data-tab-name="advanced">
                                        <i class="fa fa-cog"></i> Advance Settings
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
                    <div data-tab="network" class="joomdev-wss-options-box-options-single" style="display:<?php echo $tab == 'network' ? 'block' : 'none'; ?>;">
                        <h2 class="joomdev-wss-options-box-options-single-title">Networks</h2>
                        <div class="joomdev-wss-options-box-options-single-option">
                            <div class="joomdev-wss-options-box-sided first-cell">
                                <h3>Select Networks</h3>
                                <small>Add and re-arrange any combination of social network. Selected networks apply to all selected locations in "Button Locations" Settings.</small>
                            </div>
                            <div class="joomdev-wss-options-box-sided second-cell">
                                <button type="button" class="button button-primary joomdev-networks-popup-open">Update Social Networks</button>
                                <div class="joomdev-networks-selected">

                                    <!-- networks goes here -->
                                    <!-- <div class="joomdev-networks-selected-single joomdev-wss-networks-[network]">
                                                    <i class="fa fa-arrows-alt fa-rotate-90"></i>
                                                    <a href="javascript:;" class="joomdev-networks-selected-single-button joomdev-networks-[network]" data-network="[network]">
                                                        <i class="fa fa-[class]"></i>
                                                        <i class="fa fa-close"></i>
                                                    </a>
                                                    <input type="text" name="joomdev_wss_options[network][[network]][]" class="joomdev-wss-regular-text" value="[label]">
                                                </div> -->

                                    <?php 
                                                    if(isset($joomdev_wss_options['networks']) && !empty($joomdev_wss_options['networks'])){
                                                        $networks = get_joomdev_wss_networks();
                                                        foreach ($joomdev_wss_options['networks'] as $key => $value) {
                                                            $network = $networks[$key];
                                                            $label = $value;
                                                            ?>
                                    <div class="joomdev-networks-selected-single joomdev-wss-networks-<?php echo $key; ?>">
                                        <!--<i class="fa fa-arrows-alt fa-rotate-90"></i>-->
                                        <i class="fa fa-ellipsis-v"></i>
                                        <a href="javascript:;" class="joomdev-networks-selected-single-button joomdev-networks-<?php echo $key; ?>" data-network="<?php echo $key; ?>">
                                                                        <i class="fa fa-<?php echo $network['font_awesome_class']; ?>"></i>
                                                                        <i class="fa fa-close"></i>
                                                                    </a>
                                        <input type="text" name="joomdev_wss_options[networks][<?php echo $key; ?>]" class="joomdev-wss-regular-text" value="<?php echo $label; ?>">
                                    </div>
                                    <?php 
                                                        }
                                                    }
                                                ?>

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
                                                            $networks = isset($joomdev_wss_options['networks']) && !empty($joomdev_wss_options['networks']) ? $joomdev_wss_options['networks'] : array();
                                                            if(!empty($joomdev_wss_networks)){
                                                                foreach ($joomdev_wss_networks as $key => $network) {
                                                                    ?>
                                                <div class="joomdev-networks-single joomdev-networks-single-<?php echo $key; ?> joomdev-wss-<?php echo $key; ?>-holder <?php echo isset($networks[$key]) ? 'joomdev-networks-single-selected' : ''; ?>">
                                                    <a data-network-name="<?php echo $key; ?>" data-network-label="<?php echo $network['label']; ?>" data-network-class="<?php echo $network['font_awesome_class']; ?>" href="javascript:;" role="button" class="joomdev-networks-single-button joomdev-networks-single-button-<?php echo $key; ?> joomdev-wss-<?php echo $key; ?>" data-network="<?php echo $key; ?>">
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
                    <div data-tab="setup" class="joomdev-wss-options-box-options-single" style="display:<?php echo $tab == 'setup' ? 'block' : 'none'; ?>;">
                        <h2 class="joomdev-wss-options-box-options-single-title">Buttons Setup</h2>
                        <div class="joomdev-wss-options-box-options-single-option">
                            <div class="joomdev-wss-options-box-sided first-cell">
                                <h3>Buttons Locations</h3>
                                <small>Choose where to insert share buttons in content.</small>
                            </div>
                            <div class="joomdev-wss-options-box-sided second-cell">
                                <input type="hidden" name="joomdev_wss_options[button_locations]" value="">
                                <section class="joomdev-wss-multiselect-animation">
                                    <div>
                                        <input type="checkbox" name="joomdev_wss_options[button_locations][]" value="top_of_content" <?php echo is_array($joomdev_wss_options[ 'button_locations']) && in_array( 'top_of_content', $joomdev_wss_options[ 'button_locations']) ? 'checked' : ''; ?>>
                                        <label>
                                                    Top of content
                                                </label>
                                    </div>
                                    <div>
                                        <input type="checkbox" name="joomdev_wss_options[button_locations][]" value="bottom_of_content" <?php echo is_array($joomdev_wss_options[ 'button_locations']) && in_array( 'bottom_of_content', $joomdev_wss_options[ 'button_locations']) ? 'checked' : ''; ?>>
                                        <label>
                                                    Bottom of content
                                                </label>
                                    </div>
                                    <div>
                                        <input type="checkbox" name="joomdev_wss_options[button_locations][]" value="sidebar" <?php echo is_array($joomdev_wss_options[ 'button_locations']) && in_array( 'sidebar', $joomdev_wss_options[ 'button_locations']) ? 'checked' : ''; ?>>
                                        <label>
                                                    Sidebar
                                                </label>
                                    </div>
                                    <div>
                                        <input type="checkbox" name="joomdev_wss_options[button_locations][]" value="media" <?php echo is_array($joomdev_wss_options[ 'button_locations']) && in_array( 'media', $joomdev_wss_options[ 'button_locations']) ? 'checked' : ''; ?>>
                                        <label>
                                                    Media
                                                </label>
                                    </div>
                                </section>
                            </div>
                        </div>
                        <div class="joomdev-wss-options-box-options-single-option">
                            <div class="joomdev-wss-options-box-sided first-cell">
                                <h3>Display Buttons In</h3>
                                <small>Select the post types where buttons should be displayed.</small>
                            </div>
                            <div class="joomdev-wss-options-box-sided second-cell">
                                <input type="hidden" name="joomdev_wss_options[display_buttons_in]" value="">
                                <?php 
                                            $post_types = get_post_types(array(), 'objects');
                                            if(!empty($post_types)){
                                                echo '<section class="joomdev-wss-multiselect-animation">';
                                                foreach ($post_types as $key => $value) {
                                                    if(in_array($key, array('attachment', 'revision', 'nav_menu_item', 'custom_css', 'customize_changeset', 'oembed_cache'))){
                                                        continue;
                                                    }
                                                    ?>
                                <div>
                                    <input type="checkbox" name="joomdev_wss_options[display_buttons_in][]" value="<?php echo $value->name; ?>" <?php echo is_array($joomdev_wss_options[ 'display_buttons_in']) && in_array($value->name, $joomdev_wss_options['display_buttons_in']) ? 'checked' : ''; ?>>
                                    <label>
                                                                <?php echo $value->label; ?>
                                                            </label>
                                </div>
                                <?php 
                                                }
                                                echo '</section>';
                                            }
                                        ?>
                            </div>
                        </div>
                        <h2 class="joomdev-wss-options-box-options-single-title">Short URL Setup</h2>
                        <div class="joomdev-wss-options-box-options-single-option">
                            <div class="joomdev-wss-options-box-sided first-cell">
                                <h3>URL Shortener/Shortenening</h3>
                                <small>Select the service you would like to use for shortening URLs?</small>
                            </div>
                            <div class="joomdev-wss-options-box-sided second-cell">
                                <section class="joomdev-wss-singleselect-animation">
                                    <div class="joomdev-wss-singleselect-animation-container">
                                        <div>
                                            <input class="joomdev-wss-url_shorting" type="radio" name="joomdev_wss_options[url_shorting]" value="bit.ly" <?php echo $joomdev_wss_options[ 'url_shorting']=='bit.ly' ? 'checked' : ''; ?>>
                                            <label>Bit.ly</label>
                                            <div class="bullet">
                                                <div class="line zero"></div>
                                                <div class="line one"></div>
                                                <div class="line two"></div>
                                                <div class="line three"></div>
                                                <div class="line four"></div>
                                                <div class="line five"></div>
                                                <div class="line six"></div>
                                                <div class="line seven"></div>
                                            </div>
                                        </div>
                                        <span class="joomdev-wss-url_shorting-box url_shorting_bit_ly" style="display:<?php echo $joomdev_wss_options['url_shorting'] == 'bit.ly' ? 'block' : 'none'; ?>;">
                                            <div class="joomdev-form-field">
                                                Create Bitly Access token and Username here <a href="https://app.bitly.com/Bhb3608LOoo/bitlinks/2zKnzXS?actions=accountMain&actions=settings&actions=advancedSettings&actions=apiSupport">Click</a>
                                            </div>
                                            <div class="joomdev-form-field">
                                                <label>
                                                    <span>Username</span>
                                                    <input type="text" placeholder="Username" name="joomdev_wss_options[bit_ly_username]" value="<?php echo $joomdev_wss_options['bit_ly_username']; ?>">
                                                </label>
                                            </div>
                                            <div class="joomdev-form-field">
                                                <label>
                                                    <span>Access Token</span>
                                                    <input type="text" placeholder="Access Token" name="joomdev_wss_options[bit_ly_access_token]" value="<?php echo $joomdev_wss_options['bit_ly_access_token']; ?>">
                                                </label>
                                            </div>
                                        </span>
                            </div>
                            <div class="joomdev-wss-singleselect-animation-container">
                                <div>
                                    <input class="joomdev-wss-url_shorting" type="radio" name="joomdev_wss_options[url_shorting]" value="goo.gl" <?php echo $joomdev_wss_options[ 'url_shorting']=='goo.gl' ? 'checked' : ''; ?>>
                                    <label>Goo.gl</label>
                                    <div class="bullet">
                                        <div class="line zero"></div>
                                        <div class="line one"></div>
                                        <div class="line two"></div>
                                        <div class="line three"></div>
                                        <div class="line four"></div>
                                        <div class="line five"></div>
                                        <div class="line six"></div>
                                        <div class="line seven"></div>
                                    </div>
                                </div>
                                <span class="joomdev-wss-url_shorting-box url_shorting_goo_gl" style="display:<?php echo $joomdev_wss_options['url_shorting'] == 'goo.gl' ? 'block' : 'none'; ?>;">
                                                <div class="joomdev-form-field">
                                                    Create Google API Key here <a href="https://console.developers.google.com/flows/enableapi?apiid=maps_backend,geocoding_backend,directions_backend,distance_matrix_backend,elevation_backend,places_backend&reusekey=true">Click</a>
                                                </div>
                                                <div class="joomdev-form-field">
                                                    <label>
                                                        <span>API Key</span>
                                                    <input type="text" placeholder="API Key" name="joomdev_wss_options[goo_gl_api_key]" value="<?php echo $joomdev_wss_options['goo_gl_api_key']; ?>">
                                                    </label>
                                                </div>
                            </span>
                        </div>
                        </section>
                    </div>

                </div>
                <h2 class="joomdev-wss-options-box-options-single-title">Twitter Handler &amp; Tags</h2>
                <div class="joomdev-wss-options-box-options-single-option">
                    <div class="joomdev-wss-options-box-sided first-cell">
                        <h3>Twitter Handler</h3>
                        <small>Insert twitter handler without using @. i.e: handler</small>
                    </div>
                    <div class="joomdev-wss-options-box-sided second-cell">
                        <div class="joomdev-form-field">
                            <label>
                                <!-- <span>Twitter Habdler</span> -->
                                <input type="text" placeholder="Twitter Handler" name="joomdev_wss_options[twitter_handler]" value="<?php echo $joomdev_wss_options['twitter_handler']; ?>">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="joomdev-wss-options-box-options-single-option">
                    <div class="joomdev-wss-options-box-sided first-cell">
                        <h3>Default Tags</h3>
                        <small>Insert hashtags separated by comma (,). Do not add hash(#). i.e: Tag 1, Tag 2....</small>
                    </div>
                    <div class="joomdev-wss-options-box-sided second-cell">
                        <div class="joomdev-form-field">
                            <label>
                                <!-- <span>Default Tags</span> -->
                                <input type="text" placeholder="Default Tags" name="joomdev_wss_options[default_tags]" value="<?php echo $joomdev_wss_options['default_tags']; ?>">
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div data-tab="design" class="joomdev-wss-options-box-options-single" style="display:<?php echo $tab == 'design' ? 'block' : 'none'; ?>;">
                <h2 class="joomdev-wss-options-box-options-single-title">Manage Designs</h2>
                <div class="joomdev-wss-options-box-options-single-option">
                    <div class="joomdev-wss-options-box-sided first-cell">
                        <h3>Buttons Format</h3>
                        <small>Choose button format</small>
                    </div>
                    <div class="joomdev-wss-options-box-sided second-cell">
                        <section class="joomdev-wss-singleselect-animation">
                            <div class="joomdev-wss-singleselect-animation-container">
                                <div>
                                    <input class="joomdev-wss-buttons_format" type="radio" name="joomdev_wss_options[buttons_format]" value="icon_only" <?php echo isset($joomdev_wss_options[ 'buttons_format']) && $joomdev_wss_options[ 'buttons_format']=='icon_only' ? 'checked' : ''; ?>>
                                    <label>Icons Only</label>
                                    <div class="bullet">
                                        <div class="line zero"></div>
                                        <div class="line one"></div>
                                        <div class="line two"></div>
                                        <div class="line three"></div>
                                        <div class="line four"></div>
                                        <div class="line five"></div>
                                        <div class="line six"></div>
                                        <div class="line seven"></div>
                                    </div>
                                </div>
                                <div>
                                    <input class="joomdev-wss-buttons_format" type="radio" name="joomdev_wss_options[buttons_format]" value="text_and_icons" <?php echo isset($joomdev_wss_options[ 'buttons_format']) && $joomdev_wss_options[ 'buttons_format']=='text_and_icons' ? 'checked' : ''; ?>>
                                    <label>Text &amp; Icons</label>
                                    <div class="bullet">
                                        <div class="line zero"></div>
                                        <div class="line one"></div>
                                        <div class="line two"></div>
                                        <div class="line three"></div>
                                        <div class="line four"></div>
                                        <div class="line five"></div>
                                        <div class="line six"></div>
                                        <div class="line seven"></div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                <div class="joomdev-wss-options-box-options-single-option">
                    <div class="joomdev-wss-options-box-sided first-cell">
                        <h3>Button Shape</h3>
                        <small>Choose button shape</small>
                    </div>
                    <div class="joomdev-wss-options-box-sided second-cell">
                        <input type="hidden" name="joomdev_wss_options[button_shape]" value="shape-1">
                        <section class="joomdev-wss-multiselect-animation joomdev-button-shape-container">
                            <div>
                                <input type="radio" name="joomdev_wss_options[button_shape]" value="shape-1" <?php echo isset($joomdev_wss_options[ 'button_shape']) && $joomdev_wss_options[ 'button_shape']=='shape-1' ? 'checked' : ''; ?>>
                                <label>
                                    <a href="javascript:;" class="joomdev-wss-shape-1"><i class="fa fa-plus"></i></a>
                                </label>
                            </div>
                            <div>
                                <input type="radio" name="joomdev_wss_options[button_shape]" value="shape-2" <?php echo isset($joomdev_wss_options[ 'button_shape']) && $joomdev_wss_options[ 'button_shape']=='shape-2' ? 'checked' : ''; ?>>
                                <label>
                                    <a href="javascript:;" class="joomdev-wss-shape-2"><i class="fa fa-plus"></i></a>
                                </label>
                            </div>
                            <div>
                                <input type="radio" name="joomdev_wss_options[button_shape]" value="shape-3" <?php echo isset($joomdev_wss_options[ 'button_shape']) && $joomdev_wss_options[ 'button_shape']=='shape-3' ? 'checked' : ''; ?>>
                                <label>
                                    <a href="javascript:;" class="joomdev-wss-shape-3"><i class="fa fa-plus"></i></a>
                                </label>
                            </div>
                        </section>
                    </div>
                </div>
                <div class="joomdev-wss-options-box-options-single-option">
                    <div class="joomdev-wss-options-box-sided first-cell">
                        <h3>Button Animation</h3>
                        <small>Choose button animation</small>
                    </div>
                    <div class="joomdev-wss-options-box-sided second-cell">
                        <input type="hidden" name="joomdev_wss_options[buttons_animation]" value="animation-1">
                        <section class="joomdev-wss-multiselect-animation-horizontal">
                            <div class="joomdev-wss-animation-1">
                                <input type="radio" name="joomdev_wss_options[buttons_animation]" value="animation-1" <?php echo isset($joomdev_wss_options[ 'buttons_animation']) && $joomdev_wss_options[ 'buttons_animation']=='animation-1' ? 'checked' : ''; ?>>
                                <label>
                                    <div>
                                        <a href="javascript:;" class="facebook"><i class="fa fa-facebook"></i> Facebook</a>
                                        <a href="javascript:;" class="twitter"><i class="fa fa-twitter"></i> Twitter</a>
                                        <a href="javascript:;" class="linkedin"><i class="fa fa-linkedin"></i> Linkedin</a>
                                    </div>
                                </label>
                            </div>
                            <div class="joomdev-wss-animation-2">
                                <input type="radio" name="joomdev_wss_options[buttons_animation]" value="animation-2" <?php echo isset($joomdev_wss_options[ 'buttons_animation']) && $joomdev_wss_options[ 'buttons_animation']=='animation-2' ? 'checked' : ''; ?>>
                                <label>
                                    <div>
                                        <a href="javascript:;" class="facebook"><i class="fa fa-facebook"></i> Facebook <i class="fa fa-facebook"></i></a>
                                        <a href="javascript:;" class="twitter"><i class="fa fa-twitter"></i> Twitter <i class="fa fa-twitter"></i></a>
                                        <a href="javascript:;" class="linkedin"><i class="fa fa-linkedin"></i> Linkedin <i class="fa fa-linkedin"></i></a>
                                    </div>
                                </label>
                            </div>
                            <div class="joomdev-wss-animation-3">
                                <input type="radio" name="joomdev_wss_options[buttons_animation]" value="animation-3" <?php echo isset($joomdev_wss_options[ 'buttons_animation']) && $joomdev_wss_options[ 'buttons_animation']=='animation-3' ? 'checked' : ''; ?>>
                                <label>
                                    <div>
                                        <a href="javascript:;" class="facebook"><i class="fa fa-facebook"></i> <span>Facebook</span></a>
                                        <a href="javascript:;" class="twitter"><i class="fa fa-twitter"></i> <span>Twitter</span></a>
                                        <a href="javascript:;" class="linkedin"><i class="fa fa-linkedin"></i> <span>Linkedin</span></a>
                                    </div>
                                </label>
                            </div>
                            <div class="joomdev-wss-animation-4">
                                <input type="radio" name="joomdev_wss_options[buttons_animation]" value="animation-4" <?php echo isset($joomdev_wss_options[ 'buttons_animation']) && $joomdev_wss_options[ 'buttons_animation']=='animation-4' ? 'checked' : ''; ?>>
                                <label>
                                    <div>
                                        <a href="javascript:;" class="facebook"><i class="fa fa-facebook"></i> <span>Facebook</span></a>
                                        <a href="javascript:;" class="twitter"><i class="fa fa-twitter"></i> <span>Twitter</span></a>
                                        <a href="javascript:;" class="linkedin"><i class="fa fa-linkedin"></i> <span>Linkedin</span></a>
                                    </div>
                                </label>
                            </div>
                        </section>
                    </div>
                </div>
                <h2 class="joomdev-wss-options-box-options-single-title">Share Count &amp; Incentive</h2>
                <div class="joomdev-wss-options-box-options-single-option">
                    <div class="joomdev-wss-options-box-sided first-cell">
                        <h3>Show Share Count</h3>
                        <small>Check this box in order to display the share count.</small>
                    </div>
                    <div class="joomdev-wss-options-box-sided second-cell">
                        <input type="hidden" name="joomdev_wss_options[show_share_count]" value="no">
                        <div class="joomdev-form-field">
                            <label>
                                <!-- <span>Show Share Count</span> -->
                                <input type="checkbox" name="joomdev_wss_options[show_share_count]" value="yes" <?php echo isset($joomdev_wss_options['show_share_count']) && $joomdev_wss_options['show_share_count'] == 'yes' ? 'checked' : ''; ?>>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="joomdev-wss-options-box-options-single-option">
                    <div class="joomdev-wss-options-box-sided first-cell">
                        <h3>Default Share Count</h3>
                        <small>This value will be added to total share count.</small>
                    </div>
                    <div class="joomdev-wss-options-box-sided second-cell">
                        <div class="joomdev-form-field">
                            <label>
                                <!-- <span>Show Share Count</span> -->
                                <input type="number" min="0" name="joomdev_wss_options[default_share_count]" value="<?php echo $joomdev_wss_options['default_share_count']; ?>">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="joomdev-wss-options-box-options-single-option">
                    <div class="joomdev-wss-options-box-sided first-cell">
                        <h3>Enable Share Incentive</h3>
                        <small>Check this box in order to display the share incentive.</small>
                    </div>
                    <div class="joomdev-wss-options-box-sided second-cell">
                        <input type="hidden" name="joomdev_wss_options[enable_share_incentive]" value="no">
                        <div class="joomdev-form-field">
                            <label>
                                <!-- <span>Show Share Incentive</span> -->
                                <input type="checkbox" name="joomdev_wss_options[enable_share_incentive]" value="yes" <?php echo isset($joomdev_wss_options['enable_share_incentive']) && $joomdev_wss_options['enable_share_incentive'] == 'yes' ? 'checked' : ''; ?>>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="joomdev-wss-options-box-options-single-option">
                    <div class="joomdev-wss-options-box-sided first-cell">
                        <h3>Share Incentive</h3>
                        <small>If you use bottom share buttons, this text will be displayed before the buttons to motivate visitors clicks. E.g : Share this.</small>
                    </div>
                    <div class="joomdev-wss-options-box-sided second-cell">
                        <div class="joomdev-form-field">
                            <label>
                                <!-- <span>Share Incentive</span> -->
                                <input type="text" placeholder="Share Incentive" name="joomdev_wss_options[share_incentive]" value="<?php echo $joomdev_wss_options['share_incentive']; ?>">
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div data-tab="advanced" class="joomdev-wss-options-box-options-single" style="display:<?php echo $tab == 'advanced' ? 'block' : 'none'; ?>;">
                <h2 class="joomdev-wss-options-box-options-single-title">Hide on Mobile</h2>
                <div class="joomdev-wss-options-box-options-single-option">
                    <div class="joomdev-wss-options-box-sided first-cell">
                        <h3>Top of the Content</h3>
                        <small>If checked, icons from Top of the Content on Mobile devices will be hide automatically.</small>
                    </div>
                    <div class="joomdev-wss-options-box-sided second-cell">
                        <input type="hidden" name="joomdev_wss_options[hide_on_mobile_top_of_the_content]" value="no">
                        <div class="joomdev-form-field">
                            <label>
                                <!-- <span>Top of the Content</span> -->
                                <input type="checkbox" name="joomdev_wss_options[hide_on_mobile_top_of_the_content]" value="yes" <?php echo isset($joomdev_wss_options['hide_on_mobile_top_of_the_content']) && $joomdev_wss_options['hide_on_mobile_top_of_the_content'] == 'yes' ? 'checked' : ''; ?>>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="joomdev-wss-options-box-options-single-option">
                    <div class="joomdev-wss-options-box-sided first-cell">
                        <h3>Bottom of the Content</h3>
                        <small>If checked, icons from Bottom of the Content on Mobile devices will be hide automatically.</small>
                    </div>
                    <div class="joomdev-wss-options-box-sided second-cell">
                        <input type="hidden" name="joomdev_wss_options[hide_on_mobile_bottom_of_the_content]" value="no">
                        <div class="joomdev-form-field">
                            <label>
                                <!-- <span>Bottom of the Content</span> -->
                                <input type="checkbox" name="joomdev_wss_options[hide_on_mobile_bottom_of_the_content]" value="yes" <?php echo isset($joomdev_wss_options['hide_on_mobile_bottom_of_the_content']) && $joomdev_wss_options['hide_on_mobile_bottom_of_the_content'] == 'yes' ? 'checked' : ''; ?>>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="joomdev-wss-options-box-options-single-option">
                    <div class="joomdev-wss-options-box-sided first-cell">
                        <h3>Sidebar</h3>
                        <small>If checked, icons from Side bar on Mobile devices will be hide automatically.</small>
                    </div>
                    <div class="joomdev-wss-options-box-sided second-cell">
                        <input type="hidden" name="joomdev_wss_options[hide_on_mobile_sidebar]" value="no">
                        <div class="joomdev-form-field">
                            <label>
                                <!-- <span>Sidebar</span> -->
                                <input type="checkbox" name="joomdev_wss_options[hide_on_mobile_sidebar]" value="yes" <?php echo isset($joomdev_wss_options['hide_on_mobile_sidebar']) && $joomdev_wss_options['hide_on_mobile_sidebar'] == 'yes' ? 'checked' : ''; ?>>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="joomdev-wss-options-box-options-single-option">
                    <div class="joomdev-wss-options-box-sided first-cell">
                        <h3>Media</h3>
                        <small>If checked, icons from Media on Mobile devices will be hide automatically.</small>
                    </div>
                    <div class="joomdev-wss-options-box-sided second-cell">
                        <input type="hidden" name="joomdev_wss_options[hide_on_mobile_media]" value="no">
                        <div class="joomdev-form-field">
                            <label>
                                <!-- <span>Media</span> -->
                                <input type="checkbox" name="joomdev_wss_options[hide_on_mobile_media]" value="yes" <?php echo isset($joomdev_wss_options['hide_on_mobile_media']) && $joomdev_wss_options['hide_on_mobile_media'] == 'yes' ? 'checked' : ''; ?>>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="joomdev-wss-options-box-actions-footer">
            <button type="submit" class="button button-primary button-submit">Save Changes</button>
        </div>
</div>
</div>
</form>
</div>
<?php 
}


// file ends here...
