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
			<label for = "pricename">Название ценовой категории: <input type = "text" name = "pricename" id = "pricename" value = "<?php htmlecho($pricename);?>"> </label>	
			<label for = "promotionprice">Значение: <input type = "text" name = "promotionprice" id = "promotionprice" value = "<?php htmlecho($promotionprice);?>"> </label>	
			<input type = "hidden" name = "idcategory" value = "<?php htmlecho($idpromotionprice);?>">
			<input type = "submit" value = "<?php htmlecho($button);?>" class="btn_2">
		</form>	
	</p>
	<table>
		<tr><th>Название</th><th>Значение</th><th>Возможные действия</th></tr>
		<?php if (empty ($promotionprices))
		 {
			 echo '<p align = "center">Категории не добавлены</p>';
		 }
		 
		 else
			 
		 foreach ($promotionprices as $promotionprice): ?> 
			<tr>
			  <form action = " " method = "post">
			   <div>
				<td><?php htmlecho($promotionprice['pricename']);?></td>
				<td><?php htmlecho($promotionprice['promotionprice']);?></td>
				<td>
				<input type = "hidden" name = "idpromotionprice" value = "<?php echo $promotionprice['id']; ?>">
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