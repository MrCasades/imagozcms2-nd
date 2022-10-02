<?php 

$getError = !empty($e) ? ' '.$e -> getMessage() : '';
$title = 'Сообщение';//Данные тега <title>
$headMain = 'Сообщение';
$robots = 'noindex, nofollow';
$descr = '';
$error = $error.$getError;// вывод сообщения об ошибке в переменой $e
include MAIN_FILE . '/includes/error.html.php';
exit();