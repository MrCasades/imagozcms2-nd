<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

$title = 'Сотрудничество | imagoz.ru';//Данные тега <title>
$headMain = 'Сотрудничество';
$robots = 'all';
$descr = 'Информация для желающих стать автором на портале imagoz.ru';

/*Получение данных XML aliexpress с сайта https://epn.bz/*/

try
{
	$get_xml = file_get_contents('dump.yml');
	$repl_xml = preg_replace('#&(?=[a-z_0-9]+=)#', '&amp;', $get_xml);
	$xml = simplexml_load_string($repl_xml);
}

catch (PDOException $e)
{
	$error = 'Не удалось получить данные';
	include MAIN_FILE . '/includes/error.inc.php';
}

/*Вывод результата в шаблон*/
foreach ($xml as $row)
{
	$goodsAll[] =  array ('title' => $row->offers->offer->name, 'url' => $row->offers->offer->url, 'price' =>  $row->offers->offer->price, 'old_price' =>  $row->offers->offer->oldprice,
					   'disount' => $row->offers->offer->disount, 'images' => $row->offers->offer->picture);
}

/*Вывод рандомных игр*/

$shuffleKeys = array_keys($goodsAll);

shuffle($shuffleKeys);
$newGoodsAll = array();
foreach($shuffleKeys as $key) 

{
    $newGoodsAll[$key] = $goodsAll[$key];
}

$goodsView = array_slice($newGoodsAll, 0, 9);
	

include 'eshop.html.php';