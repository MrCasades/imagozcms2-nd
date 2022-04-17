<?php

/*Загрузка файла (тест)*/
	
	/*Извлечение расширения файла*/
	
$ext = pathinfo($_FILES['uploadvideo']['name'], PATHINFO_EXTENSION);

if($ext  == 'mp4')
{

	// if (preg_match ('/^.*\.(mp4)$/i', $_FILES['uploadvideo']['type']))
	// {
	// 	$ext = '.mp4';
	// }
		
	// elseif (preg_match ('/^video\/p?webm$/i', $_FILES['uploadvideo']['type']))
	// {
	// 	$ext = '.webm';
	// }
		
	// elseif (preg_match ('/^video\/p?ogv$/i', $_FILES['uploadvideo']['type']))
	// {
	// 	$ext = '.ogv';
	// }
		
	// else	
	// {
	// 	$ext = '.unk';
	// }
			
	$VideoFileName = $fileNameVideoScript.'.'.$ext;//присвоение имени файла
	$videoFilePath = MAIN_FILE . $filePathVideoScript . $VideoFileName;//путь загрузки
			
	if (!is_uploaded_file($_FILES['uploadvideo']['tmp_name']) or !copy($_FILES['uploadvideo']['tmp_name'], $videoFilePath))
	{
		$VideoFileName = '';
	}
}