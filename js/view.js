/*
------------------------------
 Ilya Bobkov 2017(c) 
 https://github.com/heksen84
------------------------------*/
function DrawRect(ctx,x,y,text)
{	
	ctx.beginPath();
	ctx.strokeStyle = "yellow";	
	ctx.fillStyle="rgb(50,150,250)";
	ctx.fillRect(x,y,250,50);
	ctx.fillStyle="white";
	ctx.font = "10pt Arial";
	ctx.fillText(text, x+5, y+16 );	
	ctx.stroke();
}
/*
----------------------
 ТОЧКА ВХОДА
----------------------*/
function InitView()
{	    
	var canvas = document.getElementById("canvas");
	var ctx = canvas.getContext("2d");
					
		$.ajax
		({
			url: "server.php",
			data: 
			{
				"func": "SRV_Search",					
				"search_string": $("#search_string").val(),
				"date1": $("#date1").val(),
				"date2": $("#date2").val()
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
						var j=0;
						$.each(obj.string, function(i, item) 
						{							
															
							DrawRect(ctx, 0, j, item.text);							
							j = j+80;										
						});															
					}
				}
			}
		});		
}