<div class="preowninventoryresult">
  <div class="carousel">
  	<div class="slideControls preSlideControls">
        <a class="slidePrev">
          <i class="fa fa-angle-left"></i>
         </a>
        <a class="slideNext">
          <i class="fa fa-angle-right"></i>
        </a>
      </div>
  <?php
      if(count($featuredInventorysList->data) > 0){
          $sliderHtml = "";
          foreach($featuredInventorysList->data as $key => $val){
              // get template content
              $template_content = get_the_content( "", "", $template_id );
              $viewDetailLink = get_permalink(get_page_by_path( 'view-detail-page' ))."?slug=".$val->titleslug."&id=".$val->stockNo;
              $imageSizePath = DEALSECTOR__PLUGIN_BASE_URL."includes/images/defaultimage.jpg";
              if(isset($val->image->filePath)){
              	$imageSizePath = str_replace("main","200x150",$val->image->filePath);
              }
              
              // replace template placeholders
              $sliderHtml .= '<li class="sliderr">
              <div><img src="'.$imageSizePath.'"></div>
              <div>'.$val->title.'</div>
              <div>'.CURRENCY.''.$val->price.'</div>
              <a class="button-default button-small maroonWhite" href="'.$viewDetailLink.'">Details</a>
              </li>';
          }
          $template_content = str_replace('$$itemPreownInvSlider$$', $sliderHtml, $template_content);
          // shortcode to html
          echo do_shortcode( $template_content );
      }else{
          echo "No record found";
      }
  ?>
  </div>
</div>
