<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
    <div class = "headers-places"> 
        <div class = "main-headers-txtplace"><h1><?php htmlecho ($headMain); ?></h1></div>
    </div>
</div>

<div class="m-content form-pl">
	<p><?php htmlecho($errLog);?></p>
	<form action = "?<?php htmlecho ($action); ?>" method = "post" class="fopm-margin">
		Старый пароль: <input type = "password" name = "password" id = "password" value = "<?php htmlecho($password);?>">
		<input type = "submit" value = "<?php htmlecho($button);?>" class="btn_2">
		<a href="#" onclick="history.back();"><button type="button" class="btn_1">Назад</button></a>
	</form>		
</div>
		
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>