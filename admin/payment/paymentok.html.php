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
	<p class = "for-info-txt">Заявка на вывод денежных средств создана</p>
	<p><a href="//<?php echo MAIN_URL;?>"><button class="btn_2 addit-btn">На главную страницу</button></a></p>
</div>
	 
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>