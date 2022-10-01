<?php 
$title = 'Сообщение';//Данные тега <title>
$headMain = 'Сообщение';
$robots = 'noindex, nofollow';
$descr = '';
$error = $error.' '.$e -> getMessage();// вывод сообщения об ошибке в переменой $e
include MAIN_FILE . '/includes/error.html.php';
exit();