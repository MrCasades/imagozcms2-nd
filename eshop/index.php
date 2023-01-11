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
	$xml = simplexml_load_file ('dump.yml');
}

catch (PDOException $e)
{
	$error = 'Не удалось получить данные';
	include MAIN_FILE . '/includes/error.inc.php';
}

/*Вывод результата в шаблон*/
foreach ($xml as $row)
{
	$goodsAll[] =  array ('title' => $row->name, 'url' => $row->url, 'price' =>  $row->price, 'old_price' =>  $row->oldprice,
					   'disount' => $row->disount, 'images' => $row->picture);
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