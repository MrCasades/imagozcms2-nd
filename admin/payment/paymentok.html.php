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
	<p class = "for-info-txt">Заявка на вывод денежных средств создана</p>
	<p><a href="//<?php echo MAIN_URL;?>"><button class="btn_2 addit-btn">На главную страницу</button></a></p>
</div>
	 
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>