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

<div class="m-content">
	<?php if (empty ($promotions))
		{
			echo '<p>Отклонённые материалы отсутствуют</p>';
		}
			
		else
				
		foreach ($promotions as $promotion): ?>

		<div class="task-pl">
			<div class="task-pl-header">
				<?php echo ($promotion['promotiondate']. ' | Автор: <a href="../../account/?id='.$promotion['idauthor'].'">'.$promotion['authorname']).'</a>';?>			 
			</div>
			<div class="task-txt">
				<h3 class="for-info-txt"><?php htmlecho ($promotion['promotiontitle']); ?></h3>
				<div class = "main-headers">
					<div class = "headers-places"> 
						<div class = "main-headers-txtplace">Причина отказа</div>
					</div>
					<div class = "main-headers-line"></div>
				</div>
				<p><?php echomarkdown ($promotion['reasonrefusal']);?></p>
				<form action = "../../admin/addupdpromotion/" method = "post">
						<input type = "hidden" name = "id" value = "<?php echo $promotion['id'];?>">
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