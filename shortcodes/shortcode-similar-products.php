<?php
global $wpdb;
$template_id = 0;
$template = $wpdb->get_results( "SELECT shortcode_template_id FROM ".DEALSECTOR_SHORTCODE_TEMPLATE." where shortcode_code = 'dealsector_similar_products'" );
if(count($template) > 0){
    $template_id = $template[0]->shortcode_template_id; 
}
if($template_id > 0){
	$inventory = 0;
	if(isset($_GET["id"]) && $_GET["id"] != ""){
		$inventory = $_GET["id"];
	}

	$inventorysSimilarList = DealsectorAPI::getSimilarInventory( array("inventory" => $inventory) );
	if(isset($inventorysSimilarList->data) && count($inventorysSimilarList->data) > 0){
	  require_once(DEALSECTOR__PLUGIN_DIR."templates/similar-products-template.php");
	}else{
		echo "No record found.";
	}
}else{
    echo "Missing Template: Similar Product Template";
}

?>