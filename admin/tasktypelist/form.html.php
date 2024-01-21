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
		<div>
			<label for = "tasktypename">Название тематики:</label> <input type = "text" name = "tasktypename" id = "tasktypename" value = "<?php htmlecho($tasktypename);?>">	
			<input type = "hidden" name = "idtasktype" value = "<?php htmlecho($idtasktype);?>">
			<input type = "submit" value = "<?php htmlecho($button);?>" class="btn_2">
		</div>
	</form>	
</div>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>

