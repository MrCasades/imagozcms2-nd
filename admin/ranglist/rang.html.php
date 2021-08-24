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
	<p><a href = '?add'><button class="btn_2">Добавить ранг</button></a></p>
	<table>
		<tr><th>Название</th><th>Возможные действия</th></tr>
		<?php if (empty ($rangs))
		 {
			 echo '<p class="for-info-txt">Ранги не добавлены</p>';
		 }
		 
		 else
			 
		 foreach ($rangs as $rang): ?> 
			<tr> 
			  <form action = " " method = "post">
			   <div>
				<td><?php htmlecho($rang['rangname']);?></td>
				<td>
				<input type = "hidden" name = "idrang" value = "<?php echo $rang['id']; ?>">
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