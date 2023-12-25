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
	<p class="error-log"><?php htmlecho($errorForm); ?></p>
	
	<form action = "?<?php htmlecho($action); ?> " method = "post" enctype="multipart/form-data" autocomplete="on">	
		<p><strong>Введите текст сообщения</strong></p>
		<textarea class = "descr mark-textarea" id = "text" name = "text" rows="10"><?php htmlecho($text);?></textarea>	 
		<input type = "hidden" name = "idto" value = "<?php htmlecho($idto); ?>">
		<input type = "hidden" name = "id" value = "<?php htmlecho($id); ?>">
		<p><input type = "submit" value = "<?php htmlecho($button); ?>" class="btn_2 addit-btn">
		<a href="#" onclick="history.back();"><button type="button" class="btn_1 addit-btn">Назад</button></a></p>	
	</form>	
	<p><a name="bottom"></a></p>	
</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>	