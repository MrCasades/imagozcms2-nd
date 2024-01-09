<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
	<div class = "main-headers-circle"></div>
	<div class = "main-headers-content">
    	<h2><?php htmlecho ($headMain); ?> | <a href="#" onclick="history.back();">Назад</a></h2>
		<div class = "main-headers-line"></div>
	</div>
</div>

<div class = "error-pl">
		<h3 class="for-info-txt"><?php htmlecho($premodYes); ?> "<?php htmlecho($posttitle); ?>"?</h3>
		<p>
			<form action = "?<?php htmlecho($action); ?> " method = "post">
				<input type = "hidden" name = "id" value = "<?php htmlecho($id); ?>">
				<br>Индексировать статью? <input type="checkbox" id="indexing" name="indexing" value = "1">
				<br>
				<input type = "submit" name = "delete" class="btn_2 addit-btn" value = "<?php htmlecho($button); ?>">
				<a href="#" onclick="history.back();"><button type="button" class="btn_1 addit-btn">Назад</button></a>
			</form>
		</p>
</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>