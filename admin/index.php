<?php
$title = 'Панель администратора';//Данные тега <title>
$headMain = 'Разделы';
$robots = 'noindex, nofollow';
$descr = 'Старая панель администрироваения';?>

<?php 
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

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

<div class="m-content addupd-post">
	
	<a href='../admin/authorlist/'><button class="btn_2">Управление списком авторов</button></a>
    <a href='../admin/categorylist/'><button class="btn_2">Управление списком рубрик</button></a>
	<a href='../admin/metalist/'><button class="btn_2">Управление списком тематик</button></a>
	<a href='../admin/searchpost/'><button class="btn_2">Управление статьями</button></a>
	<a href='../admin/ranglist/'><button class="btn_2">Управление рангами</button></a>
	<a href='../admin/paysystemlist/'><button class="btn_2">Управление списком платёжных систем</button></a>
	<a href='../admin/tasktypelist/'><button class="btn_2">Управление типами задания</button></a>
	<a href='../admin/promotionpricelist/'><button class="btn_2">Управление ценой промоушена</button></a>
	<a href='../admin/contest/'><button class="btn_2">Управление конкурсом</button></a>
	<a href='../admin/commentnewslist/'><button class="btn_2">Просмотр комментариев</button></a>
	<a href='../sitemap.php' target="_blank"><button class="btn_2">Обновить карту сайта</button></a>	
</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>