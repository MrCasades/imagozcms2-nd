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
							$avatarUnr = '<img src="../avatars/'.$unreadMessage['avafr'].'" alt="'.$authorNameUnr.'">';
							$dialogLinkUnr = '<a href="../mainmessages/viewmainmessages/?id='.$idAuthorUnr.'#bottom">'.$authorNameUnr.'</a>';
							$messageDateUnr = $unreadMessage['mainmessagedate'];
							$unrMessages = '';

							echo '<div class = "for-unr-mess">'; 
							echo $avatarUnr.'&nbsp';
							echo '<span class="unr-mess-txt">'.$dialogLinkUnr.'&nbsp';
							echo $messageDateUnr.'</span>';
							echo '</div>';	  
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
</div>
	
	<div class = "messenger"> 
		
		  
	<h5 align = "center">Список всех диалогов</h5>	 
		  
		 <?php 
		  //var_dump($dialogs);
		  
		 if (empty ($dialogs))
		 {
			 echo 'Список диалогов пуст';
		 }
			
		 else
			 
		 foreach ($dialogs as $dialog): ?> 
		  
		  <?php 
		  
		  
					if (($dialog['idfrom'] != $selectedAuthor) && ($dialog['firstmessage'] == "YES"))
					{
						
							$idAuthor = $dialog['idfrom'];
							$authorName = $dialog['authorfrom'];
							$avatar = '<img width = "40 px" height = "40 px" src="../avatars/'.$dialog['avafr'].'" alt="'.$authorName.'">';
							$dialogLink = '<a href="../mainmessages/viewmainmessages/?id='.$idAuthor.'#bottom">'.$authorName.'</a>';
					}
					
					elseif (($dialog['idto'] != $selectedAuthor) && ($dialog['firstmessage'] == "YES"))
					{
						
							$idAuthor = $dialog['idto'];
							$authorName = $dialog['authorto'];
							$avatar = '<img width = "40 px" height = "40 px" src="../avatars/'.$dialog['avato'].'" alt="'.$authorName.'">';
							$dialogLink = '<a href="../mainmessages/viewmainmessages/?id='.$idAuthor.'#bottom">'.$authorName.'</a>';
					}
		  
				   else
					{
						$idAuthor = '';
							$authorName = '';
							$avatar = '';
							$dialogLink = '';
				    }
				?>
		  <table>	  
		 	<td width = "70 px"><?php echo $avatar;?></td>
			<td width = "70 px"><?php echo $dialogLink;?></td>
		  </table>	  
		 <?php endforeach; ?>
		 
		</div>   
		
		<p><a name="bottom"></a></p>
		
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>