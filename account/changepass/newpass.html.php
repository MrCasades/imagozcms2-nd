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

<div class="m-content form-pl">
	<p class="error-log"><?php htmlecho($errLog);?></p>
	<form action = "?<?php htmlecho ($action); ?>" method = "post" class="fopm-margin">
		  <table style="text-align: left;">
		   <tr>
			<th>Пароль: </th><td><input type = "password" name = "password" id = "password" value = "<?php htmlecho($password);?>"></td> 
		   </tr>
		   <tr>	 
			 <th>Повторить пароль: </th><td><input type = "password" name = "password2" id = "password2" value = "<?php htmlecho($password2);?>"></td>
		   </tr>
		   <tr>	
			 <td><input type = "submit" value = "<?php htmlecho($button);?>" class="btn_2"></td>
		   </tr>	 
		  </table>	 
	   </form>		
</div>
		
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>