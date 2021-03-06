<?php 

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

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

<div class="m-content form-pl txt-area-block fixed-txt-area">
	<form action = "?<?php htmlecho($action); ?> " method = "post">	
		<strong>Введите текст записи</strong><br>
		<textarea class = "descr mark-textarea" id = "comment" name = "comment" rows="10"><?php htmlecho($text);?></textarea>	
	  <div>
		<input type = "hidden" name = "idautin" value = "<?php htmlecho($idAutIn); ?>">  
		<input type = "hidden" name = "id" value = "<?php htmlecho($id); ?>">
		<p><input type = "submit" value = "<?php htmlecho($button); ?>" class="btn_2 addit-btn">
		<a href="#" onclick="history.back();"><button type="button" class="btn_1 addit-btn">Назад</button></a></p>
	  </div>	  
	</form>	
</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>