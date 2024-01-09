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

<div class = "error-pl">
	<p class = "for-info-txt"><strong><?php htmlecho($errorForm); ?></strong></p>
	
	<form action = "?<?php htmlecho($action); ?> " method = "post">
	<table>	
	<div>
	  <tr>
		<td><label for = "bonus">Размер бонуса (множитель): </label></td>
		<td><input type = "bonus" name = "bonus" id = "bonus" value = "<?php htmlecho($bonus);?>"></td>
	  </tr>	
	</div>
	<div>
	  <tr>
		<td><label for = "score">Премия: </label></td>
		<td><input type = "score" name = "score" id = "score" value = "<?php htmlecho($score);?>"></td>
	  </tr>	
	</div>
	</table>
	  <div>
		<input type = "hidden" name = "id" value = "<?php htmlecho($idauthor); ?>">
		<input type = "submit" value = "<?php htmlecho($button); ?>" class="btn_2 addit-btn">
		<a href="#" onclick="history.back();"><button type="button" class="btn_1 addit-btn">Назад</button></a>
	  </div>
     	  
	</form>	
</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>	