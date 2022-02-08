<div class="locationresult">
<?php
	$template_content = get_the_content( "", "", $template_id );
    $template_content_full_body = get_the_content( "", "", $template_id_body );
    $template_content_full_body = str_replace('$$itemLocation$$', "All Locations", $template_content_full_body); 
    $template_content_full_body = str_replace('$$itemLocationID$$', "" , $template_content_full_body);
	if(isset($locationList->data->locations)){
		// replace template placeholders
		foreach($locationList->data->locations as $key => $value){
			$template_content_body = get_the_content( "", "", $template_id_body );
			$locationName = $value->store_name;
			$template_content_body = str_replace('$$itemLocation$$', $locationName, $template_content_body); 
			$template_content_body = str_replace('$$itemLocationID$$', $value->store_id, $template_content_body);
			$template_content_full_body .= $template_content_body;
		}
		$template_content = str_replace('$$itemPopUpBody$$', $template_content_full_body, $template_content);
		// shortcode to html
		echo do_shortcode( $template_content ); 
	}else{
		echo "No records found";
	}
	
?>
</div>