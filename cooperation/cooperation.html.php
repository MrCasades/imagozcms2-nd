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

<div class="m-content">
	<p class="for-info-logo"><img src="<?php echo '//'.MAIN_URL;?>/logomain.png" alt="imagoz.ru | Сотрудничество"></p>
	<div class="for-info-font">
		<?php echo $cooperation; ?>
	</div>
</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>	