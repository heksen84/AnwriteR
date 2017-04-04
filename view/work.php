<!---------------------------- 
 Ilya Bobkov 2017(c) 
 https://github.com/heksen84
------------------------------>
<!-- styles -->
<link href = "css/lib/jquery-ui.min.css" 				rel="stylesheet"/>
<link href = "css/lib/sweet-alert.css"   				rel = "stylesheet"/>
<link href = "css/lib/bootstrap-datepicker3.min.css"  	rel="stylesheet">
<link href = "css/work.css?<?php echo time()?>" 		rel="stylesheet"/>

<!-- libs -->
<script src = "js/lib/sweet-alert.min.js"></script>      
<script src = "js/lib/jquery.msg.js"></script>
<script src="js/lib/moment.min.js"></script>
<script src="js/lib/jquery-ui.min.js"></script>
<script src="js/lib/bootstrap-datepicker.min.js"></script>
<script src="js/lib/bootstrap-datepicker.ru.min.js"></script>
<script src="js/work.js?<?php echo time()?>"></script>

<!-- меню -->
<nav class="navbar navbar-inverse" style="background-color: rgb(50,50,100)">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" id="nav_bar_button">
  <span class="navbar-toggler-icon" style="font-size:16px;"></span>
  </button>
  <a class="navbar-brand" href="#" id="user_name">&nbsp;</a>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">            	  	  
	<li class="nav-item">
        <a class="nav-link" href="#" id="menu_view">представления</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="" id="menu_exit">выход</a>
      </li>      
    </ul>
  </div>
</nav>

<!-- Диалог редактирования записи -->
<div class="modal fade" id="RecordEditWindow">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" style="margin:auto">правка</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="закрыть">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">		
        <textarea class="form-control" id="RecordEditTextarea" style="height:130px"></textarea>
      </div>
      <div class="modal-footer" style="margin:auto">
        <button type="button" class="btn btn-primary" id="RecordSave">сохранить</button>        
      </div>
    </div>
  </div>
</div>

<!-- контейнер -->
<div class="container" id="work_container">
<div class="row" id="main_row">		
	<div class="col-md-12">
	<textarea class="form-control" id="text" maxlength="128" placeholder="запись..."></textarea>
	</div>
	<div class="col-md-12">
	<input type="text" class="form-control" placeholder="связь" maxlength="75" id="link">	
	</div>			
	<div class="col-md-12">
	<select class="form-control" id="record_show_mode">
	<option value="0">видят все</option>
	<option value="1">вижу только я</option>	
	</select>
	</div>
	<div class="col-md-12" id="col_recs_array"></div>	
	<div class="col-md-12" id="col_save_button"><button class="btn btn-primary" id="button_add_record">сохранить</button>	
	</div>
	<div class="col-md-12" id="search_col">	
	<h4><ins>поиск</ins></h4>		
	<input type="text" class="form-control" style="width:300px;margin:auto" placeholder="введите текст..." id="search_string"></input>
	
	<h6 id="period_title">период</h6>
	<div class="col-md-12">	
	<input type="text" id="date1" class="date_input" placeholder="начало"></input>	
	<input type="text" id="date2" class="date_input" placeholder="окончание"></input>
	</div>
	
	<div><button class="btn btn-success" id="button_search" style="margin-top:12px">найти</button></div>
	</div>	
	<div class="col-md-12" id="search_col">	
	<table id="search_results_table" style="width:100%;text-align:center">
	<thead></thead>
	<tbody></tbody>
	</table>	
	</div>
</div>
</div>
<div class="full_window" id="view_window"></div>  