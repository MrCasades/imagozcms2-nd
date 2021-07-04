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

<div class="m-content">
	<div class="search-form">
		<form action = " " method = "get">
			<input type = "text" name = "text" id = "text" class="search-text"/>
			<label for = "category"> Рубрика:</label>
			<select name = "category" id = "category" class="search-select">
			<option value = "">Любая рубрика</option>
				<?php foreach ($categorys as $category): ?>
				<option value = "<?php htmlecho($category['id']); ?>"><?php htmlecho($category['categoryname']); ?></option>
				<?php endforeach; ?> 
			</select>
			<input type = "hidden" name = "action" value = "search"/>
			<input type = "submit" value = "Найти" class="btn_2"/>
		</form>
	</div>
</div>

	<div class = "maincont_for_view">
	<div class = "post_reg_log">
	<p> <a href="<?php echo '//'.MAIN_URL.'/searchpost/';?>" class="btn btn-info">Поиск статей</a> | 
		<a href="<?php echo '//'.MAIN_URL.'/searchpromotion/';?>" class="btn btn-primary btn-sm">Поиск промоушен-статей</a> |
		<a href="<?php echo '//'.MAIN_URL.'/searchnews/';?>" class="btn btn-primary btn-sm">Поиск новостей</a></p>
	<form action = " " method = "get">
	<p>Список статей по параметрам:</p>
	 <table>
	  <div>
		<tr>
		<td><label for = "text">Содержит текст </label></td>
		<td><input type = "text" name = "text" id = "text"/></td>
		</tr>
	  </div>	 
	 <div>
		<tr>
		<td><label for = "category"> По рубрике:</label></td>
		<td>
		<select name = "category" id = "category">
		  <option value = "">Любая рубрика</option>
			<?php foreach ($categorys as $category): ?>
			 <option value = "<?php htmlecho($category['id']); ?>"><?php htmlecho($category['categoryname']); ?></option>
			<?php endforeach; ?> 
		</select>
		</td>		
		</tr>
	 </div>	
	  <div>
	    <tr>
		<td>
		<input type = "hidden" name = "action" value = "search"/>
		<input type = "submit" value = "Найти" class="btn btn-primary btn-sm"/>
		</td>
		<tr>
	  </div>
	 </table>	
	</form>	
	</div>
	</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>

