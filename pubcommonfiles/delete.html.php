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
		<p class="for-info-txt">Удалить запись</p>
		<p>
			<form action = "?<?php htmlecho($action); ?> " method = "post">
				<input type = "hidden" name = "id" value = "<?php htmlecho($id); ?>">
				<input type = "hidden" name = "idarticle" value = "<?php htmlecho($idArticle); ?>">
				<input type = "submit" name = "delete" class="btn_2 addit-btn" value = "<?php htmlecho($button); ?>">
				<a href="#" onclick="history.back();"><button type="button" class="btn_1 addit-btn">Назад</button></a>
			</form>
		</p>
	</p>
</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>