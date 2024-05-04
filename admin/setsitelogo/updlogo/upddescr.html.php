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
	<p>
        <form action = "?<?php htmlecho($action); ?> " method = "post">
            
            <label for = "altTxt">Alt-текст для Лого</label>
            <br><input type = "text" name = "altTxt" id = "altTxt" value = "<?php htmlecho($dataLogo['altTxt']);?>" style = "width: 100%">
            <hr/>
            <label for = "titleLogo">Title для Лого</label>
            <br><input type = "text" name = "titleLogo" id = "titleLogo" value = "<?php htmlecho($dataLogo['titleLogo']);?>" style = "width: 100%">
            <hr/>
            <div>		
                <input type = "submit" value = "<?php htmlecho($button); ?>" class="btn_2" id="confirm">
            </div> 
        </form>	
	</p>
</div>
	

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>	