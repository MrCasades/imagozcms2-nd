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
	<?php if (!empty ($data['breadPart1'])):?>
	<div>
		<label for = "bread1">Хлебные крошки главная<span style = "color: red"> *</span></label>
	 	<br><input type = "text" name = "bread1" id = "bread1" value = "<?php htmlecho($data['breadPart1']);?>" style = "width: 100%">
	</div>	
	<?php endif; ?>

	<?php if (!empty ($data['breadPart1'])):?>
	<div>
		<label for = "bread2">Хлебные крошки вкладка 2<span style = "color: red"> *</span></label>
	 	<br><input type = "text" name = "bread2" id = "bread2" value = "<?php htmlecho($data['breadPart2']);?>" style = "width: 100%">
	</div>	
	<?php endif; ?>

	<?php if (!empty ($data['breadPart3'])):?>
	<div>
		<label for = "bread3">Хлебные крошки вкладка 3<span style = "color: red"> *</span></label>
	 	<br><input type = "text" name = "bread3" id = "bread3" value = "<?php htmlecho($data['breadPart3']);?>" style = "width: 100%">
	</div>	
	<?php endif; ?>

	<?php if (!empty ($data['newsblock'])):?>
	<div>
		<input type="checkbox" name = "newsblock" id = "newsblock" value = "<?php htmlecho($data['newsblock']);?>" <?php if ($data['newsblock'] == "on") echo "checked";?>><label for = "newsblock">Показывать блок новостей</label>
		<hr/>
	</div>	
	<?php endif; ?>	

	<?php if (!empty ($data['recommendations'])):?>
	<div>
		<input type="checkbox" name = "recommendations" id = "recommendations" value = "<?php htmlecho($data['recommendations']);?>" <?php if ($data['recommendations'] == "on") echo "checked";?>><label for = "recommendations">Показывать блок рекомендаций</label>
		<hr/>
	</div>	
	<?php endif; ?>

	<?php if (!empty ($data['blogpubs'])):?>
	<div>
		<input type="checkbox" name = "blogpubs" id = "blogpubs" value = "<?php htmlecho($data['blogpubs']);?>" <?php if ($data['blogpubs'] == "on") echo "checked";?>><label for = "blogpubs">Показывать блок публикаций блога</label>
		<hr/>
	</div>	
	<?php endif; ?>


	<?php if (!empty ($data['recommendations'])):?>
	<div>
		<input type="checkbox" name = "posts" id = "posts" value = "<?php htmlecho($data['posts']);?>" <?php if ($data['posts'] == "on") echo "checked";?>><label for = "posts">Показывать блок статей</label>
		<hr/>
	</div>	
	<?php endif; ?>

	<?php if (!empty ($data['video'])):?>
	<div>
		<input type="checkbox" name = "video" id = "video" value = "<?php htmlecho($data['video']);?>" <?php if ($data['video'] == "on") echo "checked";?>><label for = "video">Показывать блок видео</label>
		<hr/>
	</div>	
	<?php endif; ?>

	<?php if (!empty ($data['promotion'])):?>
	<div>
		<input type="checkbox" name = "promotion" id = "promotion" value = "<?php htmlecho($data['promotion']);?>" <?php if ($data['promotion'] == "on") echo "checked";?>><label for = "promotion">Показывать блок промоушена</label>
		<hr/>
	</div>	
	<?php endif; ?>

	<?php if (!empty ($data['viewabout'])):?>
	<div>
		<input type="checkbox" name = "viewabout" id = "viewabout" value = "<?php htmlecho($data['viewabout']);?>" <?php if ($data['viewabout'] == "on") echo "checked";?>><label for = "viewabout">Показывать блок описания</label>
		<hr/>
	</div>	
	<?php endif; ?>
	
	<?php if (!empty ($data['about'])):?>
	<div>
		<label for = "about">Добавьте описание сайта</label><br>
		<textarea class = "mark-textarea-adm" id = "about" name = "about" rows="10"><?php htmlecho($data['about']);?></textarea>	
	</div>	
	<?php endif; ?>	 
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