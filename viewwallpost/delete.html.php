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
	<p class="for-info-txt">Удалить материал "<?php htmlecho($posttitle); ?>"?</p>
	<p>
		<form action = "?<?php htmlecho($action); ?> " method = "post">
			<input type = "hidden" name = "id" value = "<?php htmlecho($id); ?>">
			<input type = "hidden" name = "idcomment" value = "<?php htmlecho($idComment ); ?>">
			<input type = "submit" name = "delete" class="btn_2 addit-btn" value = "<?php htmlecho($button); ?>">
			<a href="#" onclick="history.back();"><button type="button" class="btn_1 addit-btn">Назад</button></a>
		</form>
	</p>
</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>