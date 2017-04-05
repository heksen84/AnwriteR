<!---------------------------- 
 Ilya Bobkov 2017(c) 
 https://github.com/heksen84
------------------------------>
<link href="css/main.css?<?php echo time()?>" rel="stylesheet"/>
<script src="js/main.js?<?php echo time()?>"></script>

<div class="full_window" id="main_window"></div> 

<section class="canvas-wrap">
<div class="canvas-content">
 
 <!------[ CONTAINER ]------>
<div class="container">
<!-- Диалог регистрации -->
<div class="modal fade" id="RegWindow">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" style="margin:auto">регистрация</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="закрыть">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">		
        <label for="login" id="label_login">Логин</label>
		<input type="text" class="form-control input" id="login" placeholder="Введи логин">		
		<label for="email">Email</label>
		<input type="email" class="form-control input" id="email" placeholder="Введи email">
		<label for="password">Пароль</label>
		<input type="password" class="form-control input" id="password" placeholder="Введи пароль">
      </div>
      <div class="modal-footer" style="margin:auto">
        <button type="button" class="btn btn-primary" id="reg">регистрация</button>        
      </div>
    </div>
  </div>
</div>

<!-- Основные элементы -->
<div class="row" id="main_row">
	<div class="col-md-12 text-center">
	<h1 id="title">AnwriteR</h1>	
	<div id="desc">все мысли как на ладони</div>	
	<label for="login" id="label_login">Логин</label>
	<input type="text" class="form-control input" id="auth_login" placeholder="Введи логин">
	<label for="password">Пароль</label>
	<input type="password" class="form-control input" id="auth_password" placeholder="Введи пароль">
	<a href="#" class="nav-link" id="reg_link">регистрация</a>
	<button class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg" id="button_auth">вход</button>
	</div>
</div>
</div>
</div>
<div id="canvas" class="gradient"></div>
</section>

<!-- libs -->
<script src="js/lib/animate/three.min.js"></script>
<script src="js/lib/animate/projector.js"></script>
<script src="js/lib/animate/canvas-renderer.js"></script>
<script src="js/lib/animate/3d-lines-animation.js"></script>
<script src="js/lib/animate/color.js"></script>