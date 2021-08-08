<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
    <div class = "headers-places"> 
        <div class = "main-headers-txtplace"><h1><?php htmlecho ($headMain); ?> | <a href="#" onclick="history.back();">Назад</a></h1></div>
    </div>
    <div class = "main-headers-line"></div>
</div>

<div class="m-content">
	<?php if (empty ($tasks))
		 {
			 echo '<h4 class="for-info-txt">Задания пока отсутствуют!</h4>';
		 }
		 
		 else
			 
		 foreach ($tasks as $task): ?> 

		<div class="task-pl">
			 <div class="task-pl-header">
			 	<?php echo ('Дата выдачи: '.$task['taskdate']. ' | Задание выдал: <a href="../../account/?id='.$task['idauthor'].'">'.$task['authorname']).'</a>';?>
			 	<p>Тип: <?php echo $task['tasktypename'];?></p>				 
			 </div>
			 <div class="task-txt">
			 	<h5 class="for-info-txt"><?php htmlecho ($task['tasktitle']); ?></h5>
				<p><?php echomarkdown (implode(' ', array_slice(explode(' ', strip_tags($task['text'])), 0, 50))); ?> [...]</p>
				<a href="../../admin/viewallauthortask/viewtask/?id=<?php htmlecho ($task['id']); ?>"><button class="btn_2">Далее</button></a>
		 	 </div>
		 </div>		
		 <?php endforeach; ?>
</div>
		
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>

