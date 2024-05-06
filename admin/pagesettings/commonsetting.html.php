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
            <input type="checkbox" name = "difflinks" id = "difflinks" value = "<?php htmlecho($data['difflinks']);?>" <?php if ($data['difflinks'] == "on") echo "checked";?>><label for = "difflinks">Показывать блок ссылок в шапке сайта</label>
            <hr/>
            <input type="checkbox" name = "mainmenu" id = "mainmenu" value = "<?php htmlecho($data['mainmenu']);?>" <?php if ($data['mainmenu'] == "on") echo "checked";?>><label for = "mainmenu">Показывать главное меню в шапке сайта</label>
            <hr/>
        </div>

        <div>	
            <input type = "submit" value = "<?php htmlecho($button); ?>" class="btn_2" id="confirm">
        </div> 
    </form>	
</div>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>	