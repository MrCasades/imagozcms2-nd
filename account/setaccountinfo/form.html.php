<?php 
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
	<form action = "?<?php htmlecho ($action); ?>" method = "post">
		<p><strong>Имя автора:</strong> <?php htmlecho($authorname);?></p>	
		<p><strong>E-mail:</strong> <?php htmlecho($email);?></p>		
		<p><strong>WWW:</strong> <input type = "text" name = "www" id = "www" value = "<?php htmlecho($www);?>"></p>	
		<div>
			<h3>Дополнительная информация:</h3>
			<textarea class = "mark-textarea" id = "accountinfo" name = "accountinfo" rows="10"><?php htmlecho($accountinfo);?></textarea>	
		</div>		 
		<p>
			<input type = "hidden" name = "id" value = "<?php htmlecho($idauthor);?>">
			<input type = "submit" value = "<?php htmlecho($button);?>" class="btn_2 addit-btn">
			<a href="#" onclick="history.back();"><button type="button" class="btn_1 addit-btn">Назад</button></a>
		</p>
	</form>
</div>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>