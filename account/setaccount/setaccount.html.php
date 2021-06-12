<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

	<div class = "maincont_for_view"> 
		
	<hr/>
	<div class = "titles_main_padge"><h4 align="center">Настройка аватара</h4></div>
	<div class ="post" align="center">
		<h6>Текущий аватар</h6>
		<p><img width = "150 px" height = "150 px" src="../../avatars/<?php echo $avatar;?>" alt="<?php echo $authorName;?>"></p>
		 <form action = "../../account/setavatar/" method = "post">
			 <input type = "hidden" name = "id" value = "<?php echo $idAuthor;?>'">
			 <input type = "submit" name = "action" class="btn btn-primary btn-sm" value = "Обновить аватар">
			 <?php echo $delAva;?>
		 </form>
	 </div>	
	 <hr/>
	<div class = "titles_main_padge"><h4 align="center">Добавить / изменить дополнительную информацию профиля</h4></div>
	<div class ="post" align="center">
		<p>Добавьте любую информацию о себе. Она будет выведена на главной странице профиля!</p>
		 <form action = "../../account/setaccountinfo/" method = "post">
			 <input type = "hidden" name = "id" value = "<?php echo $idAuthor;?>'">
			 <input type = "submit" name = "action" class="btn btn-primary btn-sm" value = "Обновить информацию профиля">
		 </form>
	 </div>
	<div class = "titles_main_padge"><h4 align="center">Смена пароля</h4></div>
	<div class ="post" align="center">
		<p>Для безопасности своей учётной записи периодически меняйте пароль!</p>
		 <form action = "../../account/changepass/" method = "post">
			 <input type = "submit" name = "action" class="btn btn-primary btn-sm" value = "Изменить пароль">
		 </form>
	 </div>	
	<?php echo $payForm;?>
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>