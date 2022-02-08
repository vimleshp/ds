<div class="similarresult">
<?php
    foreach($inventorysSimilarList->data  as $key => $value){
    	// get template content
        $template_content = get_the_content( "", "", $template_id );
        // replace template placeholders
        if(isset($value->image->fileThumbPath) && $value->image->fileThumbPath != ""){
        	$template_content = str_replace('$$itemSimilarImage$$', $value->image->fileThumbPath, $template_content);
        }else{
        	$template_content = str_replace('$$itemSimilarImage$$', DEALSECTOR__PLUGIN_BASE_URL."includes/images/defaultimage.jpg", $template_content);
        }
        $viewDetailLink = get_permalink(get_page_by_path( 'view-detail-page' ))."?id=".$value->_id;
        $template_content = str_replace('$$itemSimilarInventoryLink$$', $viewDetailLink, $template_content);
        $template_content = str_replace('$$itemSimilarInventory$$', $value->title, $template_content);
        // shortcode to html
        echo do_shortcode( $template_content );
    }
?>
</div>