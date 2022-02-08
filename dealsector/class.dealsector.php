<?php

class Dealsector {
	
	
    private static $initiated = false;

	  public static function init() {
		  if ( ! self::$initiated ) {
			 self::init_hooks();
		  }
	  }

	  /**
	   * Initializes WordPress hooks
	  */
	  private static function init_hooks() {
    self::$initiated = true;
      add_action( 'admin_menu', array( 'Dealsector', 'register_dealsector_menu_page' ) );
      add_action( 'admin_enqueue_scripts', array( 'Dealsector', 'load_resources' ) );
      add_action( 'wp_enqueue_scripts', array( 'Dealsector', 'load_frontend_resources' ) );
    }
    
    
    // Register a dealsector menu page.
    public static function register_dealsector_menu_page() {
      add_menu_page(
            __( 'Dealsector', 'textdomain' ),
             'Dealsector',
             'manage_options',
             'dealsector/dealsector-admin.php',
             '',
             'dashicons-palmtree',
             6
          );
      }

	  public static function dealsector_get_template_part( $type, $name ) {

		  $file = DEALSECTOR__PLUGIN_DIR . 'shortcodes/'.$type. '-' .$name. '.php';

		  include( $file );
	  }

    // Load css and js files.
    public static function load_resources() {

	    wp_register_style( 'dealsector-admin.css', DEALSECTOR__PLUGIN_BASE_URL.'includes/dealsector-admin.css' );
	    wp_enqueue_style( 'dealsector-admin.css');

	    wp_register_script( 'jquery.validate.min.js', DEALSECTOR__PLUGIN_BASE_URL.'includes/jquery.validate.min.js', array( 'jquery' ) );
      wp_enqueue_script( 'jquery.validate.min.js' );

      wp_register_script( 'additional-methods.min.js', DEALSECTOR__PLUGIN_BASE_URL.'includes/additional-methods.min.js', array( 'jquery' ) );
      wp_enqueue_script( 'additional-methods.min.js' );
      
      wp_register_script( 'dealsector-admin.js', DEALSECTOR__PLUGIN_BASE_URL.'includes/dealsector-admin.js', array( 'jquery' ) );
	    wp_enqueue_script( 'dealsector-admin.js' );

      $options = array('dealsectorAjaxUrl' => DEALSECTOR__PLUGIN_BASE_URL .'dealsector-ajax.php', 
      'dealsectorRecordToShow' => RECORD_TO_SHOW, 
      'dealsectorSiteUrl' => DEALSECTOR_SITE_URL);
    
      wp_localize_script( 
      'dealsector-admin.js', 
      'dealsector_settings',
      $options
      );
    }

