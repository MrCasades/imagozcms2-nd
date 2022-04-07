<?php 
$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
$headMain = 'Ошибка данных!';
$robots = 'noindex, nofollow';
$descr = '';
$error = $error.' '.$e -> getMessage();// вывод сообщения об ошибке в переменой $e
include MAIN_FILE . '/includes/error.html.php';
exit();