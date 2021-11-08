<?php if (!isset($_SESSION['loggIn'])): ?>
	
<?php else:?>
	<div class = "logpanel">
		<form action = " " method = "post">
				<input type = "hidden" name = "action" value = "logout">
				<input type = "hidden" name = "goto" value = "//<?php echo MAIN_URL;?>">
				<strong><i class="fa fa-user-circle" aria-hidden="true" title="Вы вошли как"></i>: <?php echo $authorInSystem;?> | </strong> 
				<a href="//<?php echo MAIN_URL;?>/account/?id=<?php echo $selectedAuthor;?>"><button type="button" class="btn_2"><strong><i class="fa fa-user" aria-hidden="true"></i> Профиль</strong></button></a> | 
				<a href="//<?php echo MAIN_URL;?>/mainmessages/"><button type="button" class="btn_2"><strong><i class="fa fa-envelope" aria-hidden="true" class="env-main"></i><span id = "countcolor"><?php echo $unreadCount;?></span> СООБЩЕНИЯ</strong></button></a>  
				<?php echo $panel;?> | 
				<button class="btn_1"><strong><i class="fa fa-sign-out" aria-hidden="true"></i> Выйти</strong></button>
		</form> 
		<?php echo $payForms;?>
		<?php echo $allPosts.$allRefused;?>
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
