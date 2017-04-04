/*
------------------------------
 Ilya Bobkov 2017(c) 
 https://github.com/heksen84
------------------------------*/
var RegDialog = $("#RegWindow");
	
// -----------------------------------
// Обработка регистрации
// -----------------------------------
function RegisterDialogEventers()
{				
	// --- регистрация ---
	$("#reg").click(function() 
	{
		$.ajax
		({
            url: "server.php",
            data: 
			{
                "func": "SRV_RegUser",                    
                "login": $("#login").val(),
                "email": $("#email").val(),
                "password":	$("#password").val()
            },
            async: false,
            success: function(data) 
			{				
                obj = jQuery.parseJSON(data);
				switch(obj.answer)
				{
					case "error": error(obj.string); break;
					case "warning": warning(obj.string); break;
					case "success": 
					{							
						RegDialog.modal("hide");
						$("body").load( "view/work.php", function() {							
							InitWork(obj.string);
						});
					}
				}                        
            }
        });			
	});
}

function removeParam(key, sourceURL) {
    var rtn = sourceURL.split("?")[0],
        param,
        params_arr = [],
        queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
    if (queryString !== "") {
        params_arr = queryString.split("&");
        for (var i = params_arr.length - 1; i >= 0; i -= 1) {
            param = params_arr[i].split("=")[0];
            if (param === key) {
                params_arr.splice(i, 1);
            }
        }
        rtn = rtn + "?" + params_arr.join("&");
    }
    return rtn;
}


// --------------------------
// Точка входа
// --------------------------
function InitMain()
{		

	sweetAlertInitialize();				

	if (localStorage.getItem("user")!="")
	{
		swal(localStorage.getItem("text"),localStorage.getItem("user"));			
		history.replaceState({}, "", "/");
		localStorage.setItem("user", "");
		localStorage.setItem("text", "");				
	}
		
	
	// --- регистрация ---
	$("#reg_link").click(function() 
	{		
		RegDialog.modal();		
		RegisterDialogEventers();
	});
		
	// --- вход ---
	$("#button_auth").click(function() 
	{					
		$.ajax
		({
            url: "server.php",
            data: 
			{
                "func": "SRV_AuthUser",                    
                "login": $("#auth_login").val(),                
                "password":	$("#auth_password").val()
            },
            async: false,
            success: function(data) 
			{				
                obj = jQuery.parseJSON(data);				
				switch(obj.answer)
				{
					case "error": error(obj.string); break;
					case "warning": warning(obj.string); break;
					case "success": 
					{						 															
						$("body").load( "view/work.php", function() {							
							InitWork(obj.string);
						});
					}
				}                        
            }
        });		
	});
	
}