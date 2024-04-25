<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
	<div class = "main-headers-circle"></div>
	<div class = "main-headers-content">
		<h2><?php htmlecho ($headMain); ?></h2>
		<div class = "main-headers-line"></div>
	</div>
</div>

<p><a name="bottom"></a></p>
<div class="m-content">
	<!-- <div>
		<p>Пройдите процедуру регистрации в системе, для того, чтобы получить возможность оценивать материалы наших авторов, оставлять комментарии и отвечать на них. 
		   У Вас будет свой профиль, где сможете вести персональный блог на стенеи и общаться с другими пользователями.</p>

		  <p><h3>По всем вопросам:</h3>
		  	<ul>
			  <li>Telegramm: @PolyakoffArs</li>
			  <li>E-mail: imagozman@gmail.com</li>
			  <li>VKontakte: <a href="https://vk.com/id213646416" rel="nofollow">Арсений Поляков</a></li>
			</ul>
		  </p>
	</div>	 -->
	<div class="authorization-form reg-form">
	<?php if (isset($errLogin)): ?>
		<p id = "incorr" style="color: red"><strong><?php htmlecho($errLog); ?></strong></p>
	  <?php endif; ?>
	    <form action = "?<?php htmlecho ($action); ?>" method = "post">   
				<div class="send">
					Имя автора:*
					<input type = "text" name = "authorname" id = "authorname" value = "<?php htmlecho($authorname);?>">
					E-mail:*
					<input type = "text" name = "email" id = "email" value = "<?php htmlecho($email);?>">
					Пароль:*
					<input type = "password" name = "password" id = "password" value = "<?php htmlecho($password);?>">
					Повторить пароль:*
					<input type = "password" name = "password2" id = "password2" value = "<?php htmlecho($password2);?>">
					<div class="g-recaptcha" data-sitekey="<?php echo SITE_KEY;?>"></div>
					<input type = "submit" value = "<?php htmlecho($button); ?>" class="btn_1" id = "confirm">
				</div>
		</form>
	</div> 
</div>
		
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>