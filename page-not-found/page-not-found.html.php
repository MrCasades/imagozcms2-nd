<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
    <div class = "headers-places"> 
        <div class = "main-headers-txtplace"><h1><?php htmlecho ($headMain); ?></h1></div>
    </div>
    <div class = "main-headers-line"></div>
</div>

<div class = "error-pl">
		<p class="for-info-logo"><img src="<?php echo '//'.MAIN_URL;?>/decoration/logo2.png" alt="Ошибка 404!"></p>
		<h3 class="for-info-txt"><?php echo $pageNotFound; ?></h3>
		<p<a href="#" onclick="history.back();"><button class="btn_2">Назад</button></a></p>
</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>	