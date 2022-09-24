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

<div class = "error-pl">
	<p>
		<form action = "?<?php htmlecho($action); ?> " method = "post" enctype="multipart/form-data">
			<p class = "for-info-txt">Загрузите файл <input type = "file" name = "upload" id = "upload"></p>
			<input type = "hidden" name = "action" value = "upload">
			<input type = "hidden" name = "id" value = "<?php htmlecho($idAuthor); ?>">
			<input type = "submit" value = "<?php htmlecho($button); ?>" class="btn_2 addit-btn">
			<a href="#" onclick="history.back();"><button type="button" class="btn_1 addit-btn">Назад</button></a>
		</form>	
	</p>
</div>
	

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>		