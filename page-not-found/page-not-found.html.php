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
		<p class="for-info-logo"><img src="<?php echo '//'.MAIN_URL;?>/decoration/logo2.png" alt="Ошибка 404!"></p>
		<h3 class="for-info-txt"><?php echo $pageNotFound; ?></h3>
		<p><a href="<?php echo '//'.MAIN_URL;?>"><button class="btn_2">Главная страница</button></a></p>
</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>	