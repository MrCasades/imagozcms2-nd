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
			  	<?php if ($dialog['unr'] > 0):?>
					<div class="unr-mess-count"><?php echo $dialog['unr'];?></div>
			 	<?php endif;?>
			  <img src="../avatars/<?php echo $dialog['ava'];?>" alt="<?php echo $dialog['authorname'];?>">&nbsp;<span class="unr-mess-txt"><?php echo $dialog['authorname'];?></span>  		
			</div>
			</a>	
		 <?php endforeach; ?>
				
	</div>   
</div>	
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>