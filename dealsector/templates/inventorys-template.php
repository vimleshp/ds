<!-- Image loader -->
<style type="text/css">
    .image_overlay{display:none;}
</style>
<div class="loader" id='list_loader'>
  <img src='<?php echo DEALSECTOR__PLUGIN_BASE_URL."includes/images/giphy.gif"; ?>' width='250px' height='250px'>
</div>
<?php  echo '<div id="template_id" style="display:none;">'.$template_id.'</div>';?>
<!-- Image loader -->
 <?php $temp_trailer_type=$trailer_type;?>
<div id="showresults">
    
<?php
    if(isset($_POST['template_id'])){
        $template_id=$_POST['template_id'];
    }
    
    if( isset($inventorysList->data->recordtotal) && $inventorysList->data->recordtotal > 0 ){
        $recordArr = $inventorysList->data->records;
      	echo '<div id="record_total" style="display:none;">'.$inventorysList->data->recordtotal.'</div>';
        foreach($recordArr as $key => $value){
			$inventorysData = DealsectorAPI::getinventoryimages($value->_id);
            if(isset($inventorysData->data) and count($inventorysData->data) >0){
            	$imageSlideCount=1;
                 $imageSlider='<div class="slider_loader_img"><img src="'.DEALSECTOR__PLUGIN_BASE_URL.'includes/images/status.gif"/></div><div class="invUnitCarouseltest">';
                foreach($inventorysData->data as $row){
                        $imageMainPath = $row->filePath;
	                    $imageSizePath = str_replace('/main/', '/600x450/', $imageMainPath);
	                    $imageThumbPath = $row->fileThumbPath;
	                    $imageSizeThumbPath = str_replace('/main/', '/200x150/', $imageThumbPath);
	                  
	                    if($row->fileType == "video"){
	                        $imageSlider.='<div class="invUnitCarousel" style="border:solid 1px black;">';
	                    $imageSlider.='<li data-thumb="'.$row->fileThumbPath.'"><video controls><source src="'.$row->filePath.'">Your browser does not support the video tag.</video></li>';
	                    $imageSlider.= '</div>';
	                                    
	                    }
	                    else{
	                    	if($imageSlideCount<=10){
		                        $imageSlider.= '<li data-thumb="'.$imageSizeThumbPath.'"><img data-src="'.$imageSizePath.'" class="photo-of-gallery-x" /></li>';
		                    }
	                    }
	                    $imageSlideCount++;
	            	
                }
                $imageSlider.='</div>';
            }
            else
            {
                $imageSlider='<p><img class="photo-of-gallery-x" src="'.DEALSECTOR__PLUGIN_BASE_URL.'includes/images/defaultimage.jpg"/></p>';
            }
            
            $viewDetailLink = get_permalink(get_page_by_path( 'view-detail-page' ))."?id=".$value->_id;
            // get template content
            $template_content = get_the_content( "", "", $template_id ); 
            $table_content='<table>';
             $template_content = str_replace('$$itemViewDetailLink$$', $viewDetailLink, $template_content);
            // replace template placeholders
            if(isset($value->overlayCaption) && $value->overlayCaption != ""){
            	$template_content = str_replace('$$itemImageOverlayCaption$$', '<div class="image_overlay"><p>'.$value->overlayCaption.'</p></div>', $template_content);
            }else{
            	$template_content = str_replace('$$itemImageOverlayCaption$$', '', $template_content);
            }
            
            
            if(isset($value->image->filePath) && $value->image->filePath != "" && $value->image->fileType == "image"){
			$imageSizePath = str_replace("/main/","/600x450/",$value->image->filePath);
            $template_content = str_replace('$$itemMainImage$$', $imageSizePath, $template_content); 
            }else{
                $template_content = str_replace('$$itemMainImage$$', DEALSECTOR__PLUGIN_BASE_URL."includes/images/defaultimage.jpg", $template_content); 
            }
			$itemMakelogo = '';
            if(isset($value->vehicleMakeLogo) && strlen( trim($value->vehicleMakeLogo) ) > 0){
				$itemMakelogo = '<img class="img-responsive" style="max-width: 90px;" src="'.trim($value->vehicleMakeLogo).'">';
                $template_content = str_replace('$$itemLogo$$', $itemMakelogo, $template_content); 
            }
			$template_content = str_replace('$$itemLogo$$', $itemMakelogo , $template_content); 
			
			if(isset($value->stockNo) && strlen(trim($value->stockNo))>0){
				$table_content.='<tr><th>Stock No:</th><td class="text-right">'.$value->stockNo.'</td></tr>';
			}
			
			$itemPrice="";
		    if(isset($value->price) && strlen(trim($value->price))>0){
                $itemPrice=CURRENCY.$value->price;
				$table_content.='<tr><th>Price:</th><td class="text-right">'.$itemPrice.'</td></tr>';
            }
			$template_content = str_replace('$$itemActualPrice$$', $itemPrice, $template_content);
			
			$itemGVWR="";
            if(isset($value->gvwr) && $value->gvwr != "" && $value->gvwr != 0){
                $itemGVWR=$value->gvwr;
				$table_content.='<tr><td>GVWR:</td><td class="text-right">'.$itemGVWR.'</td></tr>';
            }
			$template_content = str_replace('$$itemGVWR$$', $itemGVWR, $template_content);
			
			$itemAxles='';
            if(isset($value->axles) && strlen(trim($value->axles))>0 && $temp_trailer_type!=4){
                $itemAxles=$value->axles;
                $table_content.='<tr><td>Axles:</td><td class="text-right">'.$itemAxles.'</td></tr>';
            }
            $template_content = str_replace('$$itemAxles$$', $itemAxles, $template_content);
			
			$itemGAWR='';
            if(isset($value->gawr) && strlen(trim($value->gawr))>0 && $temp_trailer_type!=4){
                $itemGAWR=$value->gawr;
                $table_content.='<tr><td>GAWR:</td><td class="text-right">'.$itemGAWR.'</td></tr>';
            }
            $template_content = str_replace('$$itemGAWR$$', $itemGAWR, $template_content);
			
			$condition="";
            if(isset($value->condition) && strlen(trim($value->condition))>0){
                $condition=$value->condition;
				$table_content.='<tr><th>Condition:</th><td class="text-right">'.$condition.'</td></tr>';
            }
			
			$itemOptions='';
      		$template_content = str_replace('$$itemOptions$$', $itemOptions, $template_content);
			
			
			$itemColor='';
            if(isset($value->color) && strlen(trim($value->color)) >0){
                $itemColor=$value->color;
				$table_content.='<tr><th>Color:</th><td class="text-right">'.$itemColor.'</td></tr>';
            }
	        $template_content = str_replace('$$itemColor$$', $itemColor, $template_content);
			
			$itemModelYear='';
            if(isset($value->modelYear) && strlen(trim($value->modelYear)) >0){
                $itemModelYear=$value->modelYear;
				$table_content.='<tr><th>Year:</th><td class="text-right">'.$itemModelYear.'</td></tr>';
            }
	        $template_content = str_replace('$$itemModelYear$$', $itemModelYear, $template_content);
			
			$itemMake='';
            if(isset($value->vehicleMake->label) && strlen(trim($value->vehicleMake->label))>0){
                $itemMake = $value->vehicleMake->label;
				$table_content.='<tr><th>Manufacturer:</th><td class="text-right">'.$itemMake.'</td></tr>';
            }
	        $template_content = str_replace('$$itemMake$$', $itemMake, $template_content);
			
			
			
			$itemModel='';
            if(isset($value->vehicleModel->label) && strlen(trim($value->vehicleModel->label))>0){
                $itemModel=$value->vehicleModel->label;
				$table_content.='<tr><th>Model:</th><td class="text-right">'.$itemModel.'</td></tr>';
            }
	        $template_content = str_replace('$$itemModel$$', $itemModel, $template_content);
			
			$itemType='';
            if(isset($value->type->label) && strlen(trim($value->type->label))>0){
                $itemType=$value->type->label;
				$table_content.='<tr><th>Type:</th><td class="text-right">'.$itemType.'</td></tr>';
            }
	        $template_content = str_replace('$$itemType$$', $itemType, $template_content);
			
            
			$template_content = str_replace('$$itemImageSlider$$', $imageSlider, $template_content);


            $itemLength='';
		    if(isset($value->lengthFtIn) && strlen(trim($value->lengthFtIn))>0){
                $itemLength=$value->lengthFtIn;
				$table_content.='<tr><th>Floor Length:</th><td class="text-right">'.$itemLength.'</td></tr>';
            }

            $template_content = str_replace('$$itemLength$$', $itemLength, $template_content);
			
			$itemWidth='';
            if(isset($value->width) && $value->width>0){
                $itemWidth=$value->width;
                $table_content.='<tr><td>Width</td><td>'.$itemWidth.'</td></tr>';
            }
            $template_content = str_replace('$$itemWidth$$', $itemWidth, $template_content);


            $itemWidthFtIn='';
            if(isset($value->widthFtIn) && strlen(trim($value->widthFtIn)) >0 && $value->widthFtIn>0){
                $itemWidthFtIn=$value->widthFtIn;
                 $table_content.='<tr><th>Width:</th><td class="text-right">'.$itemWidthFtIn.'</td></tr>';
            }
            $template_content = str_replace('$$itemWidthFtIn$$', $itemWidthFtIn, $template_content);
	
            $itemHeight='';
            if(isset($value->wallHeightInFtIn) && strlen(trim($value->wallHeightInFtIn))>0){
                $itemHeight=$value->wallHeightInFtIn;
                $table_content.='<tr><td>Height</td><td>'.$itemHeight.'</td></tr>';
            }

            $template_content = str_replace('$$itemSize$$', $itemHeight, $template_content);
			
			$itemWallHeightIn='';
            if(isset($value->wallHeightIn) && strlen(trim($value->wallHeightIn))>0){
                $itemWallHeightIn=$value->wallHeightIn;
                $table_content.='<tr><td>Wall Height In</td><td>'.$itemWallHeightIn.'</td></tr>';
            }
            $template_content = str_replace('$$itemWallHeightIn$$', $itemWallHeightIn, $template_content);
            
            $itemWallHeightOut='';
            if(isset($value->wallHeightOutFtIn) && strlen(trim($value->wallHeightOutFtIn))>0){
                $itemWallHeightOut=$value->wallHeightOutFtIn;
                $table_content.='<tr><td>Wall Height Out</td><td>'.$itemWallHeightOut.'</td></tr>';
            }
            $template_content = str_replace('$$itemWallHeightOut$$', $itemWallHeightOut, $template_content);
			
            $itemtail='';
			if(isset($value->tail) && strlen(trim($value->tail))>0){
				$itemtail=$value->tail;
				$table_content.='<tr><th>Tail:</th><td class="text-right">'.$itemtail.'</td></tr>';
			}
			$template_content = str_replace('$$itemTail$$', $itemtail, $template_content);

			$itemGallerytitle='';
			if(isset($value->gallerytitle) && strlen(trim($value->gallerytitle))>0){
				$itemGallerytitle=$value->gallerytitle;
				$table_content.='<tr><th>Gallery Title:</th><td class="text-right">'.$itemGallerytitle.'</td></tr>';
			}
			$template_content = str_replace('$$itemGalleryTitle$$', $itemGallerytitle, $template_content);

			$itemStatus='';
			if(isset($value->status) && strlen(trim($value->status))>0){
				$itemStatus=$value->status;
				$table_content.='<tr><th>Status:</th><td class="text-right">'.$itemStatus.'</td></tr>';
			}
			$template_content = str_replace('$$itemStatus$$', $itemStatus, $template_content);
			
			$itemDetailTitle='';
			if(isset($value->detailtitle) && strlen(trim($value->detailtitle))>0){
				$itemDetailTitle=$value->detailtitle;
				$table_content.='<tr><th>Detail Title:</th><td class="text-right">'.$itemDetailTitle.'</td></tr>';
			}
			$template_content = str_replace('$$itemDetailTitle$$', $itemDetailTitle, $template_content);
			
			$itemLengthOld='';
			if(isset($value->length) && strlen(trim($value->length))>0){
				$itemLengthOld=$value->length;
				$table_content.='<tr><th>Length:</th><td class="text-right">'.$itemLengthOld.'</td></tr>';
			}
			$template_content = str_replace('$$itemLengthOld$$', $itemLengthOld, $template_content);
			
			$itemTitleSlug='';
			if(isset($value->titleslug) && strlen(trim($value->titleslug))>0){
				$itemTitleSlug=$value->titleslug;
				$table_content.='<tr><th>Slug:</th><td class="text-right">'.$itemTitleSlug.'</td></tr>';
			}
			$template_content = str_replace('$$itemTitleSlug$$', $itemTitleSlug, $template_content);
			
			$itemIsFeatured='';
			if(isset($value->isFeatured) && strlen(trim($value->isFeatured))>0){
				$itemIsFeatured=$value->isFeatured;
				$table_content.='<tr><th>isFeatured:</th><td class="text-right">'.$itemIsFeatured.'</td></tr>';
			}
			$template_content = str_replace('$$itemIsFeatured$$', $itemIsFeatured, $template_content);
			
			$itemMsrpNew='';
			if(isset($value->msrp) && strlen(trim($value->msrp))>0){
				$itemMsrpNew=$value->msrp;
				$table_content.='<tr><th>MSRP:</th><td class="text-right">'.$itemMsrpNew.'</td></tr>';
			}
			$template_content = str_replace('$$itemMSRPNew$$', $itemMsrpNew, $template_content);
			
			$itemPremiumFeatures='';
			if(isset($value->premiumFeatures) && strlen(trim($value->premiumFeatures))>0){
				$itemPremiumFeatures=$value->premiumFeatures;
				$table_content.='<tr><th>Premium Features:</th><td class="text-right">'.$itemPremiumFeatures.'</td></tr>';
			}
			$template_content = str_replace('$$itemPremiumFeatures$$', $itemPremiumFeatures, $template_content);
			
			$itemStatusInStock='';
			if(isset($value->statusInStock) && strlen(trim($value->statusInStock))>0){
				$itemStatusInStock=$value->statusInStock;
				$table_content.='<tr><th>Status In Stock:</th><td class="text-right">'.$itemStatusInStock.'</td></tr>';
			}
			$template_content = str_replace('$$itemStatusInStock$$', $itemStatusInStock, $template_content);
			
			/*$itemWidthOld='';
			if(isset($value->width) && strlen($value->width)>0){
				$itemWidthOld=$value->width;
				$table_content.='<tr><th>Width:</th><td class="text-right">'.$itemWidthOld.'</td></tr>';
			}
			$template_content = str_replace('$$itemWidthOld$$', $itemWidthOld, $template_content);*/
			
			$itemSizeNew='';
			if(isset($value->size) && strlen(trim($value->size))>0){
				$itemSizeNew=$value->size;
				$table_content.='<tr><th>Size:</th><td class="text-right">'.$itemSizeNew.'</td></tr>';
			}
			$template_content = str_replace('$$itemSizeNew$$', $itemSizeNew, $template_content);
			
			$location = "";
            if(isset($value->store->store_name) && strlen(trim($value->store->store_name))>0){
                $location = $value->store->store_name;
                $table_content.='<tr><td>Store Name</td><td>'.$location.'</td></tr>';
            }

            $premiumF = "";
          
            if(isset($value->premiumFeatures) && strlen(trim($value->premiumFeatures))>0){
            	$premiumF = $value->premiumFeatures;
                $premiumF = preg_replace("/\r\n|\r|\n/", '<br/>', $premiumF);
                $table_content.='<tr><td>Premium Features</td><td>'.$premiumF.'</td></tr>';
            }
			
			
			
            $template_content = str_replace('$$itemCondition$$', $condition, $template_content);
			$template_content = str_replace('$$itemPremiumFeature$$', $premiumF, $template_content); 
            $template_content = str_replace('$$itemID$$', $value->_id, $template_content); 
            $template_content = str_replace('$$itemTitle$$', $value->title, $template_content);  
            if(isset($value->subTitle) && $value->subTitle != ""){
            	$template_content = str_replace('$$itemSubTitle$$', '<div class="itemSubTitle">'.$value->subTitle.'</div>', $template_content);
            }else{
            $template_content = str_replace('$$itemSubTitle$$', '', $template_content);
            }
			
            $template_content = str_replace('$$itemstockno$$', $value->stockNo, $template_content);
            $template_content = str_replace('$$itemLocation$$', $location, $template_content);
            
            $itemListHtml = "";
            if(isset($value->condition) && $value->condition != ""){
                $itemListHtml .= '<li class="unit_condition"><span class="unitLabel">Condition :</span><span class="unitValue">'.$value->condition.'</span></li>';
            }
            if(isset($value->type->label) && $value->type->label != ""){
                $itemListHtml .= '<li class="unit_type"><span class="unitLabel">Type :</span><span class="unitValue">'.$value->type->label.'</span></li>';
            }
            if(isset($value->axles) && $value->axles != "" && $value->axles != 0){
                $itemListHtml .= '<li><span class="unitLabel">Axles :</span><span class="unitValue">'.$value->axles.' - '.$value->gawr.' lb</span></li>';
            }
            if(isset($value->gvwr) && $value->gvwr != "" && $value->gvwr != 0){
                $itemListHtml .= '<li><span class="unitLabel">GVWR :</span><span class="unitValue">'.$value->gvwr.' lb</span></li>';
            }
            if(isset($location) && $location != ""){
                $itemListHtml .= '<li class="unit_location"><span class="unitLabel">Location :</span><span class="unitValue">'.$location.'</span></li>';
            }
            if(isset($value->size) && $value->size != "" && $value->size != 0){
                $itemListHtml .= '<li><span class="unitLabel">Size :</span><span class="unitValue">'.$value->size.'</span></li>';
            }
            if(isset($value->tail) && $value->tail != "" && $value->tail != 0){
                $itemListHtml .= '<li><span class="unitLabel">Tail :</span><span class="unitValue">'.$value->tail.'</span></li>';
            }
            $template_content = str_replace('$$itemList$$', $itemListHtml, $template_content);
            
			if($value->price > 0){
				$template_content = str_replace('$$itemPrice$$', '<label>Cash/Check Price</label><span>'.CURRENCY.''.$value->price.'</span>', $template_content);
			}else{
                
				$getQuote = '<a class="getQuoteModalBtnClass fusion-modal-text-link" data-toggle="modal" data-stockno="'.$value->stockNo.'" data-viewdetail="'.$viewDetailLink.'" data-target=".fusion-modal.getQuoteModalClass">Get A Quote</a>';
				$template_content = str_replace('$$itemPrice$$', $getQuote, $template_content);
			}  
            if($value->msrp > 0){
            $template_content = str_replace('$$itemMsrp$$', '<label>MSRP</label><span>'.CURRENCY.''.$value->msrp.'</span>', $template_content); 
            }else{
            	$template_content = str_replace('$$itemMsrp$$', '', $template_content); 
            }
            $table_content.='</table>';
        	$template_content = str_replace('$$table_content$$', $table_content, $template_content);
            $template_content = str_replace('$$itemDetailLink$$', $viewDetailLink, $template_content); 
            
            $finance_loc='';
            if(isset($cookie_location) && strlen(trim($cookie_location))>0){
                $finance_loc='&location='.$cookie_location;
            }
            $financeLink = FINANCE_LINK.'?token='.$value->finance.$finance_loc;
			$template_content = str_replace('$$itemFinancingLink$$', $financeLink, $template_content);
			
            // shortcode to html
            echo do_shortcode( urldecode($template_content) ); 
        }
    }else{
        echo "No record found";
    }


?>
</div>
