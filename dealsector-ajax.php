<?php
$filename="../../../wp-load.php";
require_once($filename);
require_once("dealsector.php");
global $wpdb;
if( isset($_POST["action"]) AND $_POST["action"] == 'dealsector_getNearStore'){
  $locationNearBy = DealsectorAPI::getNearStore($_POST);
  echo json_encode($locationNearBy);
}

if( isset($_POST["action"]) AND $_POST["action"] == 'dealsector_location_detail'){
  $locationList = DealsectorAPI::getfilters();
  if(isset($locationList->data->locations)){
    foreach($locationList->data->locations as $key => $value){
      if($_POST["id"] == $value->store_id){
        $locationString = $value->store_name;
        if($value->city){
          $locationString .= ", ".$value->city;
        }if($value->state){
          $locationString .= ", ".$value->state;
        }
        echo  $locationString."|".$value->store_id;
        break;
      }
    }
  }else{
    echo false;
  }
}
if( isset($_POST["action"]) AND $_POST["action"] == 'dealsector_getlocation'){
  $locations = $wpdb->get_results( "SELECT * FROM ".DEALSECTOR_LOCATION_TABLE );
  if(isset($locations)){
  	echo json_encode($locations);
  }else{
  	echo false;
  }
}
if( isset($_POST["action"]) AND $_POST["action"] == 'dealsector_location_list'){
  $locationList = DealsectorAPI::getfilters();
  require_once(DEALSECTOR__PLUGIN_DIR."templates/location-template.php");
}
if( isset($_POST["action"]) AND $_POST["action"] == 'dealsector_inventory'){
  $inventorysData = DealsectorAPI::getinventory($_POST['inventory']);
  echo json_encode($inventorysData);
}
if( isset($_POST["action"]) AND $_POST["action"] == 'dealsector_inventoryimages'){
  $inventorysImages = DealsectorAPI::getinventoryimages($_POST['inventory']);
  echo json_encode($inventorysImages);
}
if( isset($_POST["action"]) AND $_POST["action"] == 'dealsector_filter_inventorys_recordcount'){
  $inventorysList = DealsectorAPI::getinventorys($_POST);
  if(isset($inventorysList->data->recordtotal)){
    echo $inventorysList->data->recordtotal;
  }else{
    echo 0;
  }
}
if( isset($_POST["action"]) AND $_POST["action"] == 'dealsector_filter_inventorys'){
  $inventorysList = DealsectorAPI::getinventorys($_POST);
  require_once(DEALSECTOR__PLUGIN_DIR."templates/inventorys-template.php");
}

if( isset($_POST["action"]) AND $_POST["action"] == 'dealsector_storelocation'){
  try{
    $response = array();
   
    #Truncate table
    $wpdb->query( "TRUNCATE TABLE  `". DEALSECTOR_LOCATION_TABLE . "`" );
    if($wpdb->get_var( "show tables like 'DEALSECTOR_LOCATION_TABLE'" ) != DEALSECTOR_LOCATION_TABLE) 
    {
         $sql = "CREATE TABLE `". DEALSECTOR_LOCATION_TABLE . "` ( ";
         $sql .= "  `id`  int(11)   NOT NULL auto_increment, ";
         $sql .= "  `store_id`  varchar(255) NULL, ";
         $sql .= " `store_name` varchar(255) NULL, ";
         $sql .= " `state` varchar(255) NULL, ";
         $sql .= " `phone` varchar(255) NULL, ";
         $sql .= " `email` text NULL, ";
         $sql .= " `city` varchar(255) NULL, ";
         $sql .= "  PRIMARY KEY `id` (`id`) "; 
         $sql .= ") ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; ";
         $wpdb->query( $sql );
    }
    $locationList = DealsectorAPI::getLocations();
    if(isset($locationList->data)){
        foreach($locationList->data  as $key => $value){
        	$data = array(
            'store_id' => $value->store_id,
            'store_name' => $value->store_name, 
            'state' => $value->state, 
            'phone' => $value->phone,
            'email' => $value->email,
            'city' => $value->city
            );
            $format = array('%s', '%s', '%s', '%s', '%s', '%s');
            $wpdb->insert( DEALSECTOR_LOCATION_TABLE, $data, $format );
            $response["message"] = "Locations saved successfully.";
            $response["error"] = false;
        }
    }else{
        $response["message"] = "Locations not found.";
        $response["error"] = true;
    }
  }catch(Exception $e){
    $response["message"] = "Try again.";
    $response["error"] = true;
  }
  echo json_encode($response);
}

if( isset($_POST["action"]) AND $_POST["action"] == 'dealsector_saveshortcode'){
  $response = array();
  $code = $_POST["sc_code"];
  $isrecordfound = $wpdb->get_results( "SELECT * FROM ".DEALSECTOR_SHORTCODE_TEMPLATE." where shortcode_code = '$code'" );
  try{
    if(count($isrecordfound) == 0){
      $data = array(
        'shortcode_template_id' => $_POST["sc_template"],
        'shortcode_title' => $_POST["sc_title"], 
        'shortcode_code' => $_POST["sc_code"], 
        'shortcode_description' => $_POST["sc_desc"]
      );
      $format = array('%s', '%s', '%s');
      $wpdb->insert( DEALSECTOR_SHORTCODE_TEMPLATE, $data, $format );
      $response["message"] = "Shortcode saved successfully.";
      $response["error"] = false;
    }else{
      $response["message"] = "Shortcode already exist.";
      $response["error"] = false;
    }
  }catch(Exception $e){
    $response["message"] = "Try again.";
    $response["error"] = true;
  }
  echo json_encode($response);
}
if( isset($_POST["action"]) AND $_POST["action"] == 'dealsector_saveclientkey'){
  $isrecordfound = $wpdb->get_results( "SELECT * FROM ".DEALSECTOR_CLIENT_TABLE );

  if( isset($isrecordfound[0]) ){
     $where = [ 'id' => $isrecordfound[0]->id ];
  }else{
     $where = [ 'id' => 1 ];
     $exisitingclientkey = '';
     $records_to_show = 5;
  }
  $response = array();
  if ( isset( $_POST["client_secret_key"] ) AND trim( $_POST["client_secret_key"] ) != NULL 
    AND isset($_POST["records_to_show"]) AND $_POST["records_to_show"] != NULL) {
    
      $apilink = $_POST["api_link"];
      $clientkey = $_POST["client_secret_key"];
      $records_to_show = $_POST["records_to_show"];
      $currency = $_POST["currency"];
	    $finance_link = $_POST["finance_link"];

      $checkAPI = DealsectorAPI::checkAPI( $clientkey );
	  if( isset($checkAPI->error) AND $checkAPI->error == true ){
        $response["message"] = $checkAPI->messages;
        $response["error"] = true;
      }else{
        $data = array('api_link' => $apilink,'key' => $clientkey, 'records_to_show' => $records_to_show, 'currency' => $currency, 'finance_link' => $finance_link); 
        $format = array('%s','%s', '%d', '%s', '%s');

        try{
          if($isrecordfound == NULL){
             $savekeyresult = $wpdb->insert( DEALSECTOR_CLIENT_TABLE, $data, $format );
          }else{
             $savekeyresult = $wpdb->update( DEALSECTOR_CLIENT_TABLE, $data, $where, $format);
          }
          $response["message"] = "Setting saved successfully.";
          $response["error"] = false;
        }catch(Exception $e){
          $response["message"] = "Try again.";
          $response["error"] = true;
        }
      }
}else{
  $response["message"] = "Please enter settings.";
  $response["error"] = false;
}
echo json_encode($response);
}
	
?>