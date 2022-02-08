<?php
global $wpdb;
global $dealsector_locationinv_attr;
$location = "";
if(isset( $dealsector_locationinv_attr["atts"]["location"] )){
    $location = $dealsector_locationinv_attr["atts"]["location"];
}
if($location == 'all'){
	$location = "";
    echo '<input type="hidden" name="locationShortcodeAttr" value="all"/>';
}
else if($location == 'current'){
	if(isset($_COOKIE["USERLOCATION"]) && $_COOKIE["USERLOCATION"] != ""){
        $cookieLocation = base64_decode($_COOKIE["USERLOCATION"]);
        $cookieLocation = explode("|", $cookieLocation);
        if(isset($cookieLocation[1])){
        	$location = $cookieLocation[1];
        }else{
        	$location = "";
        }
    }else{
    	$location = "";
    }
    echo '<input type="hidden" name="locationShortcodeAttr" value="current"/>';
}else{
	echo '<input type="hidden" name="locationShortcodeAttr" value="'.$location.'"/>';
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
    $inventorysList = DealsectorAPI::getinventorys( array("start" => $startno, "limit" => RECORD_TO_SHOW, "location" => $location) );
    require_once(DEALSECTOR__PLUGIN_DIR."templates/inventorys-template.php");
}
else{
    echo "Missing Template: Trailers List Template";
}

?>
