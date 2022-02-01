<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
    <div class = "headers-places"> 
        <div class = "main-headers-txtplace"><h1><?php htmlecho ($headMain); ?></h1></div>
    </div>
    <div class = "main-headers-line"></div>
</div>

<div class = "error-pl">
	<p class = "for-info-txt"><strong><?php htmlecho($errorForm); ?></strong></p>
	
	<form action = "?<?php htmlecho($action); ?> " method = "post">
	<div>
	 	<h3> Рубрика:<span style = "color: red"> *</span></h3>
		<select name = "category" id = "category">
		  <option value = "">Выбрать</option>
			<?php foreach ($categorys as $category): ?>
			 <option value = "<?php htmlecho($category['id']); ?>"
			 <?php if ($category['id'] == $idcategory)
			 {
				 echo 'selected';
			 }				 
			  ?>><?php htmlecho($category['authcategoryname']); ?></option>
			<?php endforeach; ?> 
		</select>	
	 </div>	
	  <div>
		<input type = "hidden" name = "id" value = "<?php htmlecho($idauthor); ?>">
		<input type = "submit" value = "<?php htmlecho($button); ?>" class="btn_2 addit-btn">
		<a href="#" onclick="history.back();"><button type="button" class="btn_1 addit-btn">Назад</button></a>
	  </div>
     	  
	</form>	
</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>	