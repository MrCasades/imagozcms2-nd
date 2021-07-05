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
			<select name = "category" id = "category" class="search-select">
			<option value = "">Любая рубрика</option>
				<?php foreach ($categorys as $category): ?>
				<option value = "<?php htmlecho($category['id']); ?>"><?php htmlecho($category['categoryname']); ?></option>
				<?php endforeach; ?> 
			</select>
			<input type = "hidden" name = "action" value = "search"/>
			<input type = "submit" value = "Найти" class="btn_2" id="search-btn"/>
			<p>
				<input name="article_type" type="radio" value="posts" checked>Статья
				<input name="article_type" type="radio" value="promotions">Промоушен
				<input name="article_type" type="radio" value="news">Новость
			</p>
		</form>
	</div>

	<div id = "search-result"></div>				

</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>

