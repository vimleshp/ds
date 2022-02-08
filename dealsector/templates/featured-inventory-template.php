  <style type="text/css">
    
    .lightSlider{height:100% !important;
	  margin-bottom:5%!important;}
	.lightSlider li img{height:144px;
		width:100%} 
	  .lightSlider li{text-align:center;}

    @media screen and (max-width: 768px) {
     .lightSlider li img{height:163px;}
    } 

    @media screen and (max-width: 600px) {
     .lightSlider li img{height:195px;}
    }

  @media screen and (max-width: 480px) {
   .lightSlider li img{height:auto;}
  }

  </style>
  <?php
    if(count($featuredInventorysList->data) > 0){
      $sliderHtml='<div class="carousel" style="position:relative;"><div class="slideControls_'.$sliderControl_id.' featuredSlideControls"><a class="slidePrev"><i class="fas fa-chevron-left"></i></a><a class="slideNext"><i class="fas fa-chevron-right"></i></a></div>';
        $sliderHtml .= '<ul id="'.$class.'">';
        foreach($featuredInventorysList->data as $key => $val){
            // get template content
            $template_content = get_the_content( "", "", $template_id );
            $viewDetailLink = get_permalink(get_page_by_path( 'view-detail-page' ))."?stocknumber=".$val->stockNo;
            if(isset($val->image->filePath)){
              $imageSizePath = str_replace("main","200x150",$val->image->filePath);
            }else{
              $imageSizePath = DEALSECTOR__PLUGIN_BASE_URL."includes/images/defaultimage.jpg";
            }

            $itemPrice="";
            if($showZeroPrice=="true" && isset($val->price)){
                $itemPrice=CURRENCY.$val->price;
            }
            if(($showZeroPrice=="false" || $showZeroPrice=="")  && isset($val->price) && $val->price >0){
                $itemPrice=CURRENCY.$val->price;
            }

            
            $template_content = str_replace('$$itemImage$$', $imageSizePath, $template_content); 
            $template_content = str_replace('$$itemTitle$$', $val->title, $template_content); 
            $template_content = str_replace('$$itemPrice$$', $itemPrice, $template_content); 
            $template_content = str_replace('$$itemLink$$', $viewDetailLink, $template_content); 
            $sliderHtml .= do_shortcode( urldecode($template_content) ); 
        }
        $sliderHtml .= '</ul>';
        $sliderHtml .= '</div>';
        echo do_shortcode( $sliderHtml );
    }else{
        echo "No record found";
    }
    
?>
  
