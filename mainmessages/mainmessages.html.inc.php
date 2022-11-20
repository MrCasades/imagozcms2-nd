  
	<div class="mess-dialogs">
		<script src="<?php echo '//'.MAIN_URL.'/jquery-3.5.1.min.js';?>"></script>
		<?php 
		  //var_dump($dialogs);
		  
		 if (empty ($dialogs))
		 {
			 echo '<p class="for-info-txt">Список диалогов пуст</p>';
		 }
			
		 else
			 
		 foreach ($dialogs as $dialog): ?>
		 <div class="dialog-mess-pl" id="d_pl_<?php echo $dialog['idauth'];?>"> 
		   <a href="../mainmessages/viewmainmessages/?id=<?php echo $dialog['idauth'];?>#bottom" class="dialog-mess-a">
		  	<div class = "for-dialogs-mess">
			  	<?php if ($dialog['unr'] > 0):?>
					<div class="unr-mess-count"><?php echo $dialog['unr'];?></div>
			 	<?php endif;?>
			  <img src="../avatars/<?php echo $dialog['ava'];?>" alt="<?php echo $dialog['authorname'];?>">&nbsp;<span class="unr-mess-txt"><?php echo $dialog['authorname'];?></span>  		
			</div>
			</a>
			<form id="dd_form_<?php echo $dialog['idauth'];?>">
				<input type = "hidden" name = "idauthor" value = "<?php echo $selectedAuthor; ?>">
				<input type = "hidden" name = "idd" value = "<?php echo $dialog['idauth'];?>">
				<button class="del-mess-btn btn_2" id="dd_<?php echo $dialog['idauth'];?>">X</button>
			</form>
		 </div>	
		<div id="result_form_<?php echo $dialog['id']; ?>"></div>
		 <?php 
			/*Загрузка скриптов работы с диалогами*/
			include MAIN_FILE . '/includes/mmesscripts.inc.php';?>

		 <?php endforeach; ?>
				
	</div>   