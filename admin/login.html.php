<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';


/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
	<div class = "main-headers-circle"></div>
	<div class = "main-headers-content">
		<h2><?php htmlecho ($headMain); ?></h2>
		<div class = "main-headers-line"></div>
	</div>
</div>


<div class="m-content">
	<div class="authorization-form">
	<?php if (isset($errLogin)): ?>
		<p style="color: red"><strong><?php htmlecho($errLogin); ?></strong></p>
	  <?php endif; ?>
		<form action = " " method = "post">   
				<div class="send">
					<input type="text" placeholder="e-mail" name = "email" id = "email">
					<input type="password" placeholder="password" name = "password" id = "password">
					<input type = "hidden" name = "action" value = "login">
					<button class="btn_1">Вход</button>
				</div>
			<div class="reg-group">
				<a href="//<?php echo MAIN_URL;?>/admin/registration/?reg#bottom">Регистрация</a> 
				<a href="//<?php echo MAIN_URL;?>/admin/recoverpassword/?send">Забыли пароль?</a>
			</div>  
		</form>
	</div> 
</div>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>

