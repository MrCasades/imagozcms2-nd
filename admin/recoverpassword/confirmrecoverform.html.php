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
		<strong>Введите код подтверждения из письма:</strong> <input type = "text" name = "rekey" id = "rekey" value = "<?php htmlecho($reKey);?>">
		<input type = "hidden" name = "tikey" id = "tikey" value = "<?php htmlecho($tiKey);?>">
		<input type = "submit" value = "<?php htmlecho($button);?>" class="btn_2">
	</form>		
</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>