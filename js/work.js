/*
------------------------------
 Ilya Bobkov 2017(c) 
 https://github.com/heksen84
------------------------------*/
var search_active=false;
var sub_levels=false;

/*
------------------------------
 Получить записи
------------------------------ */
function GetRecordList()
{						
	$.ajax
	({
        url: "server.php",
        data: {
            "func": "SRV_GetRecordList",	
        },
		async:false,
        success: function(data) 
		{				            
			obj = jQuery.parseJSON(data);
			switch(obj.answer)
			{
				case "error": error(obj.string); break;
				case "warning": warning(obj.string); break;
				case "success": 
				{										
					$( "#link" ).autocomplete
					({						
						minLength: 1,
						source: obj.string,
						select: function (event, ui) 
						{							
							event.preventDefault();																																									
							var found=false;
							if ( $(".rec_item").length > 0) {
								$(".rec_item").each(function() 
								{																
									if($(this).text() == ui.item.label)									
										found=true;																			
								});								
								if (!found) $("#col_recs_array").append("<h5 class='rec_item' data-id='"+ui.item.value+"'>"+ui.item.label+"</h5>");										
							}
							else {
								$("#col_recs_array").append("<h5 class='rec_item' data-id='"+ui.item.value+"'>"+ui.item.label+"</h5>");																																																																		
							}							
							
							$(".rec_item").click(function() {								
								$(this).remove();
							});							
							
							$(this).val("").blur();							
						},						
						change: function( event, ui ) 
						{							
							event.preventDefault();														
							$(this).val(ui.item.label);							
						}, 
						focus: function( event, ui ) 
						{
							event.preventDefault();														
							$(this).val(ui.item.label);							
						} 
					});					
				}
			}                        
        }
    });
}

/*
------------------------------------
 ТОЧКА ВХОДА
------------------------------------*/
function InitWork(user_name)
{	
	sweetAlertInitialize();
	
	$("#date1, #date2").datepicker({autoclose:true, language: 'ru' }).datepicker('update', new Date());
		
	GetRecordList();		
	
	$( "#link" ).keypress(function(e) {
		if(e.which == 13) {					
			$(this).blur();
		}
	});
		
	$( "#search_string" ).keypress(function(e) {
		if(e.which == 13) {					
			$("#button_search").click();
		}
	});
	
	/*
	---------------------------------
	   ВИД
	---------------------------------*/
	$("#menu_view").click(function() 
	{									
		$("#nav_bar_button").trigger("click");
		$("#view_window").show().load( "view/view.php", function() 
		{						
			$("#return_to_work_screen").click(function() 
			{					
				$("#view_window").hide();				
			});
			InitView();
		});
	});
	
	/* 
	---------------------------------
	   выход
	---------------------------------*/
	$("#menu_exit").click(function() 
	{					
		$("#work_screen_div").remove();
	});
			
	/* 
	---------------------------------
	   получить под уровень
	---------------------------------*/
	function GetSubLevel(rec_id)
	{				
		$.ajax
		({
			url: "server.php",
			data: 
			{
				"func": "SRV_GetSubLevel",															
				"rec_id": rec_id,																												
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
						if (obj.string != "") {
							$.each(obj.string, function(i, item) {						
							$("#search_results_table tbody").append("<tr data-root-id='"+rec_id+"' data-id='"+item.rec1_id+"' style='background:rgb(90,90,140);display:none;' class='sub_level'><td class='item_text' style='color:pink'>"+item.text+"</td><td style='color:pink'>"+item.date+"</td><td class='plus_add_item' style='color:pink'>+</td></tr>")									
							sub_levels=true;
							});											
						}
					}
				}
			}
		});				
	}
	
	/*
	-----------------------
	ПОИСК
	-----------------------*/	
	function Search()
	{						
		var rec_id 	 = null;						
		var index 	 = null;
						
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
						$("#search_results_table thead, tbody").empty();
						$("#search_results_table thead").append("<tr><th style='width:65%'>текст</th><th style='width:30%'>дата</th><th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th></tr>");						
						
						var color;
						$.each(obj.string, function(i, item) 
						{																		
							$("#search_results_table tbody").append("<tr data-id='"+item.id+"' class='root_item'><td class='item_text' style='color:"+color+"'>"+item.text+"</td><td>"+item.date+"</td><td class='plus_add_item'>+</td></tr>")
							GetSubLevel(item.id);												
						});
																								
						/* плюсик */
						$(".plus_add_item").click(function() 
						{																																		
							var this_text = $(this).parent().find(".item_text").text();
							var found=false;
							if ( $(".rec_item").length > 0) {
								$(".rec_item").each(function() 
								{																
									if($(this).text() == this_text)									
										found=true;																			
								});								
								if (!found) $("#col_recs_array").append("<h5 data-id='"+$(this).parent().data("id")+"' class='rec_item'>"+$(this).parent().find(".item_text").text()+"</h5>");																																																																								
							}
							else 
							{
								$("#col_recs_array").append("<h5 data-id='"+$(this).parent().data("id")+"' class='rec_item'>"+$(this).parent().find(".item_text").text()+"</h5>");																																																																								
							}
							
							/* удалить */
							$(".rec_item").click(function() {								
								$(this).remove();
							});							
						});
																							
						/*
						---------------------------------
						показать / скрыть под уровни
						---------------------------------*/
						$(".root_item .item_text").click(function() 
						{														
							var clicked_row_id = $(this).parent().data("id");																											
							$(".sub_level").each(function() 
							{	
								if ($(this).data("root-id") == clicked_row_id && $(this).css("display")!="table-row")
									$(this).show();
								else 
									$(this).hide();
							});													
						});

						/*
						---------------------------------
						сообщение!!!!
						---------------------------------*/
						$(".sub_level .item_text").click(function() 
						{														
							swal("под уровень!");
						});						
					}
				}
			}
		});	
	}
	
	/*
	---------------------------------------
	 ПОИСК
	---------------------------------------*/
	$("#button_search").click(function() {	
		search_active=true
		Search();	
	});
	
	/*
	------------------------------------------
	Сохранить запись
	------------------------------------------*/
	$("#button_add_record").click(function() 
	{					
		if ($("#text").val() != "") 
		{						
			var rec_items={};
			
			$( ".rec_item" ).each(function( index ) {
				rec_id = $(this).data("id");
				rec_text = $(this).text();				
				rec_items[rec_id]=rec_text
			});
			
			console.log(rec_items);
						
			$.ajax
			({
				url: "server.php",
				data: 
				{
					"func": "SRV_AddRecord",					
					"text": $("#text").val(),														
					"rec_items": rec_items,
					"tag_id": 0,														
					"tag_name":	""														
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
							$("#text").val("");																																			
							$("#col_recs_array").empty();																																			
							GetRecordList();							
							if (search_active) Search();
						}
					}
				}
			});
        }
		else swal("нет записи");
	});
}
