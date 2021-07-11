<?php if (!isset($_SESSION['loggIn'])): ?>
	
<?php else:?>
	<div class = "logpanel">
		<form action = " " method = "post">
				<input type = "hidden" name = "action" value = "logout">
				<input type = "hidden" name = "goto" value = "//<?php echo MAIN_URL;?>">
				<strong><i class="fa fa-user-circle" aria-hidden="true" title="Вы вошли как"></i>: <?php echo $authorInSystem;?> | </strong> 
				<a href="//<?php echo MAIN_URL;?>/account/?id=<?php echo $selectedAuthor;?>"><button type="button" class="btn_2"><strong><i class="fa fa-user" aria-hidden="true"></i> Профиль</strong></button></a> | 
				<a href="//<?php echo MAIN_URL;?>/mainmessages/#bottom"><button type="button" class="btn_2"><strong><i class="fa fa-envelope" aria-hidden="true"></i> СООБЩЕНИЯ <span id = "countcolor"><?echo $unreadCount;?></span></strong></button></a>  
				<?php echo $panel;?> | 
				<button class="btn_1"><strong><i class="fa fa-sign-out" aria-hidden="true"></i> Выйти</strong></button>
		</form> 
	</div>
	<?php echo $payForms;?>
<?php endif;?>
