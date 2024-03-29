﻿<?php 
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

<div class="m-content add-main-form">
	<form action = "?<?php htmlecho ($action); ?>" method = "post">
	  <table>	
		<tr>
			<th>Название ранга: </th><td><input type = "text" name = "rangname" id = "rangname" value = "<?php htmlecho($rangname);?>"></td>	
		</tr> 
		<tr>
			<th>Конечное число: </th><td><input type = "text" name = "lastnumber" id = "lastnumber" value = "<?php htmlecho($lastNumber);?>"></td>	
		</tr>
		<tr>
			<th>Цена новости (1000 знаков): </th><td><input type = "text" name = "pricenews" id = "pricenews" value = "<?php htmlecho($priceNews);?>"></td>	
		</tr>
		<tr>
			<th>Цена статьи (1000 знаков): </th><td><input type = "text" name = "pricepost" id = "pricepost" value = "<?php htmlecho($pricePost);?>"></td>	
		</tr>
	  </table>	
		<div>
			<input type = "hidden" name = "id" value = "<?php htmlecho($idrang);?>">
			<input type = "submit" value = "<?php htmlecho($button);?>" class="btn_2">
		</div>
	</form>
</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>