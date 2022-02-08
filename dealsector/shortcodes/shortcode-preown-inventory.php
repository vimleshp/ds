<?php
global $wpdb;
$template_id = 0;
$template = $wpdb->get_results( "SELECT * FROM ".DEALSECTOR_SHORTCODE_TEMPLATE." where shortcode_code = 'dealsector_preowninventorys'" );
if(count($template) > 0){
    $template_id = $template[0]->shortcode_template_id; 
}
if($template_id > 0){
	$featuredInventorysList = DealsectorAPI::getfeaturedinventories("Used",false);
	require_once(DEALSECTOR__PLUGIN_DIR."templates/preown-inventory-template.php");
}
else{
	echo "Missing Template: Pre-Owned Inventory Template";
}
?>