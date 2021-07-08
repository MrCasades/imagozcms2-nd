<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';


/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
    <div class = "headers-places"> 
        <div class = "main-headers-txtplace"><h1><?php htmlecho ($headMain); ?></h1></div>
    </div>
    <div class = "main-headers-line"></div>
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


	<!-- <p><a name="bottom"></a></p>  
	<div class = "maincont_for_view">
	 <div class = "post_reg_log" align="center">
	  <?php if (isset($errLogin)): ?>
		<p style="color: red"><strong><?php htmlecho($errLogin); ?></strong></p>
	  <?php endif; ?>	
	  <form action = " " method = "post">
	   <table cellpadding = "2">	
		<tr>
		 <th>Email: </th><td><input type = "text" name = "email" id = "email"></td>
		</tr> 		
		<tr>
		 <th>Пароль: </th><td><input type = "password" name = "password" id = "password"></td>	
		<tr>
	   </table>		
		 <br><input type = "hidden" name = "action" value = "login">
		 <input type = "submit" value = "Вход" class="btn btn-primary">
	  </form>	
     </div>	 
	 <p align="center"><a href="#" onclick="history.back();" class="btn btn-primary btn-sm">Назад</a> | <a href="../../admin/recoverpassword/?send" class="btn btn-info btn-sm">Забыли пароль?</a></p>	
	</div>		 -->

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>

