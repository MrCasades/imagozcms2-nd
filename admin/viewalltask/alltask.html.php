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
			 	<p>Тип: <?php echo $task['tasktypename'];?> | Для ранга не ниже: <?php echo $task['rangname'];?></p>				 
			 </div>
			 <div class="task-txt">
			 	<h5 class="for-info-txt"><?php htmlecho ($task['tasktitle']); ?></h5>
				<p><?php echomarkdown_pub ($task['text']); ?> [...]</p>
				<a href="../../admin/viewalltask/viewtask/?id=<?php htmlecho ($task['id']); ?>"><button class="btn_2">Далее</button></a>
		 	 </div>
		 </div>
		  		
		 <?php endforeach; ?>
		
		 <div class="page-output">	
		 <?php
			/*Постраничный вывод информации*/
			for ($i = 1; $i <= $pagesCount; $i++) 
			{
				// если текущая старница
				if($i == $page)
				{
					echo "<a href='index.php?page=$i'><button class='btn_2'>$i</button></a> ";
				} 
				else 
				{
					echo "<a href='index.php?page=$i'><button class='btn_1'>$i</button></a> ";
				}
			}?>
		 </div>	
		</div>
		<p><a name="bottom"></a></p>
</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>

