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

<div class="m-content">
	<p class="for-info-logo"><img src="<?php echo '//'.MAIN_URL;?>/decoration/logo2.png" alt="imagoz.ru | Сотрудничество"></p>
	<div class="for-info-font">
		<?php echo $aboutBlogs; ?>
	</div>
</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>	