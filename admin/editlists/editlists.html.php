<?php
/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
	<div class = "main-headers-circle"></div>
	<div class = "main-headers-content">
		<h2><?php htmlecho ($headMain); ?> | <a href="#" onclick="history.back();">Назад</a></h2>
		<div class = "main-headers-line"></div>
	</div>
</div>

<div class="m-content addupd-post">
	
	<a href='//<?php echo MAIN_URL;?>/admin/authorlist/'><button class="btn_2">Управление списком авторов</button></a>
    <a href='//<?php echo MAIN_URL;?>/admin/categorylist/'><button class="btn_2">Управление списком рубрик</button></a>
	<a href='//<?php echo MAIN_URL;?>/admin/metalist/'><button class="btn_2">Управление списком тематик</button></a>
	<a href='//<?php echo MAIN_URL;?>/admin/searchpost/'><button class="btn_2">Управление статьями</button></a>
	<a href='//<?php echo MAIN_URL;?>/admin/ranglist/'><button class="btn_2">Управление рангами</button></a>
	<a href='//<?php echo MAIN_URL;?>/admin/authorcategory/'><button class="btn_2">Управление категориями авторов</button></a>
	<a href='//<?php echo MAIN_URL;?>/admin/paysystemlist/'><button class="btn_2">Управление списком платёжных систем</button></a>
	<a href='//<?php echo MAIN_URL;?>/admin/tasktypelist/'><button class="btn_2">Управление типами задания</button></a>
	<a href='//<?php echo MAIN_URL;?>/admin/promotionpricelist/'><button class="btn_2">Управление ценой промоушена</button></a>
	<a href='//<?php echo MAIN_URL;?>/admin/contest/'><button class="btn_2">Управление конкурсом</button></a>
	<a href='//<?php echo MAIN_URL;?>/admin/commentnewslist/'><button class="btn_2">Просмотр комментариев</button></a>
</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>