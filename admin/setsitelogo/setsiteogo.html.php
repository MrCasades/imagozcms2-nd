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

<div class = "m-content addupd-post">
    <a href="//<?php echo MAIN_URL;?>/admin/setsitelogo/updlogo/?main"><button class="btn_2"><strong>Основное Лого</strong></button></a>
	<a href="//<?php echo MAIN_URL;?>/admin/setsitelogo/updlogo/?adpt"><button class="btn_2"><strong>Адаптивное Лого</strong></button></a>
</div>


<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>