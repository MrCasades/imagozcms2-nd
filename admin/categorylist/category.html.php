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
			<label for = "categoryname">Название рубрики: <input type = "text" name = "categoryname" id = "categoryname" value = "<?php htmlecho($categoryname);?>"> </label>	
			<input type = "hidden" name = "idcategory" value = "<?php htmlecho($idcategory);?>">
			<input type = "submit" value = "<?php htmlecho($button);?>" class="btn_2">
		</form>	
	</p>

	<table>
		<tr><th>Название</th><th>Возможные действия</th></tr>
		<?php if (empty($categorys))
		 {
			 echo '<p class="for-info-txt">Категории не добавлены</p>';
		 }
		 
		 else
			 
		 foreach ($categorys as $category): ?> 
			<tr>
			  <form action = " " method = "post">
			   <div>
				<td><?php htmlecho($category['categoryname']);?></td>
				<td>
				<input type = "hidden" name = "idcategory" value = "<?php echo $category['id']; ?>">
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