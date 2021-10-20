<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
    <div class = "headers-places"> 
        <div class = "main-headers-txtplace"><h1><?php htmlecho ($headMain); ?></h1></div>
    </div>
	<div class = "main-headers-line"></div>
</div>

<div class="messeger-pl">

	<div class = "main-headers">
		<div class = "headers-places"> 
			<div class = "main-headers-txtplace">Непрочитанные сообщения</div>
		</div>
		<div class = "comment-line"></div>
	</div>

		 	  
		<?php if (empty($unreadMessages)): ?>
		<?php	
			 echo '<p class="for-info-txt">Нет непрочитанных сообщений</p>';
			 $unrMessages = '';
		 ?>
			
		<?php else: ?>
		 
		 
		<?php foreach ($unreadMessages as $unreadMessage): ?> 
		  
		  <?php 
		  			if ($unreadMessage['idfrom'] == $selectedAuthor)
					{
						
							$idAuthorUnr = '';
							$authorNameUnr = '';
							$avatarUnr = '';
							$dialogLinkUnr = '';
							$messageDateUnr = '';
							$unrMessages = '<p class="for-info-txt">Нет непрочитанных сообщений</p>';
					}
		  
		  
					elseif ($unreadMessage['idfrom'] != $selectedAuthor)
					{
						
							$idAuthorUnr = $unreadMessage['idfrom'];
							$authorNameUnr = $unreadMessage['authorfrom'];
							$avatarUnr = '<img src="../avatars/'.$unreadMessage['avafr'].'" alt="'.$authorNameUnr.'"/>';
							$dialogLinkUnr = '<a href="../mainmessages/viewmainmessages/?id='.$idAuthorUnr.'#bottom" class="unr-mess-a">';
							$messageDateUnr = $unreadMessage['mainmessagedate'];
							$unrMessages = '';

							echo $dialogLinkUnr;
							echo '<div class = "for-unr-mess">'; 
							echo $avatarUnr.'&nbsp';
							echo '<span class="unr-mess-txt"><i class="fa fa-envelope-open" aria-hidden="true"></i> '.$authorNameUnr.'&nbsp';
							echo $messageDateUnr.'</span>';
							echo '</div></a>';	  
					}
				?>
					  
		 <?php endforeach; ?> 
		 <?php echo $unrMessages;?>
		 <?php endif; ?>

	<div class = "main-headers">
		<div class = "headers-places"> 
			<div class = "main-headers-txtplace">Список всех диалогов</div>
		</div>
		<div class = "comment-line"></div>
	</div>
    
	<div class="mess-dialogs">

	<?php 
		  //var_dump($dialogs);
		  
		 if (empty ($dialogs))
		 {
			 echo '<p class="for-info-txt">Список диалогов пуст</p>';
		 }
			
		 else
			 
		 foreach ($dialogs as $dialog): ?> 
		   <a href="../mainmessages/viewmainmessages/?id=<?php echo $dialog['idauth'];?>#bottom" class="dialog-mess-a">
		  	<div class = "for-dialogs-mess">
			  <img src="../avatars/<?php echo $dialog['ava'];?>" alt="<?php echo $dialog['authorname'];?>">&nbsp;<span class="unr-mess-txt"><?php echo $dialog['authorname'];?></span>
			</div></a>	
		 <?php endforeach; ?>
				
	</div>   
				
	<p><a name="bottom"></a></p>
	</div>	
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>