<?php
global $wpdb;
global $dealsector_locationphone_attr;
$locationid = 0;
if(isset( $dealsector_locationphone_attr["atts"]["locationid"] )){
    $locationid = $dealsector_locationphone_attr["atts"]["locationid"];
}

$locationPhone = $wpdb->get_results( "SELECT * FROM ".DEALSECTOR_LOCATION_TABLE. " where 1 = 1  AND store_id = ". $locationid );
if(count($locationPhone) > 0){
	echo $locationPhone[0]->phone;
}else{
	echo "Number not found";
}
?>