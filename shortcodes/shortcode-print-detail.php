<?php
//get shortcode params
global $wpdb;
$template_id = 0;
$template = $wpdb->get_results( "SELECT shortcode_template_id FROM ".DEALSECTOR_SHORTCODE_TEMPLATE." where shortcode_code = 'dealsector_printdetail'" );
if(count($template) > 0){
    $template_id = $template[0]->shortcode_template_id; 
}
if($template_id > 0){
	if(isset($_GET["id"]) && $_GET["id"] != ""){
	    $id = $_GET["id"];
	    $inventoryData = DealsectorAPI::getinventory($id);
	    require_once(DEALSECTOR__PLUGIN_DIR."templates/view-detail-template.php");
	}elseif(isset($_GET["stocknumber"]) && $_GET["stocknumber"] != ""){
		$stocknumber= $_GET["stocknumber"];
		$inventoryData = DealsectorAPI::getinventory($stocknumber);
	    require_once(DEALSECTOR__PLUGIN_DIR."templates/view-detail-template.php");
	}else{
	    echo "No record found";
	}
}else{
    echo "Missing Template: View Detail Template";
}
?>
