<div class="filterresult">
<?php
    if( isset($filtersList->data) ){
        // get template content
        $template_content = get_the_content( "", "", $template_id );
        // replace template placeholders
        $template_content = str_replace('$$filterPriceHighLowOpts$$', $priceHighLowOpts, $template_content);
	$template_content = str_replace('$$filterHeightOpts$$', $heightOpts, $template_content);
	$template_content = str_replace('$$filterwallHeightOutOpts$$', $wallHeightOutOpts, $template_content);
    	$template_content = str_replace('$$filterColorOpts$$', $colorOpts, $template_content);
	    $template_content = str_replace('$$filterSpecialFeatureOpts$$', $specialFeatureOpts, $template_content);
        $template_content = str_replace('$$filterLocationOpts$$', $locationOpts, $template_content);
        $template_content = str_replace('$$filterPriceRangeOpts$$', $priceRangeOpts, $template_content);
        $template_content = str_replace('$$filterInvLengthOpt$$', $invLengthOpts, $template_content);
        $template_content = str_replace('$$filterGroupTypeOpt$$', $groupTypeOpts, $template_content);
        $template_content = str_replace('$$filterConditionOpts$$', $conditionOpts, $template_content);
        $template_content = str_replace('$$filterTrailerTypeOpts$$', $trailerTypeOpts, $template_content);
        $template_content = str_replace('$$filterMakesOpts$$', $makesOpts, $template_content);
        $template_content = str_replace('$$filterCouplerTypeOpts$$', $couplerTypeOpts, $template_content);
        $template_content = str_replace('$$filterInventoryTypeOpt$$', $inventoryTypeOpts, $template_content);
        
        // shortcode to html
        echo do_shortcode( $template_content );
    }else{
        echo "No filter found";
    }
?>
</div>
