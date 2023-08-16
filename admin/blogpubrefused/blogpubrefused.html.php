<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
	<div class = "main-headers-content">
    	<h2><?php htmlecho ($headMain); ?> | <a href="#" onclick="history.back();">Назад</a></h2>
	</div>
</div>

<div class = "main-headers">
	<div class = "main-headers-circle"></div>
		<div class = "main-headers-content">
			<h2>Публикации</h2>
			<div class = "main-headers-line"></div>
		<div class = "sub-header"><?php htmlecho ($subHeaderPost); ?></div>
	</div>
</div>

<div class="m-content">
	<?php if (empty ($pubs))
		{
			echo '<p>Отклонённые материалы отсутствуют</p>';
		}
			
		else
				
		foreach ($pubs as $pub): ?>

		<div class="task-pl">
			<div class="task-txt">
				<h3 class="for-info-txt"><?php htmlecho ($pub['title']); ?></h3>
				<div class = "main-headers">
					<div class = "main-headers-content">
						<h2>Причина отказа</h2>
						<div class = "main-headers-line"></div>>
					</div>
				</div>
				<p><?php echomarkdown ($pub['reasonrefusal']);?></p>
				<form action = "../../admin/addupdblogpublication/" method = "post">
						<input type = "hidden" name = "id" value = "<?php echo $pub['id'];?>">
						<input type = "submit" name = "action" value = "Переделать" class="btn_2">
						<input type = "submit" name = "action" value = "Del" class="btn_3">
				</form>
			</div>
		</div>		
	<?php endforeach; ?>
</div>
		
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>		