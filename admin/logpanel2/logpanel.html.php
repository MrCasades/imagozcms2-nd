<?php if (!isset($_SESSION['loggIn'])): ?>
	
<?php else:?>
	<div class = "auth-panel">
		<form action = " " method = "post">
				<input type = "hidden" name = "action" value = "logout">
				<input type = "hidden" name = "goto" value = "//<?php echo MAIN_URL;?>">
				<strong><a href="//<?php echo MAIN_URL;?>/account/?id=<?php echo $selectedAuthor;?>"><i class="fa fa-user-circle" aria-hidden="true" title="Вы вошли как: <?php echo $authorInSystem;?>"></i></a></strong> 
				<a href="//<?php echo MAIN_URL;?>/mainmessages/"><strong><i class="fa fa-envelope" aria-hidden="true" class="env-main"></i><span id = "countcolor"><?php echo $unreadCount;?></span></strong></a>   
				<button class="btn_1"><strong><i class="fa fa-sign-out" aria-hidden="true"></i></strong></button>
		</form> 
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