     // Front-end: Load css and js files.
     public static function load_frontend_resources(){

      wp_register_style( 'dealsector.css', DEALSECTOR__PLUGIN_BASE_URL.'includes/dealsector.css' );
      wp_enqueue_style( 'dealsector.css');
		 
	  wp_register_style( 'lightslider.css', DEALSECTOR__PLUGIN_BASE_URL.'includes/lightslider.css' );
      wp_enqueue_style( 'lightslider.css');

      wp_register_style( 'dscustom.css', DEALSECTOR__PLUGIN_BASE_URL.'includes/dscustom.css' );
      wp_enqueue_style( 'dscustom.css');
      
      wp_register_script( 'jquery.printPage.js', DEALSECTOR__PLUGIN_BASE_URL.'includes/jquery.printPage.js', array( 'jquery' ) );
      wp_enqueue_script( 'jquery.printPage.js' );
      
      wp_register_script( 'lightslider.js', DEALSECTOR__PLUGIN_BASE_URL.'includes/lightslider.js', array( 'jquery' ) );
      wp_enqueue_script( 'lightslider.js' );

      wp_register_script( 'jquery.lazy.min.js', DEALSECTOR__PLUGIN_BASE_URL.'includes/jquery.lazy.min.js', array( 'jquery' ) );
      wp_enqueue_script( 'jquery.lazy.min.js' );

      wp_register_script( 'jquery.lazy.plugins.min.js', DEALSECTOR__PLUGIN_BASE_URL.'includes/jquery.lazy.plugins.min.js', array( 'jquery' ) );
      wp_enqueue_script( 'jquery.lazy.plugins.min.js' );
		 
	    wp_register_script( 'jquery.cookie.js', DEALSECTOR__PLUGIN_BASE_URL.'includes/jquery.cookie.js', array( 'jquery' ) );
      wp_enqueue_script( 'jquery.cookie.js' );

      wp_register_script( 'custom.js', DEALSECTOR__PLUGIN_BASE_URL.'includes/custom.js', array( 'jquery' ) );
      wp_enqueue_script( 'custom.js' );
  
      wp_register_script( 'shortcode-inventorys.js', DEALSECTOR__PLUGIN_BASE_URL.'includes/shortcode-inventorys.js', array( 'jquery' ) );
      wp_enqueue_script( 'shortcode-inventorys.js' );

      wp_register_script( 'shortcode-view-detail.js', DEALSECTOR__PLUGIN_BASE_URL.'includes/shortcode-view-detail.js', array( 'jquery' ) );
      wp_enqueue_script( 'shortcode-view-detail.js' );
		
      $options = array('dealsectorAjaxUrl' => DEALSECTOR__PLUGIN_BASE_URL .'dealsector-ajax.php', 
      'dealsectorRecordToShow' => RECORD_TO_SHOW, 
      'dealsectorSiteUrl' => DEALSECTOR_SITE_URL,
	   'dealsectorPluginBaseUrl' => DEALSECTOR__PLUGIN_BASE_URL);
    
      wp_localize_script( 
      'shortcode-inventorys.js', 
      'dealsector_settings',
      $options
      );
      wp_localize_script( 
        'shortcode-view-detail.js', 
        'dealsector_settings',
        $options
        );
    }


    /*Create database table for storing dealsector data*/
    private static function create_dealsector_dbtable(){
        global $wpdb;
		    $tblname = DEALSECTOR_CLIENT_TABLE;
        #Check to see if the table exists already, if not, then create it
        if($wpdb->get_var( "show tables like '$tblname'" ) != $tblname) 
        {
           $sql = "CREATE TABLE `". $tblname . "` ( ";
           $sql .= "  `id`  int(11)   NOT NULL auto_increment, ";
           $sql .= "  `api_link`  varchar(255)   NOT NULL, ";
           $sql .= "  `key`  varchar(255)   NOT NULL, ";
           $sql .= " `records_to_show` int(11) DEFAULT 5, ";
		   $sql .= " `finance_link` varchar(255) NULL, ";
           $sql .= " `currency` varchar(50) DEFAULT '$', ";
           $sql .= "  PRIMARY KEY `id` (`id`) "; 
           $sql .= ") ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; ";
           $wpdb->query( $sql );

           $authKey = $wpdb->get_results( "SELECT * FROM ".$tblname );
           if( !defined('CLIENT_KEY') AND !defined('RECORD_TO_SHOW') ){
            if( empty($authKey) ){
              define ( 'API_LINK', null);
              define ( 'CLIENT_KEY', null);
              define ( 'RECORD_TO_SHOW', 5);
              define ( 'CURRENCY', '$');
             }else{
              define ( 'API_LINK', $authKey[0]->api_link);
              define ( 'CLIENT_KEY', $authKey[0]->key);
              define ( 'RECORD_TO_SHOW', $authKey[0]->records_to_show);
              define ( 'CURRENCY', $authKey[0]->currency);
             }
           }
           
	      }
    }
    
    /*Drop database table related to dealsector*/
    private static function drop_dealsector_dbtable(){
        global $wpdb;
	      $tblname = DEALSECTOR_CLIENT_TABLE;
        $wpdb->query( "DROP TABLE IF EXISTS `". $tblname . "`" );
    }

