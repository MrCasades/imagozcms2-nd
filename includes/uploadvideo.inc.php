<?php

/*Загрузка файла (тест)*/
	
	/*Извлечение расширения файла*/
	
if (preg_match ("/\.(mp4|MP4)$/", $_FILES['upload']['type']))
{
	$ext = '.mp4';
}
	
elseif (preg_match ('/^video\/p?webm$/i', $_FILES['upload']['type']))
{
	$ext = '.webm';
}
	
elseif (preg_match ('/^video\/p?ogv$/i', $_FILES['upload']['type']))
{
	$ext = '.ogv';
}
	
else	
{
	$ext = '.unk';
}
		
$VideoFileName = $fileNameVideoScript.$ext;//присвоение имени файла
$videoFilePath = MAIN_FILE . $filePathVideoScript . $VideoFileName;//путь загрузки
		
if (!is_uploaded_file($_FILES['uploadvideo']['tmp_name']) or !copy($_FILES['uploadvideo']['tmp_name'], $videoFilePath))
{
	$VideoFileName = '';
}