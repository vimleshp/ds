<?php
global $wpdb;
global $dealsector_pagination_attr;
$template_id = 0;
$template = $wpdb->get_results( "SELECT shortcode_template_id FROM ".DEALSECTOR_SHORTCODE_TEMPLATE." where shortcode_code = 'dealsector_pagination'" );
if(count($template) > 0){
    $template_id = $template[0]->shortcode_template_id; 
}
if($template_id > 0){
    $numberOfRecordsOnPage = RECORD_TO_SHOW;
    $totalRecords = 0;
    $pageStart = 0;
    $pageEnd = 0;
    $numberOfPages = 0;
    $category = "";
    $location = "";
    if(isset( $dealsector_pagination_attr["atts"]["category"] )){
        $category = $dealsector_pagination_attr["atts"]["category"];
    }

    if(isset( $dealsector_pagination_attr["atts"]["location"] )){
        $location = $dealsector_pagination_attr["atts"]["location"];
    }

    if($location == 'all'){
        $location = "";
    }
    else if(isset($_COOKIE["USERLOCATION"])){
        $cookieLocation = base64_decode($_COOKIE["USERLOCATION"]);
        $cookieLocation = explode("|", $cookieLocation);
        if(isset($cookieLocation[1])){
            $location = $cookieLocation[1];
        }else{
            $location = "";
        }
    }		

    $trailer_type = "";
    if(isset( $dealsector_pagination_attr["atts"]["trailer_type"] )){
        $trailer_type = $dealsector_pagination_attr["atts"]["trailer_type"];
    }

    $inventorysList = DealsectorAPI::getinventorys( array("category" => $category ,"trailer_type" => $trailer_type ,"location" => $location) );
    if(isset($inventorysList->data->recordtotal)){
        if(isset($_GET["pageno"]) && $_GET["pageno"] > 0){
            $pageStart = $_GET["pageno"];
        }else{
            $pageStart = 1;
        }
        $totalRecords = $inventorysList->data->recordtotal;
        $numberOfPages = ceil($totalRecords/$numberOfRecordsOnPage);
        $pageEnd = $numberOfPages;
    }
	require(DEALSECTOR__PLUGIN_DIR."templates/pagination-template.php");
}else{
    echo "Missing Template: Pagination Template";
}
?>