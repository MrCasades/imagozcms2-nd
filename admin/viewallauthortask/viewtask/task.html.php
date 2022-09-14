<?php 

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
	<div class = "main-headers-circle"></div>
	<div class = "main-headers-content">
		<h2><?php htmlecho ($headMain); ?></h2>
		<div class = "main-headers-line"></div>
	</div>
</div>

<div class="m-content">
	<div class="task-pl">
		<div class="task-pl-header">
			<?php echo ('Дата выдачи: '.$date. ' | Задание выдал: <a href="../../../account/?id='.$authorId.'">'.$nameAuthor).'</a>';?>
			<p>Тип: <?php echo $tasktypeName;?>				 
		</div>
		<div class="task-txt">
			<h5 class="for-info-txt"><?php htmlecho ($taskTitle); ?></h5>
			<p><?php echomarkdown ($text); ?></p>
			<table>
				<td><?php echo $performTask; ?></td>
				<td><?php echo $refuse; ?></td>
			</table>
		</div>
	</div>
</div>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>