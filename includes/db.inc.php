<?php

/*Подключение к базе данных*/
try
{
	$pdo = new PDO('mysql:host=localhost; dbname=imagozcms8', 'root', '');//подключение к базе данных
	$pdo -> setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//поведение объекта PDO при генерации ошибок
	$pdo -> exec ('SET NAMES "utf8mb4"');// метод задающий кодировку UTF8
}

catch (PDOException $e)
{
	$error = 'No connection to Data_Base Error: ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
	include 'error.inc.php';
}
