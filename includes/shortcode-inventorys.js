var latitude = 0;
var longitude = 0;
var makeAttr = "";
var isMakeInURL = 0;

function getCookie(cname) {
	var name = cname + "=";
	var decodedCookie = decodeURIComponent(document.cookie);
	var ca = decodedCookie.split(';');
	for(var i = 0; i <ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') {
      		c = c.substring(1);
    	}
	    if (c.indexOf(name) == 0) {
	      return c.substring(name.length, c.length);
	    }
  	}
	return "";
}

function getLocation() {
  if (navigator.geolocation && localStorage.getItem("locationPermission") === null) {
    navigator.geolocation.getCurrentPosition(showPosition, onLocError);
  } else { 
    console.log("Geolocation is not supported by this browser.");
  }
}

function onLocError() {
    localStorage.setItem("locationPermission","denied");
}

function showPosition(position) {
    localStorage.setItem("locationPermission","granted");
    latitude = position.coords.latitude;
    longitude = position.coords.longitude;
    if(getCookie('USERLOCATION') == ""){
        if (window.location.href.indexOf('reload')==-1) {
            if(window.location.href.indexOf('?')==-1){
                window.location.replace(window.location.href+'?reload');
            }else{
                window.location.replace(window.location.href+'&reload');
            }
        }
    }
}



