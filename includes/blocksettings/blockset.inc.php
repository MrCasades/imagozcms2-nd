<?php

$json_object = file_get_contents('../includes/blocksettings/'.$blockFolder.'.json');
$data = json_decode($json_object, true);

$title = $data['title'];
$headMain = $data['headMain'];
$robots = $data['robots'];
$descr = $data['descr'];
$breadPart1 = '<a href="//'.MAIN_URL.'">'.$data['breadPart1'].'</a> >> '; //Для хлебных крошек
$breadPart2 = '<a href="//'.MAIN_URL.'/'.$blockFolder.'/">'.$data['breadPart2'].'</a> ';//Для хлебных крошек