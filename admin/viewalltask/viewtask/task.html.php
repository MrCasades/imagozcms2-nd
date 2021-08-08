<?php 

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
    <div class = "headers-places"> 
        <div class = "main-headers-txtplace"><h1><?php htmlecho ($headMain); ?></h1></div>
    </div>
    <div class = "main-headers-line"></div>
</div>

<div class="m-content">
	<div class="task-pl">
		<div class="task-pl-header">
			<?php echo ('Дата выдачи: '.$date. ' | Задание выдал: <a href="../../../account/?id='.$authorId.'">'.$nameAuthor).'</a>';?>
			<p>Тип: <?php echo $tasktypeName;?> | Для ранга не ниже: <?php echo $taskRangName;?></p>				 
		</div>
		<div class="task-txt">
			<h5 class="for-info-txt"><?php htmlecho ($taskTitle); ?></h5>
			<p><?php echomarkdown ($text); ?></p>
			<p><?php echo $delAndUpd; ?></p>
			<p><?php echo $changeTaskStatus; ?></p>
		</div>
	</div>
</div>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>