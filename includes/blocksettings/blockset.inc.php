<?php

$json_object = file_get_contents('../includes/blocksettings/'.$blockFolder.'.json');
$data = json_decode($json_object, true);

if($blockFolder == 'viewallnewsincat')

{
    $phrases = array('categoryname');

    foreach ($phrases as $tm)
    {
        $title = insertVar($phrases, $row[$tm], $data['title'] );
        $headMain = insertVar($phrases, $row[$tm], $data['headMain'] ); 
        $descr = insertVar($phrases, $row[$tm], $data['descr'] ); 

        if (!empty($data['breadPart1'])) 
            $breadPart1 = '<a href="//'.MAIN_URL.'">'.insertVar($phrases, $row[$tm], $data['breadPart1']).'</a> >> '; //Для хлебных крошек
        if (!empty($data['breadPart2']))
            $breadPart2 = '<a href="//'.MAIN_URL.'/'.$blockFolder.'/">'.insertVar($phrases, $row[$tm], $data['breadPart2']).'</a> ';//Для хлебных крошек
        if (!empty($data['breadPart3']))
            $breadPart3 = '>> <a href="//'.MAIN_URL.'/'.$blockFolder.'/">'.insertVar($phrases, $row[$tm], $data['breadPart3']).'</a> ';//Для хлебных крошек
    }
}

else 
{
    $title = $data['title'];
    $headMain = $data['headMain'];   
    $descr = $data['descr'];

    if (!empty($data['breadPart1'])) 
        $breadPart1 = '<a href="//'.MAIN_URL.'">'.$data['breadPart1'].'</a> >> '; //Для хлебных крошек
    if (!empty($data['breadPart2']))
        $breadPart2 = '<a href="//'.MAIN_URL.'/'.$blockFolder.'/">'.$data['breadPart2'].'</a> ';//Для хлебных крошек
    if (!empty($data['breadPart3']))
        $breadPart3 = '>> <a href="//'.MAIN_URL.'/'.$blockFolder.'/">'.$data['breadPart3'].'</a> ';//Для хлебных крошек
}

$robots = $data['robots'];

/*Замена на название категории*/
function insertVar($typeVar, $var, $text)
{
    $newText = str_replace($typeVar, $var, $text);
    return $newText;
}