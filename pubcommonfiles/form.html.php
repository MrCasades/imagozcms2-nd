<?php 

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

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

<div class="m-content form-pl">
<form action = "?<?php htmlecho($action); ?> " method = "post">
	 <div>
		<label for = "comment">Введите текст комментария</label><br>
		<input type = "hidden" name = "idarticle" value = "<?php htmlecho($idArticle); ?>">
		<textarea class = "descr mark-textarea" id = "comment" name = "comment" rows="10"><?php htmlecho($text);?></textarea>	
	 </div>
	 <hr/>	
	  <div>
		<input type = "hidden" name = "id" value = "<?php htmlecho($id); ?>">
		<p><input type = "submit" value = "<?php htmlecho($button); ?>" class="btn_2 addit-btn">
		<a href="#" onclick="history.back();"><button type="button" class="btn_1 addit-btn">Назад</button></a></p>
	  </div>	  
</form>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>