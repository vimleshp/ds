jQuery( function ( $ ) {
	$(function() {
    	function setAccText(){
        	var accText = "";
            if($("input[name='radio-trailer-length']:checked").val() != undefined){
            accText += "Trailer Length: " + $("input[name=radio-trailer-length]:checked").val() +"\n";
            }
            if($("input[name='radio-coupler-options']:checked").val() != undefined){
            accText += "Coupler Options: " + $("input[name=radio-coupler-options]:checked").val() +"\n";
            }
            if($("input[name='radio-axle-options']:checked").val() != undefined){
            accText += "Axle Options: " + $("input[name=radio-axle-options]:checked").val() +"\n";
            }
            if($("input[name='radio-tail-options']:checked").val() != undefined){
            accText += "Tail Options: " + $("input[name=radio-tail-options]:checked").val() +"\n";
            }
            if($("input[name='radio-color-options']:checked").val() != undefined){
            	accText += "Color Options: " + $("input[name=radio-color-options]:checked").val() +"\n";
            }
            if($("input[name='checkbox-other-options[]']:checked").val() != undefined){
                var otherOptionsVal = "";
                $("input:checkbox[name='checkbox-other-options[]']:checked").each(function(){
                    otherOptionsVal += '\n'+$(this).val();
                });
                
                accText += "Other Options: " + otherOptionsVal +"\n";
            }
            $("#your-add-accessories").val(accText);
        }
		$( document ).ready(function() {
            setAccText();
			$.ajax({
                url: dealsectorAjaxUrl,
                type: 'POST',
                dataType: "json",
                data: { 
                "action": "dealsector_getlocation"
                },
                success: function (response) {
                	if($.cookie('USERLOCATION') != undefined){
                    var cookieLocation = window.atob($.cookie('USERLOCATION'));
					locationArr = cookieLocation.split('|');
					locationID = locationArr[1];
                    locationName = locationArr[0];
                    }
                    var locationOptions = "";
                    /*var locationOptions = "<option value=''>All Locations</option>";*/
                    $.each(response, function( index, value ) {
                      locationOptions += "<option value='"+value.store_id+"'";
                      if($.cookie('USERLOCATION') != undefined && locationName.indexOf(value.store_name) != -1){
                      	locationOptions += " selected=selected ";
                      }
                      locationOptions += ">"+value.store_name+"</option>";
                    });
                    $("#shopByLocation").append("<option value=''>All Locations</option>");
                    $("select[name=select-location]").append(locationOptions);
                }
            });

            $(".videosSlider").lightSlider({
                item: 4,
                responsive : [
                  {
                     breakpoint:1024,
                     settings: {
                         item:3
                     }
                  },{
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
            }); //End of Video Slider
			
			$('.print').on('click', function() {
                //$('.fusion-accordian .panel-collapse').addClass('in');
				$('textarea').each(function() {
					$(this).height($(this).prop('scrollHeight'));
				});
				$(".dsprint").print({
					globalStyles: true,
					mediaPrint: true,
					stylesheet: null,
					noPrintSelector: ".no-print",
					iframe: true,
					append: null,
					prepend: null,
					manuallyCopyFormValues: true,
					deferred: $.Deferred(),
					timeout: 750,
					title: null,
					doctype: '<!doctype html>'
				});

                /*setTimeout(function(){
                    $('.fusion-accordian .panel-collapse').removeClass('in');
                  },3000);*/
			});

            $("input[type=radio],input[type=checkbox]").on("change", function(){
                setAccText();
            });

            $('body').click(function() {
                if (!$(this.target).is('.photo-modal')) {
                    $(".photobodycover").hide();
                }
             }); 

            $('.wpcf7-form').on('focusout','.wpcf7-form-control',function(){
                if($('.wpcf7-not-valid-tip',$(this).parent()).length && $(this).val() != ''){
                    $('.wpcf7-not-valid-tip',$(this).parent()).remove();
                }
            });

            $("select[name=select-location]").change(function(){
                var location_text=$("select[name=select-location] option:selected").text();
                $('#loc_text').val(location_text);
                $('#site_url').val(window.location.href);

            }); 
		});
        
        $(document).on("click",".textUsBtnClick",function() {
            $('#iframe-wrapper-xKwoPyh0azNf9vwNV9uv').click();
        });
    });
    
});