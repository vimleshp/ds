jQuery( function ( $ ) {
    dealsectorAjaxUrl = dealsector_settings['dealsectorAjaxUrl'];
	$(function() {
        // validate signup form on keyup and submit
        $("#dealsectorClientKeyForm").validate({
            rules: {
                api_link: {
                    required: true
                },
                client_secret_key: {
                    required: true
                },
                records_to_show: {
                    digits: true
                },
                currency: {
                    required: true
                },
				finance_link: {
					required: true
				}
            },messages: {
                api_link: {
                    required: "Please enter your api link."
                },
                client_secret_key: {
                    required: "Please enter your secret key."
                },
                currency: {
                    required: "Please enter select currency."
                },
				finance_link: {
                    required: "Please enter finance link."
                }
            }
        });

        $("#dealsectorClientKeyForm").submit(function(e){
            e.preventDefault();
            if($(this).valid()){
                var apilink = $("#api_link").val();
                var clientkey = $("#client_secret_key").val();
                var records_to_show = $("#records_to_show").val();
                var currency = $("#currency").val();
				var finance_link = $("#finance_link").val();
                $.ajax({
                    url: dealsectorAjaxUrl,
                    type: 'POST',
                    dataType: "json",
                    data: { 
                        "action": "dealsector_saveclientkey", 
                        "api_link": apilink,
                        "client_secret_key": clientkey, 
                        "records_to_show": records_to_show,
                        "currency" : currency,
						"finance_link" : finance_link
                    },
                    success: function (response) {
                        alert(response.message);
                        if(response.error == false){
                            location.reload(true);
                        }
                    }
                });
            }
        })
        

        $("#dealsectorAddShortcodeForm").validate({
            rules: {
                sc_title: {
                    required: true
                },
                sc_code: {
                    required: true
                },
                sc_template:{
                    required: true,
                    digits: true
                },
                sc_desc:{
                    required: true
                }
            },messages: {
                sc_title: {
                    required: "Please enter shortcode title."
                },
                sc_code: {
                    required: "Please enter shortcode."
                },
                sc_template: {
                    required: "Please enter shortcode template ID."
                },
                sc_desc: {
                    required: "Please enter shortcode description."
                }
            }
        });
        $("#dealsectorAddShortcodeForm").submit(function(e){
            e.preventDefault();
            if($(this).valid()){
                var sc_title = $("#sc_title").val();
                var sc_code = $("#sc_code").val();
                var sc_template = $("#sc_template").val();
                var sc_desc = $("#sc_desc").val();
		        $.ajax({
			        url: dealsectorAjaxUrl,
			        type: 'POST',
                    dataType: "json",
			        data: { 
                        "action": "dealsector_saveshortcode", 
                        "sc_title": sc_title, 
                        "sc_code": sc_code,
                        "sc_template": sc_template,
                        "sc_desc": sc_desc 
                    },
			        success: function (response) {
				        alert(response.message);
                        if(response.error == false){
                            location.reload(true);
                        }
			        }
		        });
            }
        });
        
        $("#dealsectorStoreLocationForm").submit(function(e){
        	e.preventDefault();
           	$.ajax({
                url: dealsectorAjaxUrl,
                type: 'POST',
                dataType: "json",
                data: { 
                "action": "dealsector_storelocation"
                },
                success: function (response) {
        			alert(response.message);
                    if(response.error == false){
                    	location.reload(true);
                    }
                }
            });
        });
        
    });
});