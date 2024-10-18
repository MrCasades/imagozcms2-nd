<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
	<div class = "main-headers-circle"></div>
	<div class = "main-headers-content">
		<h2><?php htmlecho ($headMain); ?> | <a href="#" onclick="history.back();">Назад</a></h2>
		<div class = "main-headers-line"></div>
	</div>
</div>

<div class="m-content">
	<div class="task-pl">
		<div class="task-pl-header">
			<?php echo ($date. ' | Автор: <a href="../../../account/?id='.$authorId.'">'.$nameAuthor).'</a>';?>
			<p>E-mail: <?php echo $email;?></p>			 
		</div>
		<div class="task-txt">
			<p><?php echomarkdown ($text);?></p>
		</div>
	</div>
</div>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>