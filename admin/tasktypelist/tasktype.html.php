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

<div class="m-content add-main-form">
	<p>
		<form action = "?<?php htmlecho ($action); ?>" method = "post">
			<div>
				<label for = "tasktypename">Название рубрики: <input type = "text" name = "tasktypename" id = "tasktypename" value = "<?php htmlecho($tasktypename);?>"> </label>
				<input type = "hidden" name = "idtasktype" value = "<?php htmlecho($idtasktype);?>">
				<input type = "submit" value = "<?php htmlecho($button);?>" class="btn_2">
			</div>
		</form>	
	</p>
	<table>
		<tr><th>Название</th><th>Возможные действия</th></tr>
		<?php if (!isset($tasktypes))
		 {
			 $noPosts = '<p align = "center">Типы не добавлены</p>';
			 echo $noPosts;
			 $tasktypes = null;
		 }
		 
		 else
			 
		 foreach ($tasktypes as $tasktype): ?> 
			<tr>
			  <form action = " " method = "post">
			   <div>
				<td><?php htmlecho($tasktype['tasktypename']);?></td>
				<td>
				<input type = "hidden" name = "idtasktype" value = "<?php echo $tasktype['id']; ?>">
				<input type = "submit" name = "action" value = "Upd" class="btn_1">
				<input type = "submit" name = "action" value = "Del" class="btn_2">
				</td>
			   </div>
		      </form>
			</tr>
		 <?php endforeach; ?>	
	</table>
</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>