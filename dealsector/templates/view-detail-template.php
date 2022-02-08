<div id="viewdetailresult">
<?php
    if(isset($inventoryData->data->detail)){
		$inventorysImgData = DealsectorAPI::getinventoryimages($inventoryData->data->detail->_id);
		$imageSlider='<div class="invWrapper"><div class="slider_loader_img"><img src="'.DEALSECTOR__PLUGIN_BASE_URL.'includes/images/status.gif"/></div><div class="invUnitCarouseltest">';
		if(isset($inventorysImgData->data) and count($inventorysImgData->data) > 0){
			foreach($inventorysImgData->data as $row){
				$imageMainPath = $row->filePath;
				$imageSizePath = str_replace('/main/', '/800x600/', $imageMainPath);
				$imageThumbPath = $row->fileThumbPath;
				$imageSizeThumbPath = str_replace('/main/', '/200x150/', $imageThumbPath);

				if($row->fileType == "video"){
					$imageSlider.='<div class="slider_loader_img"><img src="'.DEALSECTOR__PLUGIN_BASE_URL.'includes/images/status.gif"/></div><div class="invUnitCarousel" style="border:solid 1px black;">';
				$imageSlider.='<li data-thumb="'.$row->fileThumbPath.'"><video controls><source src="'.$row->filePath.'">Your browser does not support the video tag.</video></li>';
				$imageSlider.= '</div>';

				}
				else{
					$imageSlider.= '<li data-thumb="'.$imageSizeThumbPath.'"><img data-src="'.$imageSizePath.'" class="photo-of-gallery-x" /></li>';
				}
			}
		}else{
			$imageSlider.='<p><img class="photo-of-gallery-x" src="'.DEALSECTOR__PLUGIN_BASE_URL.'includes/images/defaultimage.jpg"/></p>';
		}
		$imageSlider.='</div></div>';
        // get template content
        $template_content = get_the_content( "", "", $template_id );
		$table_content='<table>';
		$table_content.='<tr><td width="60%"><strong style="color:#0000fe;" class="has-inline-color">SPECIFICATIONS</strong></td><td></td></tr>';
        // replace template placeholders
        if(isset($inventoryData->data->detail->subTitle) && $inventoryData->data->detail->subTitle != ""){
            	$template_content = str_replace('$$itemSubTitle$$', '<p class="itemSubTitle">'.$inventoryData->data->detail->subTitle.'</p>', $template_content);
			$table_content.='<tr><td>Subtitle</td><td class="text-right">'.$inventoryData->data->detail->subTitle.'</td></tr>';
        }else{
            $template_content = str_replace('$$itemSubTitle$$', '', $template_content);
        }
            
        if(isset($inventoryData->data->detail->overlayCaption ) && $inventoryData->data->detail->overlayCaption  != ""){
            	$template_content = str_replace('$$itemImageOverlayCaption$$', '<div class="image_overlay"><p>'.$inventoryData->data->detail->overlayCaption .'</p></div>', $template_content);
         }else{
            	$template_content = str_replace('$$itemImageOverlayCaption$$', '', $template_content);
        }
        if(isset($inventoryData->data->detail->msrp)){
            $msrp = $inventoryData->data->detail->msrp;
        }else{
            $msrp = 0;
        }
        if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != ""){
            $template_content = str_replace('$$itemBackButtonLink$$', $_SERVER['HTTP_REFERER'], $template_content);  
        }else{
            $template_content = str_replace('$$itemBackButtonLink$$', DEALSECTOR_SITE_URL, $template_content);  
        }
        if(isset($inventoryData->data->detail->image->filePath) && $inventoryData->data->detail->image->filePath != ""){
            $imageSizePath = str_replace("/main/","/800x600/",$inventoryData->data->detail->image->filePath);
			$template_content = str_replace('$$itemMainImage$$', $imageSizePath, $template_content); 
        }else{
            $template_content = str_replace('$$itemMainImage$$', DEALSECTOR__PLUGIN_BASE_URL."includes/images/defaultimage.jpg", $template_content); 
        }
        
		$itemStore='';
        if(isset($inventoryData->data->detail->store->store_name) && strlen(trim($inventoryData->data->detail->store->store_name))> 0){
            $itemStore=$inventoryData->data->detail->store->store_name;
			$table_content.='<tr><td>Store:</td><td class="text-right">'.$itemStore.'</td></tr>';
        }
        $template_content = str_replace('$$itemStore$$', $itemStore, $template_content);
		
		$itemCondition='';
        if(isset($inventoryData->data->detail->condition) && strlen(trim($inventoryData->data->detail->condition))> 0)         {
            $itemCondition=$inventoryData->data->detail->condition;
        }
        $template_content = str_replace('$$itemCondition$$', $itemCondition, $template_content);
		$template_content = str_replace('$$itemID$$', $inventoryData->data->detail->_id, $template_content);
		
        $itemGVWR='';
        if(isset($inventoryData->data->detail->gvwr) && strlen(trim($inventoryData->data->detail->gvwr))> 0){
            $itemGVWR=$inventoryData->data->detail->gvwr;
			$table_content.='<tr><td>GVWR:</td><td class="text-right">'.$itemGVWR.'</td></tr>';
        }

        $template_content = str_replace('$$itemGVWR$$', $itemGVWR, $template_content);
		
		$itemAxles='';
        if(isset($inventoryData->data->detail->axles) && strlen(trim($inventoryData->data->detail->axles))> 0){
            $itemAxles=$inventoryData->data->detail->axles;
			$table_content.='<tr><td>Axle Qty:</td><td class="text-right">'.$itemAxles.'</td></tr>';
        }

        $template_content = str_replace('$$itemAxles$$', $itemAxles, $template_content);
		$template_content = str_replace('$$itemImageSlider$$', $imageSlider, $template_content);
		
		$itemCouplerType='';
        if(isset($inventoryData->data->detail->couplerType) && strlen(trim($inventoryData->data->detail->couplerType))> 0){
            $itemCouplerType=$inventoryData->data->detail->couplerType;
			$table_content.='<tr><td>Coupler Type:</td><td class="text-right">'.$itemCouplerType.'</td></tr>';
        }
        $template_content = str_replace('$$itemCouplerType$$', $itemCouplerType, $template_content);
		
		$itemCouplerDesc='';
        if(isset($inventoryData->data->detail->couplerDescr) && strlen(trim($inventoryData->data->detail->couplerDescr))> 0){
            $itemCouplerDesc=$inventoryData->data->detail->couplerDescr;
			$table_content.='<tr><td>Coupler Spec:</td><td class="text-right">'.$itemCouplerDesc.'</td></tr>';
        }
        $template_content = str_replace('$$itemCouplerDesc$$', $itemCouplerDesc, $template_content);
		
        $itemBrakeType='';
        if(isset($inventoryData->data->detail->brakeType) && strlen(trim($inventoryData->data->detail->brakeType))> 0){
            $itemBrakeType=$inventoryData->data->detail->brakeType;
			$table_content.='<tr><td>Brake Type:</td><td class="text-right">'.$itemBrakeType.'</td></tr>';
        }
        $template_content = str_replace('$$itemBrakeType$$', $itemBrakeType, $template_content);
		
		$itemDeck='';
        if(isset($inventoryData->data->detail->deck) && strlen(trim($inventoryData->data->detail->deck))> 0){
            $itemDeck=$inventoryData->data->detail->deck;
			$table_content.='<tr><td>Deck:</td><td class="text-right">'.$itemDeck.'</td></tr>';
        }
        $template_content = str_replace('$$itemDeck$$', $itemDeck, $template_content);
		
		$itemOptions='';
        if(isset($inventoryData->data->detail->options) && strlen(trim($inventoryData->data->detail->options))> 0){
            $itemOptions=nl2br($inventoryData->data->detail->options);
			$table_content.='<tr><td>Options:</td><td class="text-right">'.$itemOptions.'</td></tr>';
        }
        $template_content = str_replace('$$itemOptions$$', $itemOptions, $template_content);
		
		$itemAxleLube='';
        if(isset($inventoryData->data->detail->axleLube) && strlen(trim($inventoryData->data->detail->axleLube))> 0){
            $itemAxleLube=$inventoryData->data->detail->axleLube;
			$table_content.='<tr><td>Axle Lubrication / Type:</td><td class="text-right">'.$itemAxleLube.'</td></tr>';
        }
        $template_content = str_replace('$$itemAxleLube$$', $itemAxleLube, $template_content);
		
		$itemDeckHeight='';
        if(isset($inventoryData->data->detail->deckHeight) && strlen(trim($inventoryData->data->detail->deckHeight))> 0){
            $itemDeckHeight=$inventoryData->data->detail->deckHeight;
			$table_content.='<tr><td>Deck Height:</td><td class="text-right">'.$itemDeckHeight.'</td></tr>';
        }
        $template_content = str_replace('$$itemDeckHeight$$', $itemDeckHeight, $template_content);
		
		$itemCategory='';
	    if(isset($inventoryData->data->detail->category[0]->label) && strlen(trim($inventoryData->data->detail->category[0]->label))> 0){
            $itemCategory=$inventoryData->data->detail->category[0]->label;
			$table_content.='<tr><td>Category:</td><td class="text-right">'.$itemCategory.'</td></tr>';
        }
        $template_content = str_replace('$$itemCategory$$', $itemCategory, $template_content);
		
		
		
		$itemSuspension='';
        if(isset($inventoryData->data->detail->suspension) && strlen(trim($inventoryData->data->detail->suspension))> 0){
            $itemSuspension=$inventoryData->data->detail->suspension;
			$table_content.='<tr><td>Suspension:</td><td class="text-right">'.$itemSuspension.'</td></tr>';
        }
        $template_content = str_replace('$$itemSuspension$$', $itemSuspension, $template_content);
		
		$itemTail='';
        if(isset($inventoryData->data->detail->tail) && strlen(trim($inventoryData->data->detail->tail))> 0){
            $itemTail=$inventoryData->data->detail->tail;
			$table_content.='<tr><td>Tail:</td><td class="text-right">'.$itemTail.'</td></tr>';
        }
        $template_content = str_replace('$$itemTail$$', $itemTail, $template_content);
		
		$itemTires='';
        if(isset($inventoryData->data->detail->tires) && strlen(trim($inventoryData->data->detail->tires))> 0){
            $itemTires=$inventoryData->data->detail->tires;
			$table_content.='<tr><td>Tires:</td><td class="text-right">'.$itemTires.'</td></tr>';
        }
        $template_content = str_replace('$$itemTires$$', $itemTires, $template_content);
		
		$itemGAWR='';
        if(isset($inventoryData->data->detail->gawr) && strlen(trim($inventoryData->data->detail->gawr))> 0){
            $itemGAWR=$inventoryData->data->detail->gawr;
			$table_content.='<tr><td>GAWR:</td><td class="text-right">'.$itemGAWR.'</td></tr>';
        }
        $template_content = str_replace('$$itemGAWR$$', $itemGAWR, $template_content);
		
		$itemRampGate='';
        if(isset($inventoryData->data->detail->rampGate) && strlen(trim($inventoryData->data->detail->rampGate))> 0){
            $itemRampGate=$inventoryData->data->detail->rampGate;
			$table_content.='<tr><td>Ramp/Gate:</td><td class="text-right">'.$itemRampGate.'</td></tr>';
        }
        $template_content = str_replace('$$itemRampGate$$', $itemRampGate, $template_content);
		
		$itemJack='';
        if(isset($inventoryData->data->detail->jacks) && strlen(trim($inventoryData->data->detail->jacks))> 0){
            $itemJack=$inventoryData->data->detail->jacks;
			$table_content.='<tr><td>Jack(s):</td><td class="text-right">'.$itemJack.'</td></tr>';
        }
        $template_content = str_replace('$$itemJack$$', $itemJack, $template_content);
		
		$itemMFRItem='';
        if(isset($inventoryData->data->detail->mfrItemNo) && strlen(trim($inventoryData->data->detail->mfrItemNo))> 0){
            $itemMFRItem=$inventoryData->data->detail->mfrItemNo;
			$table_content.='<tr><td>Mfr Item:</td><td class="text-right">'.$itemMFRItem.'</td></tr>';
        }
        $template_content = str_replace('$$itemMFRItem$$', $itemMFRItem, $template_content);
		
		$itemStatus='';
        if(isset($inventoryData->data->detail->status) && strlen(trim($inventoryData->data->detail->status))> 0){
            $itemStatus=$inventoryData->data->detail->status;
			$table_content.='<tr><td>Status:</td><td class="text-right">'.$itemStatus.'</td></tr>';
        }
        $template_content = str_replace('$$itemStatus$$', $itemStatus, $template_content); 
		
        $itemWeight='';
        if(isset($inventoryData->data->detail->weight) && strlen(trim($inventoryData->data->detail->weight))> 0){
            $itemWeight=$inventoryData->data->detail->weight;
			$table_content.='<tr><td>Weight:</td><td class="text-right">'.$itemWeight.'</td></tr>';
        }
        $template_content = str_replace('$$itemWeight$$', $itemWeight, $template_content); 
		
        $itemOutsideWallHeight='';
        if(isset($inventoryData->data->detail->wallHeightOutFtIn) && strlen(trim($inventoryData->data->detail->wallHeightOutFtIn))> 0){
            $itemOutsideWallHeight=$inventoryData->data->detail->wallHeightOutFtIn;
			$table_content.='<tr><td>OutsideWallHeight:</td><td class="text-right">'.$itemOutsideWallHeight.'</td></tr>';
        }
        $template_content = str_replace('$$itemOutsideWallHeight$$', $itemOutsideWallHeight, $template_content); 
		
		$itemInsideWallHeight='';
        if(isset($inventoryData->data->detail->wallHeightInFtIn)){
            $itemInsideWallHeight=$inventoryData->data->detail->wallHeightInFtIn;
        }
        $template_content = str_replace('$$itemInsideWallHeight$$', $itemInsideWallHeight, $template_content);
		
        $itemColor='';
        if(isset($inventoryData->data->detail->color) && strlen(trim($inventoryData->data->detail->color))> 0){
            $itemColor=$inventoryData->data->detail->color;
			$table_content.='<tr><td>Color:</td><td class="text-right">'.$itemColor.'</td></tr>';
        }
        $template_content = str_replace('$$itemColor$$', $itemColor, $template_content);

        $itemWidth='';
        if(isset($inventoryData->data->detail->width) && strlen(trim($inventoryData->data->detail->width)) >0){
            $itemWidth=$inventoryData->data->detail->width.'"';
            $table_content.='<tr><td>Width</td><td class="text-right">'.$itemWidth.'</td></tr>';
        }

        $template_content = str_replace('$$itemWidth$$', $itemWidth, $template_content);
		
		$itemWidthFtIn='';
        if(isset($inventoryData->data->detail->widthFtIn) && strlen(trim($inventoryData->data->detail->widthFtIn)) >0){
            $itemWidthFtIn=$inventoryData->data->detail->widthFtIn;
            $table_content.='<tr><td>WidthFtIn:</td><td class="text-right">'.$itemWidthFtIn.'</td></tr>';
        }
        $template_content = str_replace('$$itemWidthFtIn$$', $itemWidthFtIn, $template_content);


        $itemLengthFtIn='';
        if(isset($inventoryData->data->detail->lengthFtIn) && strlen(trim($inventoryData->data->detail->lengthFtIn)) >0){
            $itemLengthFtIn=$inventoryData->data->detail->lengthFtIn;
            $table_content.='<tr><td>LengthFtIn</td><td class="text-right">'.$itemLengthFtIn.'</td></tr>';
        }

        $template_content = str_replace('$$itemLengthFtIn$$', $itemLengthFtIn, $template_content);
		
        $premiumF = "";
		if(isset($inventoryData->data->detail->premiumFeatures) && strlen(trim($inventoryData->data->detail->premiumFeatures)) >0){
            	$premiumF = $inventoryData->data->detail->premiumFeatures;
				$premiumF = preg_replace("/\r\n|\r|\n/", '<br/>', $premiumF);
			$table_content.='<tr><td>Premium Features:</td><td class="text-right">'.$premiumF.'</td></tr>';
		}
		
        $template_content = str_replace('$$itemPremiumFeature$$', $premiumF, $template_content);
        
		$itemPrice='';
        if(isset($inventoryData->data->detail->price) && strlen(trim($inventoryData->data->detail->price)) >0){
            $itemPrice=CURRENCY.$inventoryData->data->detail->price;
			$table_content.='<tr><td>Price:</td><td class="text-right">'.$itemPrice.'</td></tr>';
        }
		$template_content = str_replace('$$itemPrice$$', $itemPrice, $template_content);
		
		$itemModelYear='';
        if(isset($inventoryData->data->detail->modelYear) && strlen(trim($inventoryData->data->detail->modelYear)) >0){
            $itemModelYear=$inventoryData->data->detail->modelYear;
			$table_content.='<tr><td>Year:</td><td class="text-right">'.$itemModelYear.'</td></tr>';
        }
		$template_content = str_replace('$$itemModelYear$$', $itemModelYear, $template_content);
		
		
		$itemModel='';
        if(isset($inventoryData->data->detail->vehicleModel->label) && strlen(trim($inventoryData->data->detail->vehicleModel->label)) >0){
            $itemModel=$inventoryData->data->detail->vehicleModel->label;
			$table_content.='<tr><td>Model:</td><td class="text-right">'.$itemModel.'</td></tr>';
        }
		$template_content = str_replace('$$itemModel$$', $itemModel, $template_content);
		
		$itemisVisible='';
		if(isset($inventoryData->data->detail->isVisible) && strlen(trim($inventoryData->data->detail->isVisible))> 0){
			$itemIsVisible=$inventoryData->data->detail->isVisible;
			//$table_content.='<tr><td>IsVisible:</td><td class="text-right">'.$itemIsVisible.'</td></tr>';
		}
		$template_content = str_replace('$$itemIsVisible$$', $itemIsVisible, $template_content);

		$itemVin='';
		if(isset($inventoryData->data->detail->vin) && strlen(trim($inventoryData->data->detail->vin))> 0){
			$itemVin=$inventoryData->data->detail->vin;
			//$table_content.='<tr><td>Vin:</td><td class="text-right">'.$itemVin.'</td></tr>';
		}
		$template_content = str_replace('$$itemVin$$', $itemVin, $template_content);
		
		$itemCrossmembers='';
		if(isset($inventoryData->data->detail->crossmembers) && strlen(trim($inventoryData->data->detail->crossmembers))> 0){
			$itemCrossmembers=$inventoryData->data->detail->crossmembers;
			//$table_content.='<tr><td>Cross Members:</td><td class="text-right">'.$itemCrossmembers.'</td></tr>';
		}
		$template_content = str_replace('$$itemCrossmembers$$', $itemCrossmembers, $template_content);



		$itemDetailitle='';
		if(isset($inventoryData->data->detail->detailtitle) && strlen(trim($inventoryData->data->detail->detailtitle))> 0){
			$itemDetailitle=$inventoryData->data->detail->detailtitle;
			//$table_content.='<tr><td>Detail Title:</td><td class="text-right">'.$itemDetailitle.'</td></tr>';
		}
		$template_content = str_replace('$$itemDetailitle$$', $itemDetailitle, $template_content);


		$itemWallHeight='';
        if(isset($inventoryData->data->detail->wallHeight) && strlen(trim($inventoryData->data->detail->wallHeight))> 0){
            $itemWallHeight=$inventoryData->data->detail->wallHeight;
            //$table_content.='<tr><td>WallHeight:</td><td class="text-right">'.$itemWallHeightNew.'</td></tr>';
        }
        $template_content = str_replace('$$itemWallHeight$$', $itemWallHeight, $template_content);
		
		$itemDealerId='';
		if(isset($inventoryData->data->detail->dealerId) && strlen(trim($inventoryData->data->detail->dealerId))> 0){
			$itemDealerId=$inventoryData->data->detail->dealerId;
			//$table_content.='<tr><td>Dealer Id:</td><td class="text-right">'.$itemDealerId.'</td></tr>';
		}
		$template_content = str_replace('$$itemDealerId$$', $itemDealerId, $template_content);

		$itemTitleSlug='';
		if(isset($inventoryData->data->detail->titleslug) && strlen(trim($inventoryData->data->detail->titleslug))> 0){
			$itemTitleSlug=$inventoryData->data->detail->titleslug;
			//$table_content.='<tr><td>Title Slug:</td><td class="text-right">'.$itemTitleSlug.'</td></tr>';
		}
		$template_content = str_replace('$$itemTitleSlug$$', $itemTitleSlug, $template_content);


		$itemIsFeatured='';
		if(isset($inventoryData->data->detail->isFeatured) && strlen(trim($inventoryData->data->detail->isFeatured))> 0){
			$itemIsFeatured=$inventoryData->data->detail->isFeatured;
			//$table_content.='<tr><td>Is Featured:</td><td class="text-right">'.$itemIsFeatured.'</td></tr>';
		}
		$template_content = str_replace('$$itemIsFeatured$$', $itemIsFeatured, $template_content);

		$itemAxleMake='';
		if(isset($inventoryData->data->detail->axleMake) && strlen(trim($inventoryData->data->detail->axleMake))> 0){
			$itemAxleMake=$inventoryData->data->detail->axleMake;
			//$table_content.='<tr><td>Axle Make:</td><td class="text-right">'.$itemAxleMake.'</td></tr>';
		}
		$template_content = str_replace('$$itemAxleMake$$', $itemAxleMake, $template_content);


		$itemPurchaseCost='';
		if(isset($inventoryData->data->detail->purchaseCost) && strlen(trim($inventoryData->data->detail->purchaseCost))> 0){
			$itemPurchaseCost=$inventoryData->data->detail->purchaseCost;
			//$table_content.='<tr><td>Purchase Cost:</td><td class="text-right">'.$itemPurchaseCost.'</td></tr>';
		}
		$template_content = str_replace('$$itemPurchaseCost$$', $itemPurchaseCost, $template_content);
		
		$itemWheels='';
		if(isset($inventoryData->data->detail->wheels) && strlen(trim($inventoryData->data->detail->wheels))> 0){
			$itemWheels=$inventoryData->data->detail->wheels;
			//$table_content.='<tr><td>Wheels:</td><td class="text-right">'.$itemWheels.'</td></tr>';
		}
		$template_content = str_replace('$$itemWheels$$', $itemWheels, $template_content);

		$itemDeckHeightFtIn='';
		if(isset($inventoryData->data->detail->deckHeightFtIn) && strlen(trim($inventoryData->data->detail->deckHeightFtIn))> 0){
			$itemDeckHeightFtIn=$inventoryData->data->detail->deckHeightFtIn;
			//$table_content.='<tr><td>Deck Height FtIn:</td><td class="text-right">'.$itemDeckHeightFtIn.'</td></tr>';
		}
		$template_content = str_replace('$$itemDeckHeightFtIn$$', $itemDeckHeightFtIn, $template_content);

		$itemProductInfo='';
		if(isset($inventoryData->data->detail->productInfo) && strlen(trim($inventoryData->data->detail->productInfo))> 0){
			$itemProductInfo=$inventoryData->data->detail->productInfo;
			//$table_content.='<tr><td>Product Info:</td><td class="text-right">'.$itemProductInfo.'</td></tr>';
		}
		$template_content = str_replace('$$itemProductInfo$$', $itemProductInfo, $template_content);
		
		/*$itemWidthNew='';
		if(isset($inventoryData->data->detail->width) && strlen($inventoryData->data->detail->width)> 0){
			$itemWidthNew=$inventoryData->data->detail->width;
			$table_content.='<tr><td>Width:</td><td class="text-right">'.$itemWidthNew.'</td></tr>';
		}
		$template_content = str_replace('$$itemWidthNew$$', $itemWidthNew, $template_content);*/

        $itemLength='';
        if(isset($inventoryData->data->detail->length) && strlen(trim($inventoryData->data->detail->length))> 0){
            $itemLength=$inventoryData->data->detail->length;
            //$table_content.='<tr><td>Length:</td><td class="text-right">'.$itemLengthNew.'</td></tr>';
        }
        $template_content = str_replace('$$itemLength$$', $itemLength, $template_content);
		
		$itemType='';
		if(isset($inventoryData->data->detail->type) && strlen(trim($inventoryData->data->detail->type))> 0){
			$itemType=$inventoryData->data->detail->type;
			//$table_content.='<tr><td>Type:</td><td class="text-right">'.$itemType.'</td></tr>';
		}
		$template_content = str_replace('$$itemType$$', $itemType, $template_content);

		$itemMake='';
        if(isset($inventoryData->data->detail->vehicleMake->label) && strlen(trim($inventoryData->data->detail->vehicleMake->label)) >0){
            $itemMake=$inventoryData->data->detail->vehicleMake->label;
			$table_content.='<tr><td>Manufacturer:</td><td class="text-right">'.$itemMake.'</td></tr>';
        }
		$template_content = str_replace('$$itemMake$$', $itemMake, $template_content);
        
        $template_content = str_replace('$$itemTitle$$', $inventoryData->data->detail->title, $template_content);
		
		if(isset($inventoryData->data->detail->stockNo) && strlen(trim($inventoryData->data->detail->stockNo))> 0){
            $table_content.='<tr><td>Stock No:</td><td class="text-right">'.$inventoryData->data->detail->stockNo.'</td></tr>';
        }
        $template_content = str_replace('$$itemStock$$', $inventoryData->data->detail->stockNo, $template_content);
        $viewDetailLink = get_permalink(get_page_by_path( 'view-detail-page' ))."?id=".$inventoryData->data->detail->_id;
        $template_content = str_replace('$$itemViewDetailLink$$', $viewDetailLink, $template_content);
		
		$itemURL='<a href="'.$viewDetailLink.'">'.$viewDetailLink.'</a>';
   		$template_content = str_replace('$$itemURL$$', $itemURL, $template_content);
		
        if($inventoryData->data->detail->price > 0){
				$template_content = str_replace('$$itemCashPrice$$', 'Cash/Check Price '.CURRENCY.''.$inventoryData->data->detail->price, $template_content);
			}else{ 
				$getQuote = '<a class="getQuoteModalBtnClass fusion-modal-text-link" data-toggle="modal" data-stockno="'.$inventoryData->data->detail->stockNo.'" data-viewdetail="'.$viewDetailLink.'" data-target=".fusion-modal.getQuoteModalClass">Get A Quote</a>';
				$template_content = str_replace('$$itemCashPrice$$', $getQuote, $template_content);
			} 
        if($inventoryData->data->detail->msrp > 0){
        	$template_content = str_replace('$$itemMSRP$$', 'MSRP  '.CURRENCY.''.$inventoryData->data->detail->msrp, $template_content);
			$table_content.='<tr><td>MSRP:</td><td class="text-right">'.$inventoryData->data->detail->msrp.'</td></tr>';
        }else{
        	$template_content = str_replace('$$itemMSRP$$', '', $template_content);
        }
        $table_content.='</table>'; 
		$template_content = str_replace('$$table_content$$', $table_content, $template_content);

        $finance_loc='';
        if(isset($cookie_location) && strlen(trim($cookie_location))>0){
            $finance_loc='&location='.$cookie_location;
        }
	    $financeLink = FINANCE_LINK.'?token='.$inventoryData->data->detail->finance.$finance_loc;
		$template_content = str_replace('$$itemFinancingLink$$', $financeLink, $template_content);
		
        // shortcode to html
        echo do_shortcode( $template_content ); 
    }else{
        echo "No record found";
    }
?>
</div>
