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

<div class="m-content add-main-form">
	<form action = "?<?php htmlecho ($action); ?>" method = "post">
		<label for = "contestname">Название конкурса: </label> 
		<br><input type = "text" name = "contestname" id = "contestname" value = "<?php htmlecho($contestname);?>">	
		<br><label for = "votingpoints">Очки за голосование: </label> 
		<br><input type = "text" name = "votingpoints" id = "votingpoints" value = "<?php htmlecho($votingpoints);?>">		
		<br><label for = "commentpoints">Очки за комментарии: </label>
		<br><input type = "text" name = "commentpoints" id = "commentpoints" value = "<?php htmlecho($commentpoints);?>">		
		<br><label for = "favouritespoints">Очки за доб. в избранное: </label>
		<br><input type = "text" name = "favouritespoints" id = "favouritespoints" value = "<?php htmlecho($favouritespoints);?>">		
		<p>
			<input type = "hidden" name = "idcontest" value = "<?php htmlecho($idcontest);?>">
			<input type = "submit" value = "<?php htmlecho($button);?>" class="btn_2">
		</p>
	</form>	
</div>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>