    /*Create database table for dealsector shortcode templates*/
    private static function create_dealsector_shortcode_template_dbtable(){
      global $wpdb;
      $tblname = DEALSECTOR_SHORTCODE_TEMPLATE;
      #Check to see if the table exists already, if not, then create it
      if($wpdb->get_var( "show tables like '$tblname'" ) != $tblname) 
      {
         $sql = "CREATE TABLE `". $tblname . "` ( ";
         $sql .= "  `id`  int(11)   NOT NULL auto_increment, ";
         $sql .= "  `shortcode_title`  varchar(255)   NOT NULL, ";
         $sql .= " `shortcode_code` varchar(255)   NOT NULL, ";
         $sql .= " `shortcode_description` varchar(255)   NOT NULL, ";
         $sql .= " `shortcode_template_id` int(11) NULL, ";
         $sql .= "  PRIMARY KEY `id` (`id`) "; 
         $sql .= ") ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; ";
         $wpdb->query( $sql );

        $data = array(
          'shortcode_title' => 'Inventory Listing', 
          'shortcode_code' => 'dealsector_inventorys', 
          'shortcode_description' => 'Inventory listing short-code is use to get all inventories.'
        );
        $wpdb->insert( DEALSECTOR_SHORTCODE_TEMPLATE, $data );

        $data = array(
          'shortcode_title' => 'Filter Form', 
          'shortcode_code' => 'dealsector_filter', 
          'shortcode_description' => 'Filter short-code is use to get filter form fields.'
        );
        $wpdb->insert( DEALSECTOR_SHORTCODE_TEMPLATE, $data );

        $data = array(
          'shortcode_title' => 'Pagination', 
          'shortcode_code' => 'dealsector_pagination', 
          'shortcode_description' => 'Top pagination short-code is use to get top pagination of inventory listing.'
        );
        $wpdb->insert( DEALSECTOR_SHORTCODE_TEMPLATE, $data );

        $data = array(
          'shortcode_title' => 'View Detail', 
          'shortcode_code' => 'dealsector_viewdetail', 
          'shortcode_description' => 'View detail short-code is use to get the detail of inventory.'
        );
        $wpdb->insert( DEALSECTOR_SHORTCODE_TEMPLATE, $data );

        $data = array(
          'shortcode_title' => 'Featured Inventory', 
          'shortcode_code' => 'dealsector_featuredinventorys', 
          'shortcode_description' => 'Featured inventory short-code is use to get featured inventories.'
        );
        $wpdb->insert( DEALSECTOR_SHORTCODE_TEMPLATE, $data );
		  
	$data = array(
          'shortcode_title' => 'Print Detail', 
          'shortcode_code' => 'dealsector_printdetail', 
          'shortcode_description' => 'Print detail short-code is use to print inventories detail.'
        );
        $wpdb->insert( DEALSECTOR_SHORTCODE_TEMPLATE, $data );

        $data = array(
          'shortcode_title' => 'Pre-Owned Inventory', 
          'shortcode_code' => 'dealsector_preowninventorys', 
          'shortcode_description' => 'Pre-Owned inventory short-code is use to get pre-owned inventories.'
        );
        $wpdb->insert( DEALSECTOR_SHORTCODE_TEMPLATE, $data ); 

        $data = array(
          'shortcode_title' => 'Location Pop-up', 
          'shortcode_code' => 'dealsector_locationinventorys', 
          'shortcode_description' => 'Location pop-up short-code is use to show location pop-up to change location.'
        );
        $wpdb->insert( DEALSECTOR_SHORTCODE_TEMPLATE, $data ); 

        $data = array(
          'shortcode_title' => 'Location Pop-Up Body', 
          'shortcode_code' => 'dealsector_locationinventorys_dumy', 
          'shortcode_description' => 'Location Pop-Up Body is use to design / get the location list.'
        );
        $wpdb->insert( DEALSECTOR_SHORTCODE_TEMPLATE, $data );
	      
      }
  }
  
  /*Drop database table related to  dealsector shortcode templates*/
  private static function drop_dealsector_shortcode_template_dbtable(){
      global $wpdb;
      $tblname = DEALSECTOR_SHORTCODE_TEMPLATE;
      $wpdb->query( "DROP TABLE IF EXISTS `". $tblname . "`" );
  }

    /**
     * Attached to activate_{ plugin_basename( __FILES__ ) } by register_activation_hook()
     * @static
     */
    public static function dealsector_activation() {
      self::create_dealsector_dbtable();
      self::create_dealsector_shortcode_template_dbtable();
    }

    /**
     * Removes all connection options
     * @static
     */
    public static function dealsector_deactivation( ) {
      self::drop_dealsector_dbtable();
      self::drop_dealsector_shortcode_template_dbtable();
    }
}

?>