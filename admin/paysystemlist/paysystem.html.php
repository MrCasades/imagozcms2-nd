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

<div class="m-content add-main-form">
	<p>
		<form action = "?<?php htmlecho ($action); ?>" method = "post">
			<div>
				<label for = "paysystemname">Название платежн. системы: <input type = "text" name = "paysystemname" id = "paysystemname" value = "<?php htmlecho($paysystemname);?>"> </label>	
				<input type = "hidden" name = "idpaysystem" value = "<?php htmlecho($idpaysystem);?>">
				<input type = "submit" value = "<?php htmlecho($button);?>" class="btn_2">
			</div>
		</form>	
	</p>
	<table>
		<tr><th>Название</th><th>Возможные действия</th></tr>
		<?php if (empty ($paysystems))
		 {
			 echo '<p class="for-info-txt">Категории не добавлены</p>';
		 }
		 
		 else
			 
		 foreach ($paysystems as $paysystem): ?> 
			<tr>
			  <form action = " " method = "post">
			   <div>
				<td><?php htmlecho($paysystem['paysystemname']);?></td>
				<td>
				<input type = "hidden" name = "idpaysystem" value = "<?php echo $paysystem['id']; ?>">
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