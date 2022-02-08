<?php
global $dealsector_featuredinv_attr;
global $wpdb;
$template_id = 0;

$template = $wpdb->get_results( "SELECT shortcode_template_id FROM ".DEALSECTOR_SHORTCODE_TEMPLATE." where shortcode_code = 'dealsector_featuredinventorys'" );

if(count($template) > 0){
    $template_id = $template[0]->shortcode_template_id; 
}
if($template_id > 0){

	$condition ="";
	$featured = false;
	$showZeroPrice = false;
	if(isset( $dealsector_featuredinv_attr["atts"]["condition"] )){
	    $condition = $dealsector_featuredinv_attr["atts"]["condition"];
	}

	if(isset( $dealsector_featuredinv_attr["atts"]["featured"] )){
	    $featured = $dealsector_featuredinv_attr["atts"]["featured"];
	}
	if(isset( $dealsector_featuredinv_attr["atts"]["showzeroprice"] )){
	    $showZeroPrice = $dealsector_featuredinv_attr["atts"]["showzeroprice"];
	}

	$class="";
	$sliderControl_id=0;
    if($featured=="true"){
      $class="featured";
      $sliderControl_id=1;
    }
    elseif ($featured=="false") {
      $class="newArrival";
      $sliderControl_id=2;
    }
	
	$featuredInventorysList = DealsectorAPI::getfeaturedinventories($condition,$featured);
	require(DEALSECTOR__PLUGIN_DIR."templates/featured-inventory-template.php");
}
else{
        echo "Missing Template: Featured Inventory Template";
}
?>