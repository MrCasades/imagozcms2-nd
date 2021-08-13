<?php


/*Загрузка главного пути*/
include_once './includes/path.inc.php';

/*Директория для загрузки файла*/

define("UPLOADDIR", MAIN_FILE ."/picsforposts/");

/*Определение расширения*/

if (preg_match ('/^image\/p?jpeg$/i', $_FILES['fileToUpload']['type']))
{
	$ext = '.jpg';
}
	
elseif (preg_match ('/^image\/p?gif$/i', $_FILES['fileToUpload']['type']))
{
	$ext = '.gif';
}
	
elseif (preg_match ('/^image\/p?png$/i', $_FILES['fileToUpload']['type']))
{
	$ext = '.png';
}
	
else	
{
	$ext = '.unk';
}

// Detect if it is an AJAX request
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $file = array_shift($_FILES);

    $file['name'] = 'pc-'.time().rand(11, 99).$ext;//Имя файла

    if(move_uploaded_file($file['tmp_name'], UPLOADDIR . basename($file['name']))) 
    {
        $file ='//'. MAIN_URL."/picsforposts/" . $file['name'];
        $data = array(
            'message' => 'uploadSuccess',
            'file'    => $file,
        );
    } 
    
    else 
    
    {
        $error = true;
        $data = array(
            'message' => 'uploadError',
        );
    }
} 

else 

{
    $data = array(
        'message' => 'uploadNotAjax',
        'formData' => $_POST
    );
}



echo json_encode($data);