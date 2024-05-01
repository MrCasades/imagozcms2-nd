<?php if (!isset($_SESSION['loggIn'])): ?>
	
<?php else:?>
	<div class = "profile-panel">
		<div class="profile-btn">
			<?php if ($avatarPB !== ''): ?>
				<img src="//<?php echo MAIN_URL;?>/avatars/<?php echo $avatarPB;?>" alt="<?php echo $authorInSystem;?>">
			<?php else: ?>
				<i class="fa fa-user-circle" aria-hidden="true" title="Вы вошли как: <?php echo $authorInSystem;?>"></i>
			<?php endif; ?>
			<span class="profile-name"><?php echo $authorInSystem;?></span>
		</div>

		<div class="profile-menu">
			<a href="//<?php echo MAIN_URL;?>/account/?id=<?php echo $selectedAuthor;?>"><i class="fa fa-user-circle" aria-hidden="true"></i> Профиль</a>
			<a href="//<?php echo MAIN_URL;?>/mainmessages/"><i class="fa fa-envelope" aria-hidden="true" class="env-main"></i><span id = "countcolor"><?php echo $unreadCount;?></span> Сообщения</a>
			<?php echo $panel;?>
			<?php echo $payForms;?>
			<?php echo $allRefused.$allPosts;?>
			<form action = " " method = "post" class="logout-form">
				<input type = "hidden" name = "action" value = "logout">
				<input type = "hidden" name = "goto" value = "//<?php echo MAIN_URL;?>">  
				<br><button class="btn_1"><strong><i class="fa fa-sign-out" aria-hidden="true"></i>Выход</strong></button>
			</form>
		</div>
		
	</div>
	
	<script>
		//Цвет непрочитанных сообщений
		
		countsViewAndColor("#countcolor", "red");
		
		function countsViewAndColor(idcount, color) 
		{
			const countMess = document.querySelector(idcount); 
			const countVal = countMess.innerHTML;
					
			if (parseInt(countVal) > 0)
			{
				countMess.style.color = (color);
					   countMess.innerHTML = "["+countVal+"]";
			} 
	
			else if (parseInt(countVal) === 0) 
			{
				countMess.innerHTML = "";
			}
		}
	</script>
<?php endif;?>
