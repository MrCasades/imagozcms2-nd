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
<p class="for-info-txt"><strong><?php htmlecho($errorForm); ?></strong></p>
	
	<form action = "?<?php htmlecho($action); ?> " method = "post" enctype="multipart/form-data" id="ajax_form">
	 <div>
		<label for = "author"> Автор:</label>
		 <?php echo $authorPost;?>
		 <?php echo $addAuthor;?>
	 </div>
	<hr/>
	<div>
		<h3>Введите заголовок <span style = "color: red"> *</span> </h3>
		<textarea id = "posttitle" name = "posttitle" rows = "3" cols = "40" placeholder = "Введите заголовок!"><?php htmlecho($posttitle);?></textarea>
		<p><span id="counttitlelen">0</span> / 200	</p>
	</div>
	<hr/>	
	 <div>
	 	<h3> Рубрика:<span style = "color: red"> *</span></h3>
		<select name = "category" id = "category">
		  <option value = "">Выбрать</option>
			<?php foreach ($categorys_1 as $category): ?>
			 <option value = "<?php htmlecho($category['idcategory']); ?>"
			 <?php if ($category['idcategory'] == $idcategory)
			 {
				 echo 'selected';
			 }				 
			  ?>><?php htmlecho($category['categoryname']); ?></option>
			<?php endforeach; ?> 
		</select>
		 <?php echo $addCatigorys;?>	
	 </div>	
	 <br>
	 <h3>Теги публикации:</h3>
	 <div id="checked-tags"></div>
	 
	 	<input type = "text" name = "tags" id = "addtags_form">
		 <button id = "tags_to_base">Добавить</button>
	 
	 <p style="color: red">Для добавления тегов нажмите "Вывести теги"</p>
	 <strong><a href = "#" id="hide_show_tags">Вывести теги</a></strong>
	 <br><fieldset id="tags_list" style="display: none">
		<legend>Список <?php echo $addMetas;?></legend>
		 <?php if (empty ($metas_1))
		 { 
			 echo '<p>Теги не добавлены</p>';
		 }
		 
		 else
			 
		foreach ($metas_1 as $meta): ?>
		 <div>
		  <label for = "meta<?php htmlecho ($meta['idmeta']);?>">
		   <input type = "checkbox" name = "metas[]" id = "meta<?php htmlecho ($meta['idmeta']);?>"
		   value = "<?php htmlecho ($meta['idmeta']);?>"
		   <?php if ($meta['selected'])
		   {
			   echo ' checked';
		   }
		   ?> title="<?php htmlecho ($meta['metaname']);?>"><?php htmlecho ($meta['metaname']);?>
		  </label>
		 </div>
		<?php endforeach; ?>
		<div id="result_form"></div> 
	 </fieldset>
	<hr/>	
	<div>
	    <strong>Загрузите файл изображения для шапки</strong><input type = "file" name = "upload" id = "upload">
		<input type = "hidden" name = "action" value = "upload">
	</div>
	<hr/>		
	<div>
		<strong>Введите alt-текст для изображения:</strong>
		<input type = "imgalt" name = "imgalt" id = "imgalt" value = "<?php htmlecho($imgalt);?>">
	</div>
	<hr/>		
	<div>
		<strong>Ссылка на видео Youtube: </strong>
		<input type = "videoyoutube" name = "videoyoutube" id = "videoyoutube" value = "<?php htmlecho($videoyoutube);?>">
	</div>
	<hr/>		
	<div>
		<strong>Краткое описание</strong><br>
		<textarea id = "description" name = "description" rows = "3" cols = "40" placeholder = "Опишите в паре предложений суть материала"><?php htmlecho($description);?></textarea>	
	 </div>
		<h5>Подсказка по разметке текста</h5>
		<ul>
		 	<li>Для вставки ссылки используйте кнопку <strong>Insert Link</strong></li>
			<li><p><strong>Для вставки изображения</strong> в текст кликните по соответствующей иконке (<strong>Image</strong>) на панели и выберете файл изображения в формате 
				<strong>jpg</strong>, <strong>png</strong> или <strong>gif</strong> на своём жёстком диске.</p>
				<p>ВАЖНО! На картинках не должно быть водяных знаков сторонних ресурсов. Само изображение желательно минимально обработать, если оно неоригинальное.
				   (Хотябы немного обрезать, отзеркалить и т.п.)</p></li>
			 <li><strong>Для вставки видео c Youtube:</strong> нажмите <strong>"Поделиться"</strong> под видео и скопируйте код из вкладки <strong>"Встроить"</strong> в нужное Вам место.</li>
		 </ul>	
	 <hr/>	

	 <?php $txtPlaceStyle = userRole('Администратор') ? 'mark-textarea-adm' : 'mark-textarea';?>
	 <div>
		<h3>Введите текст новости <span style = "color: red"> *</span></h3>
		<textarea class = "<?php htmlecho($txtPlaceStyle); ?>" id = "text" name = "text" rows="10" placeholder = "Добавьте текст"><?php htmlecho($text);?></textarea>	
	 </div>
	 <hr/>	
	  <div>
		<input type = "hidden" name = "id" value = "<?php htmlecho($id); ?>">
		<input type = "submit" value = "<?php htmlecho($button); ?>" class="btn_2" id = "confirm">
	  </div>	  
	</form>	
</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>	