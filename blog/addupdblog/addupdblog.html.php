<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
	<div class = "main-headers-circle"></div>
	<div class = "main-headers-content">
		<h2><?php htmlecho ($headMain); ?> | <a href="#" onclick="history.back();">Назад</a></h2>
		<div class = "main-headers-line"></div>
	</div>
</div>

<div class="m-content">
<p class="for-info-txt"><strong><?php htmlecho($errorForm); ?></strong></p>
	
	<form action = "?<?php htmlecho($action); ?> " method = "post">
	<div>
	 <label for = "blogtitle">Введите заголовок</label>
	 <br><input type = "blogtitle" name = "blogtitle" id = "blogtitle" value = "<?php htmlecho($blogtitle);?>">
	</div>
	<br>
	<div>
		<label for = "description">Добавьте описание своего блога</label><br>
		<textarea class = "mark-textarea" id = "description" name = "description" rows="10"><?php htmlecho($description);?></textarea>	
	 </div>
	 <hr/>
	  <div>
		<input type = "hidden" name = "id" value = "<?php htmlecho($id); ?>">
		<input type = "submit" value = "<?php htmlecho($button); ?>" class="btn_2">
	  </div>	  
	</form>	
</div>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>	