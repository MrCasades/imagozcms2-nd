<?php 

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<style>
		html {background-color: #ffffff;}
	</style>
	
	<link href="<?php echo '//'.MAIN_URL.'/styles.css';?>" rel= "stylesheet" type="text/css">
	
    <title><?php echo $title; ?> </title>
	
</head>
<body>
	
		<div class = "maincont_for_window">
		<h1><?php htmlecho ($headMain); ?> </h1>
		<div class = "post">		 		
			<div class = "posttitle">
				<?php echo ('Дата выдачи: '.$date. ' | Задание выдал: <a href="../../../account/?id='.$date.'" style="color: white" >'.$nameAuthor).'</a>';?>
				<p>Тип: <?php echo $tasktypeName;?> | Для ранга не ниже: <?php echo $taskRangName;?></p>
			</div>	
			<p><?php echomarkdown ($text); ?></p>	
		</div>	
	  </div>
</body>
</html>