jQuery( function ( $ ) {
	var photoGallerySlider = $('.photo-gallery').lightSlider({});
    dealsectorAjaxUrl = dealsector_settings['dealsectorAjaxUrl'];
	dealsectorRecordToShow = dealsector_settings['dealsectorRecordToShow'];
	
	var locationID = "";
    function addPageInURL(pageno) {
		if (history.pushState) {
			var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?pageno='+pageno;
			window.history.pushState({path:newurl},'',newurl);
		}
    }
      
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
	}
	
	function getHashUrlParameter(sParam) {
        var sPageURL = window.location.hash.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        	}
    	}
		return false;
	}

	function setURLLocation(){
	    if(getUrlParameter("location") != "" && getUrlParameter("location") != undefined){
	    	$("select[name='select-location']").val(getUrlParameter("location"));
	 	}
	}

	function getLocationList(){
	    $.ajax({
	        type:"POST",
	        dataType: "html",
	        url: dealsectorAjaxUrl,
	        data:{
	            "action": 'dealsector_location_list'
	        },success:function(response){
	            $('body').append(response);
	        },
	        error: function (xhr, status) {
	            alert("Sorry, there was a problem!");
	        },
	        complete: function(){
	        if(localStorage.getItem("ds_wp_setfilter") != undefined && localStorage.getItem("ds_wp_setfilter") == "true"){
	                setLocalStorageFilterValues();
	                localStorage.clear();
	                
	            }else{
	                if($.cookie('USERLOCATION') == undefined || $.cookie('USERLOCATION') == null){
	                    $( ".chooseLoc a" ).trigger( "click" );
	                }else{
	                    $('.storeChild[data-id="'+locationID+'"]').addClass('selected');
	                }
	            }
	            
	        }
	    });
	}


	
	function getFilterFormData(){
     	var data = {};
        if($(".invFilterFormClass").serializeArray().length > 0){
            jQuery.each($(".invFilterFormClass").serializeArray(), function(index, field) {
                data[field.name] = field.value;
            });
        }else{
            
        	data["stock"] = "";
            data["coupler_type"] = "";
            data["price_range"] = "";
			data["category"] = "";
            data["height"] = "";
            data["wallheightout"] = "";
            data["color"] = "";
			data["premiumFeatures"] = "";
            data["make"] = "";
            data["trailer_type"] = "";
            data["condition"] = "";
            data["search"] = "";
            data["price_sort"] = "";
            data["length"] = "";
        }
		return data;
	}
	
	
	function getFilterResult(start=0){
      	if(start > 0){
			start = start - 1;
		}
		
		var data_ = getFilterFormData();
        data_["action"] = 'dealsector_filter_inventorys';
        data_["category"] = "";
		
		if($("select[name=category]").val() == undefined || $("select[name=category]").val() == ''){
			data_["category"] = $("input[name=category]").val();
		}
        else {
        	data_["category"] = $("select[name=category]").val();
        }
        if( $("select[name=color]").val() != undefined ){
            data_["color"] = $("select[name=color]").val();
        }else{
            data_["color"] = "";
        }
		if( $("select[name=premiumFeatures]").val() != undefined ){
            data_["premiumFeatures"] = $("select[name=premiumFeatures]").val();
        }else{
            data_["premiumFeatures"] = "";
        }
        if( $("select[name=length]").val() != undefined ){
            data_["length"] = $("select[name=length]").val();
        }else{
            data_["length"] = "";
        }
		data_["price_range"] = "";
		if( $("select[name=price_range]").val() != undefined ){
            data_["price_range"] = $("select[name=price_range]").val();
        }
		data_["price_sort"] = "";
		if( $("select[name=price_sort]").val() != undefined ){
            data_["price_sort"] = $("select[name=price_sort]").val();
        }
		data_["height"] = "";
		if( $("select[name=height]").val() != undefined ){
            data_["height"] = $("select[name=height]").val();
        }

        data_["wallheightout"] = "";
        if( $("select[name=wallheightout]").val() != undefined ){
            data_["wallheightout"] = $("select[name=wallheightout]").val();
        }

		data_["coupler_type"] = "";
		if( $("select[name=coupler_type]").val() != undefined ){
            data_["coupler_type"] = $("select[name=coupler_type]").val();
        }
		data_["location"] = "";
		if( $("select[name=location]").val() != undefined ){
            data_["location"] = $("select[name=location]").val();
        }
		data_["condition"] = "";
		if( $("select[name=condition]").val() != undefined ){
            data_["condition"] = $("select[name=condition]").val();
        }
		data_["stock"] = "";
		if( $("input[name=stock]").val() != undefined ){
            data_["stock"] = $("input[name=stock]").val();
			
        }
		data_["make"] = "";
		if( $("select[name=make]").val() != undefined ){
            data_["make"] = $("select[name=make]").val();
			
        }
		data_["search"]=  data_["search"].replace(/[^\w\s]/gi, '');
		if($.cookie("search_key")!=undefined){
            data_["search"]= $.cookie("search_key");
	    }
		if($.cookie("search_key")==undefined){
			$('#home_search_text').html('');
		}
		
		
		data_["limit"] = dealsectorRecordToShow;
		data_["start"] = start;
        if(isMakeInURL == 1){
        	data_["make"] = makeAttr;
        }
	    data_['template_id']=$('#template_id').text();
		var h_url='';
		if(data_["stock"]!=""){
			h_url+="&stock="+data_["stock"];
		}
		if(data_["search"]!=""){
			h_url+="&search="+data_["search"];
		}
		if(data_["color"]!=""){
			h_url+="&color="+data_["color"];
		}
		if(data_["condition"]!=""){
			h_url+="&condition="+data_["condition"];
		}
		if(data_["category"]!="" && data_["category"]!=undefined){
			h_url+="&category="+data_["category"];
		}
        if(data_["price_sort"]!=""){
			h_url+="&price_sort="+data_["price_sort"];
		}
		if(data_["make"]!=""){
			h_url+="&make="+data_["make"];
		}
		if(data_["location"]!=""){
			h_url+="&location="+data_["location"];
		}
		if(data_["price_range"]!=""){
			h_url+="&price_range="+data_["price_range"];
		}
		if(data_["length"]!=""){
			h_url+="&length="+data_["length"];
		}
		if(data_["coupler_type"]!=""){
			h_url+="&coupler_type="+data_["coupler_type"];
		}
		if(data_["wallheightout"]!=""){
			h_url+="&height="+data_["wallheightout"];
		}
		if(data_["premiumFeatures"]!=""){
			h_url+="&premiumFeatures="+data_["premiumFeatures"];
		}
		
		var h_str=window.location.href;
		h_str=h_str.split('/');
		if(h_str.length >0){
			h_str=h_str[3];		
		}
		
		if(h_url.length >0){
			h_url=h_url.substring(1);	
			window.location.hash=h_url;		
		}
        
        if(localStorage.getItem("ds_wp_setfilter") == undefined){
            localStorage.setItem("ds_wp_stock",data_["stock"]);
            localStorage.setItem("ds_wp_search",data_["search"]);
            localStorage.setItem("ds_wp_price_sort",data_["price_sort"]);
            localStorage.setItem("ds_wp_height",data_["height"]);
            localStorage.setItem("ds_wp_wallheightout",data_["wallheightout"]);
            localStorage.setItem("ds_wp_color",data_["color"]);
            localStorage.setItem("ds_wp_condition",data_["condition"]);
			localStorage.setItem("ds_wp_premium_feature",data_["premiumFeatures"]);
            localStorage.setItem("ds_wp_category",data_["category"]);
            localStorage.setItem("ds_wp_make",data_["make"]);
            localStorage.setItem("ds_wp_location",data_["location"]);
            localStorage.setItem("ds_wp_price_range",data_["price_range"]);
            localStorage.setItem("ds_wp_length",data_["length"]);
            localStorage.setItem("ds_wp_coupler_type",data_["coupler_type"]);
        }
        
		$.ajax({
			type:"POST",
			dataType: "html",
			url: dealsectorAjaxUrl,
			data:data_,
			beforeSend: function(){
				$('#showresults').html("");
				$("#list_loader").show(1000);
			},success:function(response){
				  
					var result = $('<div />').append(response).find('#showresults').html();
				 	$('#showresults').css('display','block');
					$('#showresults').html(result);
					$('.paginationresult').css('display','block');
					var pageNo=parseInt($("#pageStartNo").text());
					
			        var totalRecords=$('#record_total').html();
				    if(totalRecords==undefined){
	                    totalRecords=0;
				    }
					$('.itemRecCount').text(totalRecords);
	                $(".Units").text('('+totalRecords+' units)');
	                var numberOfPages = Math.ceil(totalRecords/dealsectorRecordToShow);
	                $(".pageEndNo").text(numberOfPages);
					var Pagestartfrom=1;
					var Pageendlimit=parseInt(totalRecords);
					var maxRows=parseInt(dealsectorRecordToShow);
					if(totalRecords==0){
						Pagestartfrom=0;
					}
					var currentpage=pageNo;
					if(currentpage > 1){
						Pagestartfrom=(currentpage-1)*maxRows;
						Pagestartfrom++;
					}
					if(maxRows*currentpage<Pageendlimit){
						Pageendlimit=(Pagestartfrom-1)+maxRows;
					}
					
					$('.pageLink').removeClass('active');
					$('.pageLink').each(function(){
						var pageLinkNum=$(this).data('page');
						if(currentpage==pageLinkNum){
							$(this).addClass('active');
						}
					});
					$('.itemEndPage').text(Pageendlimit);
					$('.itemStartPage').text(Pagestartfrom);
					
					var pageStartFrom=1;
					var bandGap=2;
					var page_html='';
					var totalPages=numberOfPages;
					if ((currentpage-bandGap) > 2 ) {
						pageStartFrom = currentpage-bandGap;
						page_html+='<a class="pageLink" data-page="1"  href="javascript:void(0);" class="page-link">1</a>';
						page_html+='<a class="page-link" href="javascript:null">...</a>';
					}
					var pageTo = currentpage+bandGap;
					if ( ( currentpage + bandGap ) > totalPages ) {
						pageTo = totalPages;
					}
					
					for(var i=pageStartFrom;i<=pageTo;i++){
						if ( currentpage == i ) {
							page_html+='<a class="pageLink active" data-page="'+i+'" href="javascript:void(0);">'+i+'</a>';
						}
						else{
							page_html+='<a class="pageLink" data-page="'+i+'"  href="javascript:void(0);">'+i+'</a>';
						}
					}
					if ( ( currentpage + bandGap) < totalPages-1) {
						page_html+='<a class="page-link" href="javascript:null">...</a>';
					}
					if ( ( currentpage + bandGap) < totalPages) {
					page_html+='<a class="pageLink pageEndNo" data-page="'+totalPages+'" href="javascript:void(0)">'+totalPages+'</a>';
			
				}
				$('.pageCont').html(page_html);
	            
	            if(totalRecords == 0 || numberOfPages==1 || pageNo==numberOfPages){
	            	$(".next").attr( "disabled" ,"disabled" );
	         		$(".nextButton").addClass( "noborder");
					$(".nextButton").removeClass( "next");
	            }
	            else{
	            	$(".next").removeAttr( "disabled" );
	         		$(".nextButton").removeClass( "noborder");
					$(".nextButton").addClass( "next");
	            }
	            if(totalRecords == 0 || numberOfPages ==1 || pageNo==1){
	            	$(".prev").attr( "disabled" ,"disabled" );
	            	$(".prevButton").addClass( "noborder");
					$(".prevButton").removeClass( "prev");
	            }
	            else{
	            	$(".prev").removeAttr( "disabled" ,"disabled" );
	            	$(".prevButton").removeClass( "noborder");
					$(".prevButton").addClass( "prev");
	            }
				$('#home_search_text').html('');
				if($.cookie("search_key")!=undefined){
					
					if($.cookie("search_key").trim() != ""){
						$('#home_search_text').html('You search for <b>"'+$.cookie("search_key")+'"</b> inventory');
					}
					
					$('input[name=search]').val($.cookie("search_key"));
					$('input[name=s]').val($.cookie("search_key"));
					$.removeCookie('search_key',{path: '/' });

					$('#InvReset').removeAttr('disabled');
					$('#InvReset').removeClass('disabled_clear_filters');
					$('#InvReset').addClass('clear_filters');
				}

	         	$('.invUnitCarouseltest').lightSlider({
					item: 1,
					autoWidth: false,
					gallery: true,
					galleryMargin: 5,
					thumbMargin: 5,
					thumbItem: 10,
					onBeforeStart: function($el){
						$('.invUnitCarouseltest').hide();
						$('.slider_loader_img').show();
						var src_img = $el.find('li img').first().attr('data-src');
						var $img = $el.find('li img').first();
						$img.attr('src', src_img);
						$img.css('display', 'initial');

					},
					onSliderLoad:function(slider){
						$('.lSPrev').hide();
						$( window ).resize();
						$('.slider_loader_img').hide();
						$('.invUnitCarouseltest').show();
						setTimeout(function(){ 
							$('.image_overlay').show();	
						}, 1500);
						
					},
					onAfterSlide: function ($el, scene) {
						var $img = $el.find('img').eq($el.getCurrentSlideCount() - 1);
						var $img_src = $img.attr('data-src');
						$img.attr('src', $img_src);
						$img.css('display', 'initial');
						if ($el.getCurrentSlideCount() == 1) {
							$('.lSPrev').hide();
						} else if ($el.getCurrentSlideCount() == $el.find('li').length) {
							$('.lSNext').hide();
						} else {
							$('.lSPrev').show();
							$('.lSNext').show();
						}
					}
				});
			},
			error: function (xhr, status) {
				alert("Sorry, there was a problem!");
			},
			complete: function (xhr, status) {
	       		$("#list_loader").hide(1000);
				setTimeout(function(){ 
					$('.lazy').css('background-image', 'none');
				}, 2000);
			}
		});
	}
	
	$(document).on("click", ".getQuoteModalBtnClass", function(){
		$('.getQuoteParent').css('display','block');
		$('.getQuoteParent form')[0].reset();
        $('.getQuoteParent form .wpcf7-not-valid-tip').css( "display", "none" );
        $('.getQuoteParent form .wpcf7-response-output').css( "display", "none" );
		var scrollBarWidth = window.innerWidth - document.body.offsetWidth;
        $('body').css('margin-right', scrollBarWidth).addClass('showing-modal');
        $('input[name=stock-number-quote]').val($(this).attr("data-stockno"));
        $('input[name=inventory-url-quote]').val($(this).attr("data-viewdetail"));
    });
    $(document).on("click", ".getFullImageModalBtnClass", function(){
    	$(".viewFullMainInvImage img").attr("src",$(this).attr("data-image"));
    });
	
	function setLocalStorageFilterValues(){
		if($.cookie('USERLOCATION') != undefined && $.cookie('USERLOCATION') != ""){
	        var cookieLocation = window.atob($.cookie('USERLOCATION'));
	        locationArr = cookieLocation.split('|');
	        locationID = locationArr[1];
	        $(".chooseLoc a").html("Change location <br>["+locationArr[0]+"]");
	        $('.storeChild[data-id="'+locationID+'"]').addClass('selected')
	    }

	    if(localStorage.getItem("ds_wp_stock") != undefined){
        	$('input[name=stock]').val(localStorage.getItem("ds_wp_stock"));
        }
        if(localStorage.getItem("ds_wp_search") != undefined){
        	$('input[name=search]').val(localStorage.getItem("ds_wp_search"));
        }
        if(localStorage.getItem("ds_wp_p_price_sort") != undefined){
        	$('select[name=price_sort]').val(localStorage.getItem("ds_wp_price_sort"));
        }
        if(localStorage.getItem("ds_wp_height") != undefined){
            $('select[name=height]').val(localStorage.getItem("ds_wp_height"));
        }
        if(localStorage.getItem("ds_wp_wallheightout") != undefined){
            $('select[name=wallheightout]').val(localStorage.getItem("ds_wp_wallheightout"));
        }
        if(localStorage.getItem("ds_wp_p_color") != undefined){
            $('select[name=color]').val(localStorage.getItem("ds_wp_color"));
        }
        if(localStorage.getItem("ds_wp_condition") != undefined){
        	$('select[name=condition]').val(localStorage.getItem("ds_wp_condition"));
        }
		if(localStorage.getItem("ds_wp_premium_feature") != undefined){
            $('select[name=premiumFeatures]').val(localStorage.getItem("ds_wp_premium_feature"));
        }
        if(localStorage.getItem("ds_wp_category") != undefined){
        	$('input[name=category]').val(localStorage.getItem("ds_wp_category"));
            $('select[name=category]').val(localStorage.getItem("ds_wp_category"));
        }
        if(localStorage.getItem("ds_wp_make") != undefined){
        	$('select[name=make]').val(localStorage.getItem("ds_wp_make"));
            
        }
        if(localStorage.getItem("ds_wp_location") != undefined){
        	$('select[name=location]').val(localStorage.getItem("ds_wp_location"));
        }
        if(localStorage.getItem("ds_wp_price_range") != undefined){
        	$('select[name=price_range]').val(localStorage.getItem("ds_wp_price_range"));
        }
        if(localStorage.getItem("ds_wp_length") != undefined){
        	$('select[name=length]').val(localStorage.getItem("ds_wp_length"));
        }
        if(localStorage.getItem("ds_wp_coupler_type") != undefined){
        	$('select[name=coupler_type]').val(localStorage.getItem("ds_wp_coupler_type"));
        }
    }
	
	$(document).ready(function(){ 
		localStorage.removeItem("recordStartFrom");
		if(localStorage.getItem("ds_wp_setfilter") != undefined && localStorage.getItem("ds_wp_setfilter") == "true"){
			setLocalStorageFilterValues(); 
		  }

		$("body").click(function(){
			$(".photobodycover").css("display", "none").hide(500).removeClass("open");
			$("html, body").removeClass('modal-open');
			$(".photo-modal").find('a.bottomCtrl').remove();
	    });

	    // Prevent events from getting pass .popup
	    $(".photo-modal").click(function(e){
	       e.stopPropagation();

	       	$(".photo-modal-close").click(function(e) {
				$(".photobodycover").css("display", "none").hide(500).removeClass("open");
				$("html, body").removeClass('modal-open');
				$(".photo-modal").find('a.bottomCtrl').remove();

				photoGallerySlider.destroy();
			});
	    });
		var pagen=getUrlParameter("pageno");
		if(pagen==undefined){
			pagen=1;
		}
		$('#pageStartNo').text(pagen);
		
		var start=(pagen*parseInt(dealsectorRecordToShow))-parseInt(dealsectorRecordToShow);
		var category1=$("input[name=category]").val();
		var stockv = getHashUrlParameter("stock");
		var searchv = getHashUrlParameter("search");
		var price_sortv = getHashUrlParameter("price_sort");
		var conditionv = getHashUrlParameter("condition");
		var categoryv = getHashUrlParameter("category");
		var makev = getHashUrlParameter("make");
		var price_rangev = getHashUrlParameter("price_range");
		var lengthv = getHashUrlParameter("length");
		var coupler_typev = getHashUrlParameter("coupler_type");
		var locationv = getHashUrlParameter("location");
		var colorv = getHashUrlParameter("color");
		var wallheightoutv = getHashUrlParameter("height");
		var premiumFeaturesv = getHashUrlParameter("premiumFeatures");
		var url_arr=[];
		
		if(conditionv!=""){
			$('select[name=condition]').val(conditionv);
			url_arr.push(conditionv);
		}
		if(makev!=""){
			$('select[name=make]').val(makev);
			url_arr.push(makev);
		}
		if(stockv!=""){
			$('input[name=stock]').val(stockv);
			url_arr.push(stockv);
		}
		if(searchv!=""){
			$('input[name=search]').val(searchv);	
			url_arr.push(searchv);
		}
		if(price_sortv!=""){
			$('select[name=price_sort]').val(price_sortv);
			url_arr.push(price_sortv);
		}

		if(categoryv!=""){
			$('select[name=category]').val(categoryv);
			url_arr.push(categoryv);
		}
		if(price_rangev!=""){
			$('select[name=price_range]').val(price_rangev);
			url_arr.push(price_rangev);
		}
		if(lengthv!=""){
			$('select[name=length]').val(lengthv);
			url_arr.push(lengthv);
		}
		if(coupler_typev!=""){
			$('select[name=coupler_type]').val(coupler_typev);
			url_arr.push(coupler_typev);
		}
		if(locationv!=""){
			$('select[name=location]').val(locationv);
			url_arr.push(locationv);
		}
		if(colorv!=""){
			$('select[name=color]').val(colorv);
			url_arr.push(colorv);
		}
		if(wallheightoutv!=""){
			$('select[name=wallheightout]').val(wallheightoutv);
			url_arr.push(wallheightoutv);
		}
		if(premiumFeaturesv!=""){
			$('select[name=premiumFeatures]').val(premiumFeaturesv);
			url_arr.push(premiumFeaturesv);
		}
		
		if(url_arr.length >0){
		  	getFilterResult(start+1);
			$('#InvReset').removeAttr('disabled');
			$('#InvReset').removeClass('disabled_clear_filters');
			$('#InvReset').addClass('clear_filters');
			
		}
		else{
			$('.invUnitCarouseltest').lightSlider({
				item: 1,
				autoWidth: false,
				gallery: true,
				galleryMargin: 5,
				thumbMargin: 5,
				thumbItem: 10,
				onBeforeStart: function($el){
					$('.invUnitCarouseltest').hide();
					$('.slider_loader_img').show();
					var src_img = $el.find('li img').first().attr('data-src');
					var $img = $el.find('li img').first();
					$img.attr('src', src_img);
					$img.css('display', 'initial');

				},
				onSliderLoad:function(slider){
					$('.lSPrev').hide();
					$( window ).resize();
					$('.slider_loader_img').hide();
					$('.invUnitCarouseltest').show();
					setTimeout(function(){ 
						$('.image_overlay').show();	
					}, 1500);
					
				},
				onAfterSlide: function ($el, scene) {
					var $img = $el.find('img').eq($el.getCurrentSlideCount() - 1);
					var $img_src = $img.attr('data-src');
					$img.attr('src', $img_src);
					$img.css('display', 'initial');
					if ($el.getCurrentSlideCount() == 1) {
						$('.lSPrev').hide();
					} else if ($el.getCurrentSlideCount() == $el.find('li').length) {
						$('.lSNext').hide();
					} else {
						$('.lSPrev').show();
						$('.lSNext').show();
					}
				}
			});
		    $('#InvReset').attr('disabled','disabled');
			$('#InvReset').addClass('disabled_clear_filters');
			$('#InvReset').removeClass('clear_filters');	
		}
		
		$('#home_search_id').find('.elementor-search-form__submit').addClass('home_search_button');
		$('#home_search_id').find('.elementor-search-form__input').addClass('home_search_input');
		$('#home_search_id').find('.elementor-search-form__submit').attr('type',"button");
		$('#home_search_text').html('');
		if($.cookie("search_key")!=undefined){
			$('.inside-article').prepend($('<h5 id="home_search_text"></h5>'));
			if(url_arr.length==0){
				getFilterResult(start+1);
			}
			else{
				$('#home_search_text').html('You search for <b>"'+$.cookie("search_key")+'"</b> inventory');
				$('input[name=search]').val($.cookie("search_key"));
				$.removeCookie('search_key', { path: '/' });
			}
			
		}
				
		$('.lazy').lazy({});
		setTimeout(function(){ 
			$('.lazy').css('background-image', 'none');
		}, 2000);
		
		var slider = $("#newArrival").lightSlider({
            item:6,
            controls: false,
            pager:false,
            loop: false,
            responsive : [
                {
                   breakpoint:1199,
                   settings: {
                       item:5
                   }
                },
                {
                   breakpoint:1024,
                   settings: {
                       item:4
                   }
                },
                {
                   breakpoint:768,
                   settings: {
                       item:3
                   }
                },
                {
                   breakpoint:640,
                   settings: {
                       item:2
                   }
                },
                {
                   breakpoint:480,
                   settings: {
                       item:1
                   }
                }
            ]
        });

        $('.slideControls_2 .slidePrev').click(function() {
          slider.goToPrevSlide();
        });

        $('.slideControls_2 .slideNext').click(function() {
          slider.goToNextSlide();
        });

        var slider2 = $("#featured").lightSlider({
			item:6,
			controls: false,
			pager:false,
			loop: false,
			responsive : [
                {
                   breakpoint:1199,
                   settings: {
                       item:5
                   }
                },
                {
                   breakpoint:1024,
                   settings: {
                       item:4
                   }
                },
                {
                   breakpoint:768,
                   settings: {
                       item:3
                   }
                },
                {
                   breakpoint:640,
                   settings: {
                       item:2
                   }
                },
                {
                   breakpoint:480,
                   settings: {
                       item:1
                   }
                }
            ]
      	});
          
        $('.slideControls_1 .slidePrev').click(function() {
          slider2.goToPrevSlide();
        });

        $('.slideControls_1 .slideNext').click(function() {
          slider2.goToNextSlide();
        });
	});
	
	$(document).on("click", ".photo-modal-open", function(){
		$("html, body").addClass('modal-open');
        $(".photobodycover").show().css("display", "flex").addClass("open");
		var _id = "";
		if($(this).data("id") != ""){
			_id = $(this).data("id");
		}
		$.ajax({
			type:"POST",
			url: dealsectorAjaxUrl,
			data:{
				"action": "dealsector_inventoryimages",
				"inventory": _id
			},beforeSend: function(){
				$(".photo_loader").show();
				$('.photo-gallery').html("");
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
							photoHtml += "<li data-thumb='"+imageSizeThumbPath+"'><img class='photo-of-gallery' src='"+imageSizePath+"'/></li>"
						}
						if(responseData[index].fileType == "video"){
							photoHtml += "<li data-thumb='"+responseData[index].fileThumbPath+"'><video controls><source src='"+responseData[index].filePath+"'>Your browser does not support the video tag.</video></li>";
						}
					});
				}else{
					photoHtml = "<h1>No Photos Found!!</h1>";
				}
				$('.photo-gallery').html(photoHtml);
                photoGallerySlider.destroy();
				photoGallerySlider = $('.photo-gallery').lightSlider({
					gallery:true,
					item:1,
					thumbItem:9,
					slideMargin: 0,
					speed:500,
					auto:false,
					loop:true,
					videojs: true,
					onSliderLoad: function() {
						$('.photo-gallery').removeClass('cS-hidden');

						$('.bottomCtrl.lSPrev').click(function(){
				            photoGallerySlider.goToPrevSlide(); 
				        });
				        $('.bottomCtrl.lSNext').click(function(){
				        	photoGallerySlider.goToNextSlide(); 
				        });
					}
				});

               
                //Control customization
                $(".photo-modal .lSSlideOuter").append('<a class="bottomCtrl lSPrev"></a><a class="bottomCtrl lSNext"></a>');
           		$(".photo-modal .lSPrev").append('<i class="fas fa-caret-left"></i>');
                $(".photo-modal .lSNext").append('<i class="fas fa-caret-right"></i>');
               	
			},
			error: function (xhr, status) {
				alert("Sorry, there was a problem!");
			},
			complete: function (xhr, status) {
				$(".photo_loader").hide();
			}
		});
	});
	
	$(document).on("click", ".photo-modal-close", function(){
		$(".photobodycover").css("display", "none").hide(500).removeClass("open");
		$("html, body").removeClass('modal-open');
		$(".photo-modal").find('a.bottomCtrl').remove();

		photoGallerySlider.destroy();
	});
	
	$(document).on("click", ".prev", function(){
		$("body").animate({ scrollTop: 0 }, "slow");
		var startPage = $("#pageStartNo").text();
	    addPageInURL((parseInt(startPage)-1));
        $("#pageStartNo").text(parseInt(startPage)-1);
        
		if(parseInt(startPage) > 1){
			$(".pageStartNo").text(parseInt(startPage)-1);
		}
		var endPage = $(this).parent().find(".pageEndNo").text();
		$("#end_page").text(endPage);
		if(parseInt(startPage) - 1 == parseInt(endPage)){
			$(".next").attr( "disabled" ,"disabled" );
            $(".nextButton").addClass( "noborder");
			$(".nextButton").removeClass("next");
        }else{
			$(".next").removeAttr( "disabled" );
			$(".nextButton").removeClass( "noborder");
			$(".nextButton").addClass("next");
		}
		if(parseInt(startPage)-1 == 1){
			$(".prev").attr( "disabled","disabled" );
            $(".prevButton").addClass( "noborder" );
            $(".prevButton").removeClass( "prev" );
		}
		if(localStorage.getItem("recordStartFrom") != undefined){
			var start = parseInt(localStorage.getItem("recordStartFrom")) - parseInt(dealsectorRecordToShow);
			localStorage.setItem("recordStartFrom", parseInt(localStorage.getItem("recordStartFrom")) - parseInt(dealsectorRecordToShow));
		}else{
			localStorage.setItem("recordStartFrom", parseInt(startPage) - parseInt(dealsectorRecordToShow));
			var start = parseInt(startPage) - parseInt(dealsectorRecordToShow);
		}
		$("html, body").animate({ scrollTop: 0 }, "slow");
		getFilterResult(start);
	});
	$(document).on("click", ".next", function(){
    	$("body").animate({ scrollTop: 0 }, "slow");
        var startPage = $("#pageStartNo").text();
	    addPageInURL((1+parseInt(startPage)));
		$(".pageStartNo").text(1+parseInt(startPage));
		$("#pageStartNo").text(1+parseInt(startPage));
		var endPage = $(this).parent().find(".pageEndNo").text();
        $("#end_page").text(endPage);
	  	if(1+parseInt(startPage) == parseInt(endPage)){
       		$(".next").attr( "disabled" ,"disabled" );
            $(".nextButton").addClass( "noborder");
			$(".nextButton").removeClass("next");
		}else{
			$(".next").removeAttr( "disabled" );
            $(".nextButton").removeClass( "noborder");
            $(".nextButton").addClass("next");
		}
		$(".prevButton").addClass( "prev" );
		$(".prev").removeAttr( "disabled" );
        $(".prevButton").addClass( "noborder" );
        $(".prevButton").removeClass( "noborder" );
        if(localStorage.getItem("recordStartFrom") != undefined){
			var start = parseInt(localStorage.getItem("recordStartFrom")) + parseInt(dealsectorRecordToShow);
			localStorage.setItem("recordStartFrom", parseInt(localStorage.getItem("recordStartFrom")) + parseInt(dealsectorRecordToShow));
		}else{
			localStorage.setItem("recordStartFrom", parseInt(startPage) + parseInt(dealsectorRecordToShow));
			var start = parseInt(startPage) + parseInt(dealsectorRecordToShow);
		}
		$("html, body").animate({ scrollTop: 0 }, "slow");
		getFilterResult(start);
	});
	//end pagination
	
	//start reset filter form
	$(document).on("click", "#InvReset", function(){
		$.removeCookie('search_key');
		$("form")[0].reset();
		window.location.hash="";
  	});
	
	$(document).on("click", ".filter-button-trigger", function(){
		$('#InvReset').removeAttr('disabled');
		$('#InvReset').removeClass('disabled_clear_filters');
		$('#InvReset').addClass('clear_filters');
		$(".pageStartNo").text(1);
        addPageInURL(1);
        if(localStorage.getItem("recordStartFrom") != undefined){
            localStorage.removeItem("recordStartFrom");
        }
		getFilterResult();
	});
	
	 $(document).on("change", ".filter-trigger", function(){
		$('#InvReset').removeAttr('disabled');
		$('#InvReset').removeClass('disabled_clear_filters');
		$('#InvReset').addClass('clear_filters');
		
		$('#home_search_text').css('display','none !important');
		$(".pageStartNo").text(1);
		$("#pageStartNo").text(1);
		
        addPageInURL(1);
        if(localStorage.getItem("recordStartFrom") != undefined){
            localStorage.removeItem("recordStartFrom");
        }
		getFilterResult();
	});
	
	$(document).on("keydown", "input[name=stock],input[name=search]", function(event){
		if (event.keyCode === 13) {
			event.preventDefault();
			$('#InvReset').removeAttr('disabled');
			$('#InvReset').removeClass('disabled_clear_filters');
			$('#InvReset').addClass('clear_filters');
        	getFilterResult();
			return false;
        }
	});
	
	$(document).on("keydown", "input[name=s]", function(event){
        var inventory_link=$('#home_search_id').data('inventorylink');
		if (event.keyCode === 13) {
			event.preventDefault();
            var sekey = $(".home_search_input").val();
            $.cookie("search_key", sekey);
			$('#home_search_text').html('You search for <b>"'+$.cookie("search_key")+'"</b> inventory');
			if(window.location.hash) { 
				getFilterResult();
			}
			else{
				window.location.href=window.location+inventory_link+'/';
			}
			return false;
        }
    });
	
	$(document).on("keydown", ".home_search_input", function(event){
        var inventory_link=$('#home_search_id').data('inventorylink');
        if (event.keyCode === 13) {
			event.preventDefault();
	        var sekey = $(".home_search_input").val();
			$('input[name=search]').val(sekey);
			$.cookie("search_key", sekey);
			$('#home_search_text').html('You search for <b>"'+$.cookie("search_key")+'"</b> inventory');
			if(location.href.indexOf("#") != -1) {
				$(".invFilterFormClass")[0].reset();
				$('#InvReset').removeAttr('disabled');
				$('#InvReset').removeClass('disabled_clear_filters');
				$('#InvReset').addClass('clear_filters');
				getFilterResult();
			}
			else{
				window.location.href=window.location+inventory_link+'/';
			}
			
			return false;
        }
    });
	
		
	$(document).on("click",".home_search_button",function(){
	    var search_key=$(".home_search_input").val();
		var inventory_link=$('#home_search_id').data('inventorylink');
		$.cookie("search_key", search_key);
		$('#home_search_text').html('You search for <b>"'+$.cookie("search_key")+'"</b> inventory');
		$('input[name=search]').val(search_key);
		if(location.href.indexOf("#") != -1) { 
			$(".invFilterFormClass")[0].reset();
			$('#InvReset').removeAttr('disabled');
			$('#InvReset').removeClass('disabled_clear_filters');
			$('#InvReset').addClass('clear_filters');
		 	getFilterResult();
		}
		else{
			window.location.href=window.location+inventory_link+'/';
		}
    });
	
	$(document).on('click','.pageLink',function(){
		var pageno=$(this).data('page');
		
		var start=(pageno*parseInt(dealsectorRecordToShow))-parseInt(dealsectorRecordToShow);
		$('#pageStartNo').text(pageno); 
		localStorage.setItem("recordStartFrom", start);
		addPageInURL((parseInt(pageno)));
		getFilterResult(start+1);
	});

	$(document).on ("change", "#shopByLocation", function() { 
        $('.storeChild').removeClass('selected');
        $('.storeChild[data-id="'+$(this).val()+'"]').addClass('selected');
        $.cookie('USERLOCATION', '', { path: '/' });
        var selectedlocation = window.btoa($("#shopByLocation option:selected").text()+'|'+$(this).val());
        $(".chooseLoc a").html("Change location <br>["+$('#shopByLocation option:selected').text()+"]");
        $.cookie('USERLOCATION', selectedlocation, {expires : 30, path: '/' });
        locationID = $(this).val();
        $("select[name='location']").val(locationID);
        setTimeout(function(){ $(".chooseStore").modal("hide"); }, 500);
        var url = window.location.origin;
        window.location.href = url+"/inventory";
    });


    $(document).on ("click", ".storeChild", function() { 
        $('.storeChild').removeClass('selected');
        $(this).addClass('selected');
        var selectedlocation = window.btoa($(this).attr("data-name")+'|'+$(this).attr("data-id"));
        $(".chooseLoc a").html("Change location <br>["+$(this).attr('data-name')+"]");
        $.cookie('USERLOCATION', selectedlocation, {expires : 30, path: '/' });
        locationID = $(this).attr("data-id");
        $("select[name='location'], select[name=select-location]").val(locationID);
        setTimeout(function(){ $(".chooseStore").modal("hide"); }, 500);
        setTimeout(function(){
            
            if($( "select.filter-trigger" ).length > 0){
                getFilterResult();
            }
            
        }, 1000);
    });


	//Class for Menu's submenu filter
	$(document).on("click",".sub-menu .applyFilter",function(){
		$('.applyFilter').find('a').removeClass('highlighted');
		var url=$(this).find('a').attr('href');
		var arguments = url.split('#')[1].split('&');
		$("select[name=category]").val("");
		$("select[name=make]").val("");
		$("select[name=price_range]").val("");
		$("select[name=length]").val("");
		$("select[name=coupler_type]").val("");
		$("select[name=location]").val("");
		$("input[name=stock]").val("");
		$("input[name=search]").val("");
		for(var i=0;i<arguments.length;i++){
			if(arguments[i].indexOf('category')!==-1){
				var categ=arguments[i].substr(arguments[i].indexOf("=")+1);
				$("select[name=category]").val(categ);
				$(this).find('a').addClass('highlighted');
			}
			if(arguments[i].indexOf('make')!==-1){
				var make=arguments[i].substr(arguments[i].indexOf("=")+1);
				$("select[name=make]").val(make);
			}
			if(arguments[i].indexOf('price_range')!==-1){
				var price_range=arguments[i].substr(arguments[i].indexOf("=")+1);
				$("select[name=price_range]").val(price_range);
			}
			if(arguments[i].indexOf('length')!==-1){
				var length=arguments[i].substr(arguments[i].indexOf("=")+1);
				$("select[name=length]").val(length);
			}
			if(arguments[i].indexOf('coupler_type')!==-1){
				var coupler_type=arguments[i].substr(arguments[i].indexOf("=")+1);
				$("select[name=coupler_type]").val(coupler_type);
			}
			if(arguments[i].indexOf('location')!==-1){
				var location=arguments[i].substr(arguments[i].indexOf("=")+1);
				$("select[name=location]").val(location);
			}
			if(arguments[i].indexOf('stock')!==-1){
				var stock=arguments[i].substr(arguments[i].indexOf("=")+1);
				$("input[name=stock]").val(stock);
			}
			if(arguments[i].indexOf('search')!==-1){
				var search=arguments[i].substr(arguments[i].indexOf("=")+1);
				$("input[name=search]").val(search);
			}
		}
		if(window.location.hash) { 
			getFilterResult();
		}
	});
    //PSS Old Code (Quote, Schedule Delivery and Message Us Button)
	$(document).on('click','.quoteclose',function(){
		$('.getQuoteParent').fadeOut('slow');
		$('.getQuoteParent form .wpcf7-response-output').css( "display", "none" );
	});
	
	$(document).on('click','.schedDiv',function(){
		$('.schedModal').css('display','block');
		$('.schedModal form')[0].reset();
        $('.schedModal form .wpcf7-not-valid-tip').css( "display", "none" );
        var stocknum=$(this).data('stockno');
		$("#stockNum").text(stocknum);
	});
	
	$(document).on('click','.schedclose',function(){
		$('.schedModal').fadeOut('slow');
		$('.schedModal form .wpcf7-response-output').css( "display", "none" );
	});
	$(document).on('click','.msgus',function(){
		$('.msgusModal').css('display','block');
		$('.msgusModal form')[0].reset();
        $('.msgusModal form .wpcf7-not-valid-tip').css( "display", "none" );
      	var stocknum=$(this).data('stockno');
		$("#stockNum").text(stocknum);
		$('input[name="stock-number-quote"]').val(stocknum);
	});
	$(document).on('click','.msgclose',function(){
		$('.msgusModal').fadeOut('slow');
		$('.msgusModal form .wpcf7-response-output').css( "display", "none" );
	});

	$(document).on('blur','input[name=your-first-name]',function(){
		var stocknum=$("#stockNum").text();
		$("#schstock").val(stocknum);
		$("#msgstock").val(stocknum);
	});	

	//End of PSS Old Code
	

});