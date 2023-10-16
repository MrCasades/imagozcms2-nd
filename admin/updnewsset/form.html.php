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
<p class="for-info-txt"><strong><?php htmlecho($errorForm); ?></strong></p>
	
	<form action = "?<?php htmlecho($action); ?> " method = "post" enctype="multipart/form-data">
	 <div>
		<label for = "author"> Автор:</label>
		 <?php echo $authorPost;?>
	 </div>
	<hr/>
	<div>
		<h3>Введите заголовок <span style = "color: red"> *</span> </h3>
		<textarea id = "articletitle" name = "articletitle" rows = "3" cols = "40" placeholder = "Введите заголовок!"><?php htmlecho($articletitle);?></textarea>
		<p><span id="counttitlelen">0</span> / 200	</p>
	</div>
	<div>
		<h3>Краткое описание</h3>
		<textarea id = "description" name = "description" rows = "3" cols = "40" placeholder = "Опишите в паре предложений суть материала"><?php htmlecho($description);?></textarea>	
	</div>
	<hr/>
	<?php if (userRole('Администратор')):?>				
	<div>
		<h3>Введите alt-текст для изображения:</h3>
		<input type = "imgalt" name = "imgalt" id = "imgalt" value = "<?php htmlecho($imgalt);?>">
	</div>
	<hr/>
	<?php endif;?>
	<hr/>
	<div>
	    <h3>Выберете файл изображения для шапки</h3>
		<div class="input-file-row">
			<label class="input-file">
				<input type = "file" name = "upload" id = "upload" accept="image/*">		
				<span>Выберите файл</span>
			</label>
			<div class="input-file-list"></div>  
		</div>
		<!-- <input type = "file" name = "upload" id = "upload"> -->
		<input type = "hidden" name = "action" value = "upload">
	</div>
	<hr/>		
		<h4><a href = "#" id="hide_show_hints">Подсказка по разметке текста</a></h4>
		 <ul id="hint_list" style="display: none">
		 	<li>Для вставки ссылки используйте кнопку <strong>Insert Link</strong></li>
			<li><p><strong>Для вставки изображения</strong> в текст кликните по соответствующей иконке (<strong>Image</strong>) на панели и выберете файл изображения в формате 
				<strong>jpg</strong>, <strong>png</strong> или <strong>gif</strong> на своём жёстком диске.</p>
				<p>ВАЖНО! На картинках не должно быть водяных знаков сторонних ресурсов. Само изображение желательно минимально обработать, если оно неоригинальное.
				   (Хотябы немного обрезать, отзеркалить и т.п.)</p></li>
			 <li><strong>Для вставки видео c Youtube:</strong> просто скопируйте ссылку на видео вида <strong>https://www.youtube.com/watch?v=IdVideo</strong> или <strong>https://youtu.be/IdVideo</strong> в нужное место в текстовом поле</li>
		 </ul>	
	 <hr/>	

	 <?php $txtPlaceStyle = userRole('Администратор') ? 'mark-textarea-adm' : 'mark-textarea';?>
	 <div class="txt-area-block fixed-txt-area">
		<h3>Введите текст публикации <span style = "color: red"> *</span></h3>
		<textarea class = "<?php htmlecho($txtPlaceStyle); ?> fixed-txt-area" id = "text" name = "articletext" rows="10" placeholder = "Добавьте текст"><?php htmlecho($text);?></textarea>	
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