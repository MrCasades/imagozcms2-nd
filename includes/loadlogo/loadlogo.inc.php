<?php
//Загрузка логотипа

$json_object = file_get_contents(MAIN_FILE.'/includes/blocksettings/logo.json');
$dataLogo = json_decode($json_object, true);

$logoMain = $dataLogo["logomain"];
$logoAdpt = $dataLogo["logoadpt"];
