<?php 

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

 	
				else
				
				foreach ($metas as $meta): ?> 
			
					<a href="../viewallmetas/?metaid=<?php echo $meta['id']; ?>"><?php echomarkdown ($meta['metaname']); ?></a>
				
				<?php endforeach; ?>

			</div>
			<p><?php echo $delAndUpd; ?></p>
			<p><?php echo $premoderation; ?></p>
			<p><?php echo $convertData; ?></p>
        </div>
</article>

<?php if ($idTask != 0):?>
	<div class="m-content">
		<div class="task-pl">
			<div class="task-pl-header">
				<?php echo ('Дата выдачи: '.$taskDate);?>				 
			</div>
			<div class="task-txt">
				<h5 class="for-info-txt">Техническое задание #<?php echo $taskId;?> "<?php echo $taskTitle;?>"</h5>
				<p><?php echomarkdown ($taskDescription); ?></p>
			</div>
		</div>
	</div>

<?php else:?>
	<p class = "for-info-txt"><strong>Материал админа или супер-автора.</strong></p>
<?php endif;?>
					
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>