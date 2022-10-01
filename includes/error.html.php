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
		<p><?php echo $error; ?></p>
		<p><a href="#" onclick="history.back();"><button class="btn_2">Назад</button></a></p>
</div>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>