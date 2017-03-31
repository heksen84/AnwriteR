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

// --------------------------
// Точка входа
// --------------------------
function InitMain()
{		

	sweetAlertInitialize();				
	
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