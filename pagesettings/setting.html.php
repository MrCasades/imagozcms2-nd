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

<div class="m-content">
<p class="for-info-txt"><strong><?php htmlecho($errorForm); ?></strong></p>
	
	<form action = "?<?php htmlecho($action); ?> " method = "post">
	<div>
	 <label for = "title">Тег title<span style = "color: red"> *</span></label>
	 <br><input type = "text" name = "title" id = "title" value = "<?php htmlecho($data['title']);?>" style = "width: 100%">
	</div>
	<div>
	 <label for = "descr">Тег description<span style = "color: red"> *</span></label>
	 <br><input type = "text" name = "descr" id = "descr" value = "<?php htmlecho($data['descr']);?>" style = "width: 100%">
	</div>
	<div>
	 <label for = "header">Заголовок</label>
	 <br><input type = "text" name = "header" id = "header" value = "<?php htmlecho($data['headMain']);?>" style = "width: 100%">
	</div>
	<hr/>
	<!-- <div>
	    <h3>Выберете файл изображения для шапки</h3>
		<input type = "file" name = "upload" id = "upload">
		<input type = "hidden" name = "action" value = "upload">
	</div>
	<hr/>
	<div>
	    <h3>Выберете файл изображения для аватара</h3>
		<input type = "file" name = "uploadavatar" id = "uploadavatar">
		<input type = "hidden" name = "action" value = "uploadavatar">
	</div>
	<hr/> -->
	<div>
		<label for = "about">Добавьте описание сайта</label><br>
		<textarea class = "mark-textarea" id = "about" name = "about" rows="10"><?php htmlecho($data['about']);?></textarea>	
	</div>		 
	 <hr/>	
	<div>
		<h3> Индексация:<span style = "color: red"> *</span></h3>
		<select name = "robots" id = "robots">
		  <!-- <option value = "">Выбрать</option> -->
		  <option value = "all" <?php if ($data['robots'] == 'all') echo 'selected';?>>all</option>
		  <option value = "noindex, nofollow" <?php if ($data['robots'] == 'noindex, nofollow') echo 'selected';?>>noindex, nofollow</option>noindex, follow
		  <option value = "noindex, follow" <?php if ($data['robots'] == 'noindex, follow') echo 'selected';?>>noindex, follow</option>
		</select>		 	
	 </div> 
	 <hr/>
	<div>	
		<input type = "hidden" name = "blockfolder" value = <?php htmlecho($blockFolder);?>>	
		<input type = "submit" value = "<?php htmlecho($button); ?>" class="btn_2" id="confirm">
	</div> 
</form>	
</div>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>	