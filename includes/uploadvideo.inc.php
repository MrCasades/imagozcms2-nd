<?php

/*Загрузка файла (тест)*/
	
	/*Извлечение расширения файла*/
	
// if (preg_match ('/^image\/p?jpeg$/i', $_FILES['upload']['type']))
// {
// 	$ext = '.jpg';
// }
	
// elseif (preg_match ('/^image\/p?gif$/i', $_FILES['upload']['type']))
// {
// 	$ext = '.gif';
// }
	
// elseif (preg_match ('/^image\/p?png$/i', $_FILES['upload']['type']))
// {
// 	$ext = '.png';
// }
	
// else	
// {
// 	$ext = '.unk';
// }
		
$VideoFileName = $fileNameVideoScript;//присвоение имени файла
$videoFilePath = MAIN_FILE . $filePathVideoScript . $fileName;//путь загрузки
		
if (!is_uploaded_file($_FILES['uploadvideo']['tmp_name']) or !copy($_FILES['uploadvideo']['tmp_name'], $videoFilePath))
{
	$VideoFileName = '';
}