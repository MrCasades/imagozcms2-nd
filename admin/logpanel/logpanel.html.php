<?php if (!isset($_SESSION['loggIn'])): ?>
	<div></div>
<?php elseif (!userRole('Автор')):?>
	<div>
		
			<form action = " " method = "post">
				<input type = "hidden" name = "action" value = "logout">
				<input type = "hidden" name = "goto" value = "//<?php echo MAIN_URL;?>">
				<strong>Вы вошли как: <?php echo $authorInSystem;?></strong> <a href="//<?php echo MAIN_URL;?>/account/?id=<?php echo $selectedAuthor;?>"><button type="button"><strong>Мой пофиль</strong></button></a> | <a href="//<?php echo MAIN_URL;?>/mainmessages/#bottom"><button type="button" class="btn_2"><strong><i class="fa fa-envelope" aria-hidden="true"></i> СООБЩЕНИЯ <span id = "countcolor"><?echo $unreadCount;?></span></strong></button></a> | <a href="//<?php echo MAIN_URL;?>/admin/panels"><button type="button" class="btn_2"><strong>Панель автора</strong></button></a> | <button class="exit-btn">Exit</button>
			</form> 
	</div>
<?php elseif (userRole('Автор')):?>
	<div>
		<strong>Профиль:</strong> <a href="//<?php echo MAIN_URL;?>/account/?id=<?php echo $selectedAuthor;?>"><strong><?php echo $authorInSystem;?></strong></a> | <a href="//<?php echo MAIN_URL;?>/mainmessages/#bottom"><button class="btn_2"><strong><i class="fa fa-envelope" aria-hidden="true"></i> СООБЩЕНИЯ <span id = "countcolor"><?echo $unreadCount;?></span></strong></button></a>
	</div>
<?php endif;?>
