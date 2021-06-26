<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
    <div class = "headers-places"> 
        <div class = "main-headers-txtplace"><h1><?php htmlecho ($headMain); echo (' <a href="//'.MAIN_URL.'/account/?id="'.$idAuthor.'>'.$authorName.'</a>');?></h1></div>
    </div>
</div>

<div class = "main-headers">
    <div class = "headers-places"> 
            <div class = "main-headers-txtplace">Аватар</div>
    </div>
    <div class = "main-headers-line"></div>
</div>

<div class="set-acc-ava-pl m-content">
	<h4>Текущий аватар</h4>
	<p><img src="../../avatars/<?php echo $avatar;?>" alt="<?php echo $authorName;?>"></p>
	<form action = "../../account/setavatar/" method = "post">
		<input type = "hidden" name = "id" value = "<?php echo $idAuthor;?>'">
		<input type = "submit" name = "action" class="btn_2" value = "Обновить аватар">
		<?php echo $delAva;?>
	</form>
</div>

<div class = "main-headers">
    <div class = "headers-places"> 
            <div class = "main-headers-txtplace">Добавить / изменить дополнительную информацию профиля</div>
    </div>
    <div class = "main-headers-line"></div>
</div>

<div class="m-content">
	<p>Добавьте любую информацию о себе. Она будет выведена на главной странице профиля!</p>
	<form action = "../../account/setaccountinfo/" method = "post">
		<input type = "hidden" name = "id" value = "<?php echo $idAuthor;?>'">
		<input type = "submit" name = "action" class="btn_2" value = "Обновить информацию профиля">
	</form>
</div>

<div class = "main-headers">
    <div class = "headers-places"> 
            <div class = "main-headers-txtplace">Смена пароля</div>
    </div>
    <div class = "main-headers-line"></div>
</div>

<div class="m-content">
	<p>Для безопасности своей учётной записи периодически меняйте пароль!</p>
	<form action = "../../account/changepass/" method = "post">
		<input type = "submit" name = "action" class="btn_2" value = "Изменить пароль">
	</form>
</div>

<?php if ((userRole('Администратор')) || (userRole('Автор')) || (userRole('Рекламодатель'))): ?>

	<div class = "main-headers">
		<div class = "headers-places"> 
				<div class = "main-headers-txtplace">Обновить платёжные реквизиты</div>
		</div>
		<div class = "main-headers-line"></div>
	</div>

	<div class="m-content">
		<p>Обновите платёжные реквизиты, чтобы получить возможность создавать заявки на вывод средств.</p>
		<form action = "../../admin/payment/" method = "post">
			<input type = "hidden" name = "id" value = "<?php echo $idAuthor;?>">
			<input type = "submit" name = "action" class="btn_2" value = "Вывести средства">
			<input type = "submit" name = "action" class="btn_1" value = "Обновить платёжные реквизиты">
		</form>
	</div>
	
<?php endif; ?>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>