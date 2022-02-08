<?php
global $wpdb;
global $dealsector_inventorys_attr;

$category = "";
if(isset( $dealsector_inventorys_attr["atts"]["category"] )){
    $category = $dealsector_inventorys_attr["atts"]["category"];
}

$cookie_location = "";
if(isset($_COOKIE["USERLOCATION"])){
    $cookieLocation = base64_decode($_COOKIE["USERLOCATION"]);
    $cookieLocation = explode("|", $cookieLocation);
    if(isset($cookieLocation[1])){
    	$cookie_location = $cookieLocation[1];
    }else{
    	$cookie_location = "";
    }
}

$trailer_type = "";
if(isset( $dealsector_inventorys_attr["atts"]["trailer_type"] )){
    $trailer_type = $dealsector_inventorys_attr["atts"]["trailer_type"];
}

if(isset($_GET["pageno"]) && $_GET["pageno"] > 0){
	$startno = ($_GET["pageno"] - 1) * RECORD_TO_SHOW;
}else{
	$startno = 0;
}


$template_id = 0;
$template = $wpdb->get_results( "SELECT shortcode_template_id FROM ".DEALSECTOR_SHORTCODE_TEMPLATE." where shortcode_code = 'dealsector_inventorys'" );
if(count($template) > 0){
    $template_id = $template[0]->shortcode_template_id; 
}

if($template_id > 0){ 
	$inventorysList = DealsectorAPI::getinventorys( array("start" => $startno, "limit" => RECORD_TO_SHOW, "category" => $category ,"trailer_type" => $trailer_type ,"location" => $cookie_location) );
	require_once(DEALSECTOR__PLUGIN_DIR."templates/inventorys-template.php");
	echo '<input type="hidden" name="category" value="'.$category.'"/>';
}
else{
    echo "Missing Template: Trailers List Template";
}
?>
