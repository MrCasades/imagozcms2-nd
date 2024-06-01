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
            <input type="checkbox" name = "mainmenu_foot" id = "mainmenu_foot" value = "<?php htmlecho($data['mainmenu_foot']);?>" <?php if ($data['mainmenu_foot'] == "on") echo "checked";?>><label for = "mainmenu_foot">Показывать главное меню в подвале сайта</label>
            <hr/>
            <input type="checkbox" name = "difflinks_foot" id = "difflinks_foot" value = "<?php htmlecho($data['difflinks_foot']);?>" <?php if ($data['difflinks_foot'] == "on") echo "checked";?>><label for = "difflinks_foot">Показывать блок ссылок в подвале сайта</label>
            <hr/>
            <label for = "about">Добавьте данные в блок ссылок footer</label><br>
		    <textarea class = "mark-textarea-adm" id = "difflinks_foot_cont" name = "difflinks_foot_cont" rows="10"><?php htmlecho($data['difflinks_foot_cont']);?></textarea>
            <hr/>
            <input type="checkbox" name = "copyright_foot" id = "copyright_foot" value = "<?php htmlecho($data['copyright_foot']);?>" <?php if ($data['copyright_foot'] == "on") echo "checked";?>><label for = "copyright_foot">Показывать блок копирайта</label>
            <hr/>
            <label for = "about">Добавьте данные в блок копирайта</label><br>
		    <textarea class = "mark-textarea-adm" id = "copyright_foot_cont" name = "copyright_foot_cont" rows="10"><?php htmlecho($data['copyright_foot_cont']);?></textarea>
            <hr/>
            <input type="checkbox" name = "counts_foot" id = "counts_foot" value = "<?php htmlecho($data['counts_foot']);?>" <?php if ($data['counts_foot'] == "on") echo "checked";?>><label for = "counts_foot">Показывать блок счётчиков</label>
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