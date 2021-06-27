<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
    <div class = "headers-places"> 
        <div class = "main-headers-txtplace"><h1><?php htmlecho ($headMain); ?></h1></div>
    </div>
</div>

<div class="m-content form-pl">
	<form action = "?<?php htmlecho ($action); ?>" method = "post">
		<p><strong>Имя автора:</strong> <?php htmlecho($authorname);?></p>	
		<p><strong>E-mail:</strong> <?php htmlecho($email);?></p>		
		<p><strong>WWW:</strong> <input type = "text" name = "www" id = "www" value = "<?php htmlecho($www);?>"></p>	
		<div>
			<h3>Дополнительная информация:</h3>
			<textarea class = "descr" id = "accountinfo" name = "accountinfo" data-provide="markdown" rows="10"><?php htmlecho($accountinfo);?></textarea>	
		</div>		 
		<p>
			<input type = "hidden" name = "id" value = "<?php htmlecho($idauthor);?>">
			<input type = "submit" value = "<?php htmlecho($button);?>" class="btn_2">
			<a href="#" onclick="history.back();"><button type="button" class="btn_1">Назад</button></a>
		</p>
	</form>
</div>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>