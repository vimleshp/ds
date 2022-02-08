<?php
global $wpdb;
$template_id = 0;
$template = $wpdb->get_results( "SELECT * FROM ".DEALSECTOR_SHORTCODE_TEMPLATE." where shortcode_code = 'dealsector_locationinventorys'" );
if(count($template) > 0){
    $template_id = $template[0]->shortcode_template_id; 
}
if($template_id > 0){
	$template_id_body = 0;
	$template_body = $wpdb->get_results( "SELECT * FROM ".DEALSECTOR_SHORTCODE_TEMPLATE." where shortcode_code = 'dealsector_locationinventorys_dumy'" );
	if(count($template_body) > 0){
		$template_id_body = $template_body[0]->shortcode_template_id; 
	}

	if($template_id_body > 0){
		$locationList = DealsectorAPI::getFilters();
		require_once(DEALSECTOR__PLUGIN_DIR."templates/location-template.php");
	}
	else{
		echo "Missing Template: Location Pop-Up Body Template";
	}
}
else{
        echo "Missing Template: Location Pop-Up Template";
}
?>