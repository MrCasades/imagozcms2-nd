<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
	<div class = "main-headers-content">
    	<h2><?php htmlecho ($headMain); ?>
	</div>
</div>

<div class="m-content task-pl task-txt">
	<p class="for-info-txt"><?php htmlecho($premodYes); ?> "<?php htmlecho($posttitle); ?>"?</p>
	<form action = "?<?php htmlecho($action); ?> " method = "post">		
		<label for = "reasonrefusal" class="for-info-txt">Причина отказа </label>
		<textarea class = "mark-textarea" id = "reasonrefusal" name = "reasonrefusal" rows="10"><?php htmlecho($reasonrefusal);?></textarea>	
		<p>
			<input type = "hidden" name = "id" value = "<?php htmlecho($id); ?>">
			<input type = "hidden" name = "idauthor" value = "<?php htmlecho($idAuthor); ?>">
			<input type = "hidden" name = "posttitle" value = "<?php htmlecho($posttitle); ?>">
		  	<input type = "submit" name = "delete" class="btn_1 addit-btn" value = "<?php htmlecho($button); ?>">
		  	<a href="#" onclick="history.back();"><button class="btn_2 addit-btn" type="button">Назад</button></a>
		</p>
	</form> 
</div>
		
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>