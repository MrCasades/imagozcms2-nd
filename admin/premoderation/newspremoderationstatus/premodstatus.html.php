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

<div class="m-content task-pl task-txt">
	<h3 class="for-info-txt"><?php htmlecho($premodYes); ?> "<?php htmlecho($posttitle); ?>"?</h3>
		<form action = "?<?php htmlecho($action); ?> " method = "post">
			 <table cellpadding = "5%">
				 <tr>
			 		<th>Автор публикации:</th> <th><span style="color: green"><?php htmlecho($author);?></span></th>
				 </tr>
				 <tr>
		     		<th>Гонорар:</th> <th><span style="color: red" id = "pricetext"><?php htmlecho($pricetext);?></span></th>
				 </tr>
				 <tr>
		     		<th><label for = "editbonus">Бонус / штраф </label></th>
		     		<td><input type = "text" name = "editbonus" value = "0" id = "addbonus"></td>
				 </tr>
			 </table>
			 <p><label for = "editorcomment">Комментарий редактора </label>
			<textarea class = "mark-textarea" id = "editorcomment" name = "editorcomment" rows="10"><?php htmlecho($editorcomment);?></textarea>  </p>  
			 <label for = "points">Оценка статьи </label>
			 <input type = "text" name = "points" value = "100" id = "checknum">
		     <input type = "hidden" name = "id" value = "<?php htmlecho($id); ?>">
		     <input type = "submit" name = "delete" class="btn_1 addit-btn" value = "<?php htmlecho($button); ?>" id = "confirm">
			 <a href="#" onclick="history.back();"><button class="btn_2 addit-btn" type="button">Назад</button></a>
	    </form>
		<p id = "incorr" style="color: red"></p>
</div>
	  
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>