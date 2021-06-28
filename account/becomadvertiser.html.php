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

<div class="m-content form-pl">
	<p><?php echo $annotation; ?></p>
	<p><strong>Получение / отказ от роли рекламодателя:</strong></p>
	<form action = "?<?php htmlecho($action); ?> " method = "post">
		<input type = "hidden" name = "id" value = "<?php htmlecho($idauthor); ?>">
		<input type = "submit" name = "becomadv" class="btn_2 addit-btn" value = "<?php htmlecho($button); ?>">
		<a href="#" onclick="history.back();"><button type="button" class="btn_1 addit-btn">Назад</button></a>
	</form>
</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>