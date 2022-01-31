<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
    <div class = "headers-places"> 
        <div class = "main-headers-txtplace"><h1><?php htmlecho ($headMain); ?> | <a href="#" onclick="history.back();">Назад</a></h1></div>
    </div>
    <div class = "main-headers-line"></div>
</div>

<div class="m-content add-main-form">
	<form action = "?<?php htmlecho ($action); ?>" method = "post">
		<div>
			<label for = "categoryname">Название категории: <input type = "text" name = "authcategoryname" id = "authcategoryname" value = "<?php htmlecho($categoryname);?>"></label>	
			<label for = "categorybonus">Бонус: <input type = "text" name = "categorybonus" id = "categorybonus" value = "<?php htmlecho($bonus);?>"></label>	 		
			<input type = "hidden" name = "idcategory" value = "<?php htmlecho($idcategory);?>">
			<input type = "submit" value = "<?php htmlecho($button);?>" class="btn_2">
		</div>
	</form>	
</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>