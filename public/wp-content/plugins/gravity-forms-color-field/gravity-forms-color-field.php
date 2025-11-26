<?php
/*
*		Plugin Name: Gravity Forms Color Field
*		Plugin URI: https://www.northernbeacheswebsites.com.au
*		Description: Gravity Forms Color Field
*		Version: 1.4
*		Author: Martin Gibson
*		Text Domain: gravity-forms-color-field   
*		Support: https://www.northernbeacheswebsites.com.au/contact
*		Licence: GPL2
*/



define( 'GRAVITY_FORMS_COLOR_FIELD_VERSION', '1.4' );

add_action( 'gform_loaded', array( 'Gravity_Forms_Color_Field_AddOn_Bootstrap', 'load' ), 5 );

class Gravity_Forms_Color_Field_AddOn_Bootstrap {

    public static function load() {

        if ( ! method_exists( 'GFForms', 'include_feed_addon_framework' ) ) {
            return;
        }

        require_once( 'class-gravity-forms-color-field-addon.php' );

        GFAddOn::register( 'GravityFormsColorFieldAddOn' );
    }

}

function gravity_forms_color_field_addon() {
    return GravityFormsColorFieldAddOn::get_instance();
}






//do update check

//initialise the update check
require 'inc/plugin-update-checker/plugin-update-checker.php';

global $plugin_update_checker_gravity_forms_color_field;

$plugin_update_checker_gravity_forms_color_field
 = Puc_v4_Factory::buildUpdateChecker(
	'https://northernbeacheswebsites.com.au/?update_action=get_metadata&update_slug=gravity-forms-color-field ', //Metadata URL.
	__FILE__, //Full path to the main plugin file.
	'gravity-forms-color-field ' //Plugin slug. Usually it's the same as the name of the directory.
);




//add queries to the update call
$plugin_update_checker_gravity_forms_color_field
->addQueryArgFilter('filter_update_checks_color_gravity_forms');
function filter_update_checks_color_gravity_forms($queryArgs) {
    
    $pluginSettings = get_option('gravityformsaddon_gravity-forms-color-field_settings');
    
    if(isset($pluginSettings['purchase-email-address']) && isset($pluginSettings['order-id'])){
    
        $purchaseEmailAddress = $pluginSettings['purchase-email-address'];
        $orderId = $pluginSettings['order-id'];
        $siteUrl = get_site_url();
        $siteUrl = parse_url($siteUrl);
        $siteUrl = $siteUrl['host'];

        if (!empty($purchaseEmailAddress) &&  !empty($orderId)) {
            $queryArgs['purchaseEmailAddress'] = $purchaseEmailAddress;
            $queryArgs['orderId'] = $orderId;
            $queryArgs['siteUrl'] = $siteUrl;
            $queryArgs['productId'] = '11296';
        }
    }
    return $queryArgs;
     
}



$plugin_update_checker_gravity_forms_color_field
->addFilter(
    'request_info_result', 'filter_puc_request_info_result_slug_checks_color_gravity_forms', 10, 2
);

// define the puc_request_info_result-<slug> callback 
function filter_puc_request_info_result_slug_checks_color_gravity_forms( $plugininfo, $result ) { 

    //get the message from the server and set as transient
    set_transient('gravity-forms-color-field-update',$plugininfo->{'message'},YEAR_IN_SECONDS * 1);

    return $plugininfo; 
}; 







$path = plugin_basename( __FILE__ );

add_action("after_plugin_row_{$path}", function( $plugin_file, $plugin_data, $status ) {
    
    //get plugin settings
    $pluginSettings = get_option('gravityformsaddon_gravity-forms-color-field_settings');
    
    if (!empty($pluginSettings['purchase-email-address']) &&  !empty($pluginSettings['order-id'])) {
        
        $order_id = $pluginSettings['order-id'];

        //get transient
        $message = get_transient('gravity-forms-color-field-update');

        if($message !== 'Yes' && $message !== false){

            $purchaseLink = 'https://northernbeacheswebsites.com.au/gravity-forms-color-field/';

            if($message == 'Incorrect Details'){
                $displayMessage = 'The Order ID and Purchase ID you entered is not correct. Please double check the details you entered to receive product updates.';    
            } elseif ($message == 'Licence Expired'){
                $displayMessage = 'Your licence has expired. Please <a href="'.$purchaseLink.'" target="_blank">purchase a new licence</a> to receive further updates for this plugin.';    
            } elseif ($message == 'Website Mismatch') {
                $displayMessage = 'This plugin has already been registered on another website using your details. Under the licence terms this plugin can only be used on one website. Please <a href="'.$purchaseLink.'" target="_blank">click here</a> to purchase an additional licence. To change the website assigned to your licence, please click <a href="https://northernbeacheswebsites.com.au/my-account/view-order/'.$order_id.'/" target="_blank">here</a>.';    
            } else {
                $displayMessage = '';    
            }
            
            echo '<tr class="plugin-update-tr active"><td colspan="3" class="plugin-update colspanchange"><div class="update-message notice inline notice-error notice-alt"><p class="installer-q-icon">'.$displayMessage.'</p></div></td></tr>';

        }
        
    } else {
        
        echo '<tr class="plugin-update-tr active"><td colspan="3" class="plugin-update colspanchange"><div class="update-message notice inline notice-error notice-alt"><p class="installer-q-icon">Please enter your Order ID and Purchase ID in the plugin settings to receive automatics updates.</p></div></td></tr>';
        
    }
    

}, 10, 3 );


/**
* 
*
*
* Force check for updates
*/
function color_field_gravityforms_connector_force_check_for_updates(){

    global $plugin_update_checker_gravity_forms_color_field;

    $plugin_update_checker_gravity_forms_color_field->checkForUpdates();

}


// Load admin style and scripts
function color_field_gravityforms_connector_scripts($hook){

    wp_enqueue_script( 'custom-admin-script-color-field', plugins_url( '/js/adminscript.js', __FILE__ ), array('jquery'));
    
}
add_action( 'admin_enqueue_scripts', 'color_field_gravityforms_connector_scripts' );

/**
* 
*
*
* Delete Plugin Updates transient/option
*/
function color_field_delete_plugin_updates_transient() { 

	if (!current_user_can('manage_options')) {
        wp_die();    
    }

    delete_option('_site_transient_update_plugins');

    echo 'SUCCESS';
    wp_die();   

}
add_action( 'wp_ajax_color_field_delete_plugin_updates_transient', 'color_field_delete_plugin_updates_transient' );





?>