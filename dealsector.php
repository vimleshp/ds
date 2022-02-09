<?php

/**
 * @package Dealsector
 */
/*
Plugin Name: Dealsector
Plugin URI: 
Description: Dealsector
Version: 1.0.5
Author: Lucid Outsourcing Solutions
Author URI: https://lucidoutsourcing.com/

Copyright @ 2020 
*/
session_start();
define( 'DEALSECTOR_VERSION', '1.0.5' );
define( 'DEALSECTOR__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'DEALSECTOR__PLUGIN_BASE_URL', esc_url( plugins_url( '/',__FILE__ )) );
define( 'DEALSECTOR_LOCATION_TABLE', 'dealsector_locations' );
define( 'DEALSECTOR_CLIENT_TABLE', 'dealsector_client_detail' );
define( 'DEALSECTOR_SHORTCODE_TEMPLATE', 'dealsector_shortcode_template_detail' );
define( 'DEALSECTOR_SITE_URL', site_url() );
$slug=plugin_basename(__FILE__);
$root = dirname(dirname(dirname(dirname(__FILE__))));
if (file_exists($root.'/wp-load.php')) {
    require_once($root.'/wp-load.php');
} 
require_once( ABSPATH . 'wp-admin/includes/post.php' );
require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'http://github.com/vimleshp/ds/',
    __FILE__,
    $slug
);
$myUpdateChecker->setBranch('main');


global $wpdb;
if( $wpdb->get_var( "show tables like '".DEALSECTOR_CLIENT_TABLE."'" ) == DEALSECTOR_CLIENT_TABLE ) 
{
    $authKey = $wpdb->get_results( "SELECT * FROM ".DEALSECTOR_CLIENT_TABLE );
    if( empty($authKey) ){
		if(!defined('CLIENT_KEY')){
          define ( 'CLIENT_KEY', null);
        }
        if(!defined('RECORD_TO_SHOW')){
          define ( 'RECORD_TO_SHOW', 5);
        }
        if(!defined('CURRENCY')){
          define ( 'CURRENCY', '$');
        }
		if(!defined('FINANCE_LINK')){
          define ( 'FINANCE_LINK', '');
        }
	}
	else{
		if(!defined('DEALSECTOR_API_URL')){
	  		define( 'DEALSECTOR_API_URL', $authKey[0]->api_link.'/dswpapi/home/' );
		}  
		if(!defined('CLIENT_KEY')){
			define ( 'CLIENT_KEY', $authKey[0]->key);
		}
		if(!defined('RECORD_TO_SHOW')){
			define ( 'RECORD_TO_SHOW', $authKey[0]->records_to_show);
		}
		if(!defined('CURRENCY')){
			define ( 'CURRENCY', $authKey[0]->currency);
		}
		if(!defined('FINANCE_LINK')){
			define ( 'FINANCE_LINK', $authKey[0]->finance_link);
		}
	}
}
       
// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

register_activation_hook( __FILE__, array( "Dealsector", "dealsector_activation") );
register_deactivation_hook( __FILE__, array( "Dealsector", "dealsector_deactivation") );

require_once( DEALSECTOR__PLUGIN_DIR . 'class.dealsector.php' );
require_once( DEALSECTOR__PLUGIN_DIR . 'class.dealsector.api.php' );
require_once( DEALSECTOR__PLUGIN_DIR . 'class.dealsector.shortcode.php' );


add_action( 'init', array( 'dealsector', 'init' ) );

add_action("wpcf7_before_send_mail", "wpcf7_do_to_email");

function wpcf7_do_to_email($WPCF7_ContactForm){
    $wpcf7      = WPCF7_ContactForm::get_current();
    $submission = WPCF7_Submission::get_instance();
    if ($submission) {
        // get submission data
        $data = $submission->get_posted_data();
        // nothing's here... do nothing...
        if (empty($data))
            return;

        $locationid = 0;
        if(isset($data['select-location']) && is_array($data['select-location']) && isset($data['select-location'][0])){
            $locationid = (int) $data['select-location'][0];
        }else if(isset($data['select-location']) && is_string($data['select-location'])){
            $locationid = (int) $data['select-location'];
        }
        $sql = "SELECT email, store_id FROM ".DEALSECTOR_LOCATION_TABLE;
        if($locationid > 0){
            $sql .= " WHERE store_id = ". $locationid;
        }
        $sql .= " LIMIT 0,1";
        global $wpdb;

        $locationData = $wpdb->get_results( $sql );      
         
        if(count($locationData) > 0){
            $locationToEmail = $locationData[0]->email;
            $locationid = (int) $locationData[0]->store_id;
            $mail = $wpcf7->prop('mail');
            $mail["recipient"] = str_replace(';', ',', $locationToEmail);
            $wpcf7->set_properties(array(
                "mail" => $mail
            ));
        }
        
        
        $body =  array();
        $body['formdata'] = json_encode($_REQUEST);
        $body['locationid'] = $locationid;
        $body['ipaddress'] = $_SERVER['REMOTE_ADDR'];
        $body['refererurl'] = $_SERVER['HTTP_REFERER'];
        $body['useragent'] = $_SERVER['HTTP_USER_AGENT'];
        
        $body['firstname'] =  '';
        $body['lastname'] =  '';
        $body['email'] =  '';
        $body['phone'] =  '';
        if(isset($_REQUEST['your-first-name'])){
            $body['firstname'] = $_REQUEST['your-first-name'];
        }
        if(isset($_REQUEST['your-last-name'])){
            $body['lastname'] = $_REQUEST['your-last-name'];
        }
        if(isset($_REQUEST['your-email'])){
            $body['email'] = $_REQUEST['your-email'];
        }
        if(isset($_REQUEST['your-phone'])){
            $body['phone'] = $_REQUEST['your-phone'];
        }
	    $rr = saveContactApiData($body);

        // return current cf7 instance
        return $wpcf7;
    }
   
}
function saveContactApiData($body){
    $url = DEALSECTOR_API_URL.'saveContactForm';
    $args = array(
        'headers' => array( 
            'Authorization' => CLIENT_KEY
        ),
        'method' => 'POST',
        'body' => $body
    );
    $remote_api_request = wp_remote_get( $url, $args );
    $response_code = wp_remote_retrieve_response_code( $remote_api_request );
    $body = wp_remote_retrieve_body( $remote_api_request );
    $json_data = json_decode( $body );
    $response_arr = array(
        'response_code' => $response_code,
        'response_data' => $json_data
    );
    
    return $response_arr;
}
?>