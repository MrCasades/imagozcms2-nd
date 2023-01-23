<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
	<div class = "main-headers-content">
			<h2><?php htmlecho ($headMain); echo (' <a href="//'.MAIN_URL.'/account/?id='.$idAuthor.'">'.$authorName.'</a>');?></h2>
	</div>
</div>


<div class = "main-headers">
	<div class = "main-headers-circle"></div>
	<div class = "main-headers-content">
		<h2 class="no-link-header">Аватар</h2>
		<div class = "main-headers-line"></div>				
	</div>
</div>

<div class="set-acc-ava-pl m-content">
	<h4>Текущий аватар</h4>
	<p>
		<?php if ($avatar !== ''): ?>
				<img src="../../avatars/<?php echo $avatar;?>" alt="<?php echo $authorName;?>">
		<?php else: ?>
				<i class="fa fa-user-circle" aria-hidden="true" title="Вы вошли как: <?php echo $authorInSystem;?>"></i>
		<?php endif; ?>
	</p>
	<form action = "../../account/setavatar/" method = "post">
		<input type = "hidden" name = "id" value = "<?php echo $idAuthor;?>'">
		<input type = "submit" name = "action" class="btn_2 addit-btn" value = "Обновить аватар">
		<?php echo $delAva;?>
	</form>
</div>


<div class = "main-headers">
	<div class = "main-headers-circle"></div>
	<div class = "main-headers-content">
		<h2 class="no-link-header">Добавить / изменить дополнительную информацию профиля</h2>
		<div class = "main-headers-line"></div>				
	</div>
</div>

<div class="m-content">
	<p>Добавьте любую информацию о себе. Она будет выведена на главной странице профиля!</p>
	<form action = "../../account/setaccountinfo/" method = "post">
		<input type = "hidden" name = "id" value = "<?php echo $idAuthor;?>'">
		<input type = "submit" name = "action" class="btn_2 addit-btn" value = "Обновить информацию профиля">
	</form>
</div>


<div class = "main-headers">
	<div class = "main-headers-circle"></div>
	<div class = "main-headers-content">
		<h2 class="no-link-header">Смена пароля</h2>
		<div class = "main-headers-line"></div>				
	</div>
</div>

<div class="m-content">
	<p>Для безопасности своей учётной записи периодически меняйте пароль!</p>
	<form action = "../../account/changepass/" method = "post">
		<input type = "submit" name = "action" class="btn_2 addit-btn" value = "Изменить пароль">
	</form>
</div>

<?php if ((userRole('Администратор')) || (userRole('Автор')) || (userRole('Рекламодатель'))): ?>
	
	<div class = "main-headers">
		<div class = "main-headers-circle"></div>
		<div class = "main-headers-content">
			<h2 class="no-link-header">Обновить платёжные реквизиты</h2>
			<div class = "main-headers-line"></div>				
		</div>
	</div>

	<div class="m-content">
		<p>Обновите платёжные реквизиты, чтобы получить возможность создавать заявки на вывод средств.</p>
		<form action = "../../admin/payment/" method = "post">
			<input type = "hidden" name = "id" value = "<?php echo $idAuthor;?>">
			<input type = "submit" name = "action" class="btn_2 addit-btn" value = "Вывести средства">
			<input type = "submit" name = "action" class="btn_1 addit-btn" value = "Обновить платёжные реквизиты">
		</form>
	</div>
	
<?php endif; ?>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>