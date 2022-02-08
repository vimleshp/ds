jQuery( function ( $ ) {
    dealsectorAjaxUrl = dealsector_settings['dealsectorAjaxUrl'];
	dealsectorPluginBaseUrl = dealsector_settings['dealsectorPluginBaseUrl'];
	
	function getUrlParameter(sParam) {
		var sPageURL = window.location.search.substring(1),
			sURLVariables = sPageURL.split('&'),
			sParameterName,
			i;

		for (i = 0; i < sURLVariables.length; i++) {
			sParameterName = sURLVariables[i].split('=');

			if (sParameterName[0] === sParam) {
				return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
			}
		}
	};

	$(function() {
    	$('.photo-gallery-viewdetail').html("");
		$('.invUnitCarousel').html("");
        $(".lSGallery").html("");
		if(getUrlParameter("id") != "" && getUrlParameter("id") != undefined){
            $.ajax({
                type:"POST",
                url: dealsectorAjaxUrl,
                data:{
                    "action": 'dealsector_inventory',
                    "inventory":getUrlParameter("id")
                },beforeSend: function(){
                    $("#loader").show(1000);
                },success:function(response){
		            var response = JSON.parse(response);
					var responseData = response.data.detail;
				  	var html = '<tbody>';
					
					if(responseData.productInfo != undefined && responseData.productInfo != ""){
						$('#itemProductInfo').html('<p>'+responseData.productInfo+'</p>');
					}else{
						$('#itemProductInfo').html('<p>No product information found!!</p>');
					}
					if(responseData.gvwr != undefined && responseData.gvwr != ""){
						html += '<tr><td align="left">GVWR</td><td align="right">'+responseData.gvwr+' lb</td></tr>';					
					}
					if(responseData.vehicleModel!=undefined && responseData.vehicleModel.label != undefined && responseData.vehicleModel.label != ""){
						html += '<tr><td align="left">Model</td><td align="right">'+responseData.vehicleModel.label+'</td></tr>';					
					}
					if(responseData.mfrItemNo != undefined && responseData.mfrItemNo != ""){
						html += '<tr><td align="left">Model Code</td><td align="right">'+responseData.mfrItemNo+'</td></tr>';					
					}
                    if(responseData.type != undefined && responseData.type != ""){
						html += '<tr><td align="left">Type</td><td align="right">'+responseData.type+'</td></tr>';					
					}
					if(responseData.modelYear != undefined && responseData.modelYear != ""){
						html += '<tr><td align="left">Model Year</td><td align="right">'+responseData.modelYear+'</td></tr>';					
					}
					if(responseData.couplerType != undefined && responseData.couplerType != ""){
						html += '<tr><td align="left">Coupler Type</td><td align="right">'+responseData.couplerType+'</td></tr>';					
					}
                    if(responseData.couplerDescr != undefined && responseData.couplerDescr != ""){
						html += '<tr><td align="left">Coupler Description</td><td align="right">'+responseData.couplerDescr+'</td></tr>';					
					}
					if(responseData.axles != undefined && responseData.axles != "" && responseData.axles != 0){
						html += '<tr><td align="left">Axles</td><td align="right">'+responseData.axles+' - '+responseData.gawr +' lb</td></tr>';					
					}
					if(responseData.axleMake != undefined && responseData.axleMake != ""){
						html += '<tr><td align="left">Axles Make</td><td align="right">'+responseData.axleMake+'</td></tr>';					
					}
					if(responseData.axleLube != undefined && responseData.axleLube != ""){
						html += '<tr><td align="left">Axles Type</td><td align="right">'+responseData.axleLube+'</td></tr>';					
					}
					if(responseData.brakeType != undefined && responseData.brakeType != ""){
						html += '<tr><td align="left">Brakes</td><td align="right">'+responseData.brakeType+'</td></tr>';					
					}
					if(responseData.suspension != undefined && responseData.suspension != ""){
						html += '<tr><td align="left">Suspension</td><td align="right">'+responseData.suspension+'</td></tr>';					
					}
					if(responseData.tires != undefined && responseData.tires != ""){
						html += '<tr><td align="left">Tires</td><td align="right">'+responseData.tires+'</td></tr>';					
					}
					if(responseData.rampGate != undefined && responseData.rampGate != ""){
						html += '<tr><td align="left">Ramp Gate</td><td align="right">'+responseData.rampGate+'</td></tr>';					
					}
					if(responseData.deck != undefined && responseData.deck != ""){
						html += '<tr><td align="left">Deck</td><td align="right">'+responseData.deck+'</td></tr>';					
					}
                    if(responseData.deckHeight != undefined && responseData.deckHeight != ""){
						html += '<tr><td align="left">Deck Height</td><td align="right">'+responseData.deckHeight+'</td></tr>';					
					}
					if(responseData.tail != undefined && responseData.tail != ""){
						html += '<tr><td align="left">Tail</td><td align="right">'+responseData.tail+'</td></tr>';					

					}
					if(responseData.jacks != undefined && responseData.jacks != ""){
						html += '<tr><td align="left">Jacks</td><td align="right">'+responseData.jacks+'</td></tr>';					
					}
					if(responseData.crossmembers != undefined && responseData.crossmembers != ""){
						html += '<tr><td align="left">Cross Members</td><td align="right">'+responseData.crossmembers+'</td></tr>';					
					}
					if(responseData.options != undefined && responseData.options != ""){
						html += '<tr><td align="left">Optional Feature 1 </td><td align="right">'+responseData.options+'</td></tr>';					
					}if(responseData.marketTags != undefined && responseData.marketTags.length > 0 && responseData.marketTags != ""){
						html += '<tr><td align="left">Market Tags </td><td align="right">'+responseData.marketTags+'</td></tr>';					
					}
					if(responseData.width != undefined && responseData.width != ""){
						html += '<tr><td align="left">Width </td><td align="right">'+responseData.width+'</td></tr>';					
					}
					if(responseData.height != undefined && responseData.height != ""){
						html += '<tr><td align="left">Height </td><td align="right">'+responseData.height+'</td></tr>';					
					}
					if(responseData.length != undefined && responseData.length != ""){
						html += '<tr><td align="left">Length </td><td align="right">'+responseData.length+'</td></tr>';					
					}
                    if(responseData.wallHeight != undefined && responseData.wallHeight != ""){
						html += '<tr><td align="left">Wall Height </td><td align="right">'+responseData.wallHeight+'</td></tr>';					
					}
                    if(responseData.weight != undefined && responseData.weight != ""){
						html += '<tr><td align="left">Weight </td><td align="right">'+responseData.weight+'</td></tr>';					
					}
                    if(responseData.wheels != undefined && responseData.wheels != ""){
						html += '<tr><td align="left">Wheels </td><td align="right">'+responseData.wheels+'</td></tr>';					
					}
					if(responseData.store.store_name != undefined && responseData.store != ""){
						html += '<tr><td align="left">Location </td><td align="right">'+responseData.store.store_name+'</td></tr>';					
					}
					if(responseData.condition != undefined && responseData.condition != ""){
						html += '<tr><td align="left">Condition </td><td align="right">'+responseData.condition+'</td></tr>';					
					}
                    if(responseData.category != undefined && responseData.category != ""){
						var categoryArr = responseData.category;
                        html += '<tr><td align="left">Category</td><td align="right">';
                        for(var cat=0; cat<categoryArr.length; cat++){
                        	html += categoryArr[cat].label+' ';	
                         }
                         html += '</td></tr>'
					}
					if(responseData.color != undefined && responseData.color != ""){
						html += '<tr><td align="left">Color </td><td align="right">'+responseData.color+'</td></tr>';					
					}
                    if(responseData.fenders != undefined && responseData.fenders != ""){
						html += '<tr><td align="left">Fenders </td><td align="right">'+responseData.fenders+'</td></tr>';					
					}
                    if(responseData.frame != undefined && responseData.frame != ""){
						html += '<tr><td align="left">Frame </td><td align="right">'+responseData.frame+'</td></tr>';					
					}
                    if(responseData.frameType != undefined && responseData.frameType != ""){
						html += '<tr><td align="left">Frame Type </td><td align="right">'+responseData.frameType+'</td></tr>';					
					}
					if(responseData.vin != undefined && responseData.vin != ""){
						html += '<tr><td align="left">VIN </td><td align="right">'+responseData.vin+'</td></tr>';					
					}if(responseData.vehicleMake!=undefined && responseData.vehicleMake.label != undefined && responseData.vehicleMake.label != ""){
						html += '<tr><td align="left">Make </td><td align="right">'+responseData.vehicleMake.label+'</td></tr>';					
					}if(responseData.stockNo != undefined && responseData.stockNo != ""){
						html += '<tr><td align="left">Stock No. </td><td align="right">'+responseData.stockNo+'</td></tr>';					
					}if(responseData.externalLinks != undefined && responseData.externalLinks != ""){
                    var extLinkArr = responseData.externalLinks;
					html += '<tr><td>External Links</td><td></td></tr><tr><th><b>URL</b></th><th><b>Anchor Text</b></th></tr>';
                    for(var extLink=0; extLink<extLinkArr.length; extLink++){
                    	html +='<tr><td><a href='+extLinkArr[extLink].link+' target="_blank">'+extLinkArr[extLink].link+'</a></td><td>'+extLinkArr[extLink].text+'</td></tr>';
                     }				
					}
					html += '</tbody>';
					$('#itemSpecificationTable').html(html);
                },
                error: function (xhr, status) {
                    alert("Sorry, there was a problem!");
                },
                complete: function (xhr, status) {
                    $("#loader").hide(1000);
                }
            });
			$.ajax({
				type:"POST",
				url: dealsectorAjaxUrl,
				data:{
					"action": "dealsector_inventoryimages",
					"inventory": getUrlParameter("id")
				},beforeSend: function(){
					$(".photo_loader").show();
					$('.photo-gallery-viewdetail').html("");
					$('.invUnitCarousel').html("");
	      			$(".lSGallery").html("");
				},success:function(response){
					var responseData = JSON.parse(response);
					responseData = responseData.data;
					var photoHtml = "";
					if(responseData.length > 0){
						$( responseData ).each(function( index ) {
	                    	if(responseData[index].fileType == "image"){
							var imageMainPath = responseData[index].filePath;
							var imageSizePath = imageMainPath.replace('main','1000x750');
							var imageThumbPath = responseData[index].fileThumbPath;
							var imageSizeThumbPath = imageThumbPath.replace('main','400x300');
							
								photoHtml += "<li data-thumb='"+imageSizeThumbPath+"'><img class='photo-of-gallery-x' src='"+imageSizePath+"'/></li>"
							}
							if(responseData[index].fileType == "video"){
								photoHtml += "<li data-thumb='"+responseData[index].fileThumbPath+"'><video controls><source src='"+responseData[index].filePath+"'>Your browser does not support the video tag.</video></li>";
							}
						});
					}else{
						photoHtml = "<p><img class='photo-of-gallery-x' src='"+dealsectorPluginBaseUrl+"includes/images/defaultimage.jpg'/></p>";
					}
	                $('.photo-gallery-new').html(photoHtml);
	                
					$('.photo-gallery-viewdetail').html(photoHtml);
					$('.invUnitCarousel').html(photoHtml);
					$('.photo-gallery-viewdetail').lightSlider({
					});
	              
	                $('.invUnitCarousel').lightSlider({
						gallery: true,
						item: 1,
						speed: 1500,
    					pause: 5000,
	                    auto: true,
						loop: true,
						slideMargin: 0,
						videojs: true,
						thumbItem:responseData.length + 1
					});
				},
				error: function (xhr, status) {
					alert("Sorry, there was a problem!");
				},
				complete: function (xhr, status) {
					$(".photo_loader").hide();
				}
			});
		}
    });
    $(document).on("click", ".photo-modal-close-new", function(){
	  $(".photo-modal-new").hide(500);
	});
	$(document).on ("click", ".photo-of-gallery-x", function() {
    	$(".photo-modal-new").show();
  	});
	$(document).on("click", ".photo-modal-close-viewdetail", function(){
		$('.photo-view-viewdetail').html("");
	  	$(".photo-modal-viewdetail").hide(500);
	});
    $(document).on("click", ".button-icon-left", function(){
		localStorage.setItem("ds_wp_setfilter",true);
	});
    
});