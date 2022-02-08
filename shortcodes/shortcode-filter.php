<?php
// for static filter options
require_once("filter-options.php");
//get shortcode params
global $wpdb;
global $dealsector_filter_attr;
$template_id = 0;
$template = $wpdb->get_results( "SELECT shortcode_template_id FROM ".DEALSECTOR_SHORTCODE_TEMPLATE." where shortcode_code = 'dealsector_filter'" );
if(count($template) > 0){
    $template_id = $template[0]->shortcode_template_id; 
}

if($template_id > 0){
    $category = "";
    if(isset( $dealsector_filter_attr["atts"]["category"] )){
        $category = $dealsector_filter_attr["atts"]["category"];
    }
    $search_key="";
    if(isset($_COOKIE['search_key'])){
        $search_key=$_COOKIE['search_key'];
    }

    
    //get filter options
    $filtersList = DealsectorAPI::getFilters();

    if( isset($filtersList->data) ){
        //static filter options
        $priceHighLowOpts = "<option value=''>Sort By</option>";
        foreach($priceHighLowArr as $key => $value ){
            if($value->value != ""){
                $selected="";
                if(strlen(trim($search_key)) > 0 && strtolower($value->value)==strtolower($search_key)){
                    $selected="selected";
                }
                $priceHighLowOpts = $priceHighLowOpts."<option value='".$value->value."' ".$selected.">".$value->name."</option>";
            }
        }
        
        $priceRangeOpts = "<option value=''>Select Price Range</option>";
        foreach($priceRangeArr as $key => $value ){
            if($value->value != ""){
                $selected="";
                if(strlen(trim($search_key)) > 0 && strtolower($value->value)==strtolower($search_key)){
                    $selected="selected";
                }
                $priceRangeOpts = $priceRangeOpts."<option value='".$value->value."' ".$selected.">".$value->name."</option>";
            }
        }
        
        $heightOpts = "<option value=''>Height</option>";
        foreach($heightArr as $key => $value ){
            if($value->value != ""){
                $selected="";
                if(strlen(trim($search_key)) > 0 && strtolower($value->value)==strtolower($search_key)){
                    $selected="selected";
                }
                $heightOpts = $heightOpts."<option value='".$value->value."' ".$selected.">".$value->name."</option>";
            }
        }
        
        $wallHeightOutOpts = "<option value=''>Height</option>";
        foreach($wallHeightOutArr as $key => $value ){
            if($value->value != ""){
                $selected="";
                if(strlen(trim($search_key)) > 0 && strtolower($value->value)==strtolower($search_key)){
                    $selected="selected";
                }
                $wallHeightOutOpts = $wallHeightOutOpts."<option value='".$value->value."' ".$selected.">".$value->name."</option>";
            }
        }

        $specialFeatureOpts = "<option value=''>Special Features</option>";
        foreach($specialFeatureArr as $key => $value ){
            if($value->value != ""){
                $selected="";
                if(strlen(trim($search_key))>0 && strtolower($value->value)==strtolower($search_key)){
                    $selected="selected";
                }
                $specialFeatureOpts = $specialFeatureOpts."<option value='".$value->value."' ".$selected.">".$value->name."</option>";
            }
        }


        $colorOpts = "<option value=''> Color</option>";
        if(isset($filtersList->data->color)){
            foreach($filtersList->data->color as $key => $value){
                if($value->_id != ""){
                    $selected="";
                    if(strlen(trim($search_key))>0 && strtolower($value->_id)==strtolower($search_key)){
                        $selected="selected";
                    }
                    $colorOpts = $colorOpts."<option value='".$value->_id."' ".$selected.">".$value->_id."</option>";
                }
            }
        }

        $groupTypeOpts = "<option value=''>Select Group Type</option>";
        foreach($groupTypeArr as $key => $value ){
             if($value->value != ""){
                $selected="";
                if(strlen(trim($search_key))>0 && strtolower($value->value)==strtolower($search_key)){
                    $selected="selected";
                }
                $groupTypeOpts = $groupTypeOpts."<option value='".$value->value."'>".$value->name."</option>";
            }
        }


        $invLengthOpts = "<option value=''>Length</option>";
        foreach($invLengthArr as $key => $value ){
            if($value->value != ""){
                $selected="";
                if(strlen(trim($search_key)) > 0 && strtolower($value->value)==strtolower($search_key)){
                    $selected="selected";
                }
                $invLengthOpts = $invLengthOpts."<option value='".$value->value."' ".$selected.">".$value->name."</option>";
            }
        }
        
        // dynamic filter options
        $conditionOpts = "<option value=''>Condition</option>";
        if(isset($filtersList->data->condition)){
            foreach($filtersList->data->condition as $key => $value){
                if($value->_id != ""){
                    $selected="";
                    if(strlen(trim($search_key)) > 0 && strtolower($value->_id)==strtolower($search_key)){
                        $selected="selected";
                    }
                    $conditionOpts = $conditionOpts."<option value='".$value->_id."' ".$selected.">".$value->_id."</option>";
                    
                }
            }
        }

        $couplerTypeOpts = "<option value=''>Select Coupler Type</option>";
        if(isset($filtersList->data->couplerType)){
            foreach($filtersList->data->couplerType as $key => $value){
                if($value->_id != ""){
                    $selected="";
                    if(strlen(trim($search_key)) > 0 && strtolower($value->_id)==strtolower($search_key)){
                        $selected="selected";
                    }
                    $couplerTypeOpts = $couplerTypeOpts."<option value='".$value->_id."' ".$selected.">".$value->_id."</option>";
                }
            }
        }


        $makesOpts = "<option value=''>Select Make</option>";
        if(isset($filtersList->data->makes)){
            foreach($filtersList->data->makes as $key => $value){
                if($value->id != ""){
                    $selected="";
                    if(strlen(trim($search_key)) > 0 && strtolower($value->slug)==strtolower($search_key)){
                        $selected="selected";
                    }
                    $makesOpts = $makesOpts."<option value='".$value->slug."' ".$selected.">".$value->label."</option>";
                }
            }
        }


        $trailerTypeOpts = "<option value=''>Select Product Type</option> <option value='' selected='selected'>All Product Types</option>";
        if(isset($filtersList->data->vehicle_type)){
            foreach($filtersList->data->vehicle_type as $key => $value){
                if($value->id != ""){
                    $selected="";
                    if(strlen(trim($search_key)) > 0 && strtolower($value->_id)==strtolower($search_key)){
                        $selected="selected";
                    }
                    $trailerTypeOpts = $trailerTypeOpts."<option value='".$value->id."' ".$selected.">".$value->label."</option>";
                }
            }
        }


        $locationOpts = "<option value=''>Location</option>";
        if(isset($filtersList->data->locations)){
            foreach($filtersList->data->locations as $key => $value){
                if($value->store_id != ""){
                    $selected="";
                    if(strlen(trim($search_key)) > 0 && strtolower($value->store_id)==strtolower($search_key)){
                        $selected="selected";
                    }
                    $locationOpts = $locationOpts."<option value='".$value->store_id."' ".$selected.">".$value->store_name."</option>";
                }
            }
        }


        $inventoryTypeOpts = "<option value=''>Category</option>";
        if(isset($filtersList->data->categories)){
            foreach($filtersList->data->categories as $key => $value){
                if($value->id != ""){
                    $selected="";
                    if(strlen(trim($search_key)) > 0 && strtolower($value->slug)==strtolower($search_key)){
                        $selected="selected";
                    }
                    $inventoryTypeOpts = $inventoryTypeOpts."<option value='".$value->slug."' ".$selected.">".$value->label."</option>";
                }
            }
        }
        
        // dynamic filter options
    }
    require_once(DEALSECTOR__PLUGIN_DIR."templates/filter-template.php");
}
else{
    echo "Missing Template: Filter Form Template";
}
?>