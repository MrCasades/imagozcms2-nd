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
			<label for = "contest">Название конкурса: <input type = "text" name = "contestname" id = "contestname" value = "<?php htmlecho($contestname);?>"> </label>	
			<br><label for = "votingpoints">Очки за голосование: <input type = "text" name = "votingpoints" id = "votingpoints" value = "<?php htmlecho($votingpoints);?>"> </label>	
			<br><label for = "commentpoints">Очки за комментарий: <input type = "text" name = "commentpoints" id = "commentpoints" value = "<?php htmlecho($commentpoints);?>"> </label>	
			<br><label for = "favouritespoints">Очки за доб. в избранное: <input type = "text" name = "favouritespoints" id = "favouritespoints" value = "<?php htmlecho($favouritespoints);?>"> </label>	
			<br><input type = "hidden" name = "idcontest" value = "<?php htmlecho($idcontest);?>">
			<br><input type = "submit" value = "<?php htmlecho($button);?>" class="btn_2">
		</form>	
	</p>	
	<table>
		<tr>
			<th>Название</th>
			<th>За голос</th>
			<th>За комментарий</th>
			<th>За избранное</th>
			<th>Возможные действия</th>
		</tr>
		<?php if (empty ($contests))
		 { 
			 echo '<p align = "center">Категории не добавлены</p>';
		 }
		 
		 else
			 
		 foreach ($contests as $contest): ?> 
			
			<?php if ($contest['conteston'] == 'NO')
					{
						$contestOn = 'ON';
						$buttonClass_1 = 'btn_4';
					}
					
					else
					{
						$contestOn = 'OFF';
						$buttonClass_1 = 'btn_3';
					}
			
				  if ($contest['contestpanel'] == 'NO')
				    {
					 	$contestPanel = 'CP_ON'; 
					  	$buttonClass_2 = 'btn_4';
				    }
			
					else
					{
						$contestPanel = 'CP_OFF'; 
						$buttonClass_2 = 'btn_3';
					}?>
			
			<tr>
			  <form action = " " method = "post">
			   <div>
				<td><?php htmlecho($contest['contestname']);?></td>
				<td><?php htmlecho($contest['votingpoints']);?></td>
				<td><?php htmlecho($contest['commentpoints']);?></td>
				<td><?php htmlecho($contest['favouritespoints']);?></td>
				<td>
				<input type = "hidden" name = "idcontest" value = "<?php echo $contest['id']; ?>">
				<input type = "submit" name = "action" value = "Upd" class="btn_1">
				<input type = "submit" name = "action" value = "Del" id = "delobject"  class="btn_2">
				<input type = "submit" name = "action" value = "<?php echo $contestOn; ?>" class="<?php echo $buttonClass_1; ?>">
				<input type = "submit" name = "action" value = "<?php echo $contestPanel; ?>" class="<?php echo $buttonClass_2; ?>">
				</td>
			   </div>
		      </form>
			</tr>
		 <?php endforeach; ?>	
	</table>
	<p>
		<form action = " " method = "post">
			<input type = "submit" name = "action" value = "Обнулить баллы" id = "resetcontest" class="btn_2">
		</form>	
	</p>
</div>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>