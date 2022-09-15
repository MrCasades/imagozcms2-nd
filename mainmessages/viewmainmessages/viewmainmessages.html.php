<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
	<div class = "main-headers-circle"></div>
	<div class = "main-headers-content">
    	<h2><?php htmlecho ($headMain); ?> | <a href="//<?php echo MAIN_URL;?>/mainmessages/">Назад</a></h2>
		<div class = "main-headers-line"></div>
	</div>
</div>

<div class = "m-content">
	<?php if (empty($mainmessages))
		 {
			 echo '<p>Сообщения отсутствуют.</p>';
		 }
		 
		 else
			 
		 foreach ($mainmessages as $mainmessage): ?> 
			<div>
				
				<?php 
					/*Переменные для вывода Ваших сообщений и ответов на них*/
					if (isset($mainmessage['idfrom']))
					{
						$messDate = $mainmessage['mainmessagedate'].' ';
						$idAuthor = $mainmessage['idfrom'];
						$authorName = $mainmessage['authorfrom'];
						$messText = $mainmessage['mainmessage'];
					}
					
					elseif (isset($mainmessage['idto']))
					{
						$messDate = $mainmessage['mainmessagedate'].' ';
						$idAuthor = $mainmessage['idto'];
						$authorName = $mainmessage['authorto'];
						$messText = $mainmessage['mainmessage'];
					}
				
					/*Переменные для стилей заголовков*/
					if ($mainmessage['idto'] == $selectedAuthor)
					{
						$messagePlStyle = 'mess-pl-style-to';
						$typeMessage = '<strong>Вам написали </strong>';
						$deleteForm = '';
						$accountLink = '<a href="../../account/?id='.$idAuthor.'">'.$authorName.'</a>';
					}

					elseif ($mainmessage['idfrom'] == $selectedAuthor)	
					{
						$messagePlStyle = 'mess-pl-style-fr';
						$typeMessage = '<strong>Вы ответили </strong>';	
						$deleteForm = '<div class="del-mess"><form action = "..\..\mainmessages\addupdmainmessage\ " method = "post">
										<input type = "hidden" name = "idmessage" value = "'.$mainmessage['idmess'].'">
						<input type = "submit" name = "action" value = "X" class="btn_1">
		      		</form></div>';
						$accountLink = '';
					}
				?>
						
				<div class = "<?php echo $messagePlStyle;?>">
				  <span class = "mess-header">
				    <?php echo $typeMessage.$messDate.$accountLink;?>
				  </span>
					<?php echo $deleteForm;?>
				   <div class = "mess-text">
					<?php if ($mainmessage['imghead'] == '')
					{
						$img = '';//если картинка в заголовке отсутствует
						echo $img;
					}
						else 
					{
						$img = '<p><img src="../../formessages/'.$mainmessage['imghead'].'"></p>';//если картинка присутствует
					}?>	
					<p><?php echo $img;?></p>
				    <p><?php echomarkdown ($messText); ?></p>
				   </div>	
				 </div>	
			</div>		
		 <?php endforeach; ?>	
		 <div id="result_form"></div>
		<p><a name="bottom"></a></p>
		
  <form class="m-content comment-form" action = "?<?php htmlecho ($action); ?>" method = "post" autocomplete="on" id="mess-form">	
	 <div>
		<label for = "promotion">Введите текст сообщения</label><br>
		<textarea class = "descr mark-textarea" id = "text" name = "text" rows="10"><?php htmlecho($text);?></textarea>	
	 </div>
	  <div>
	  	<input type = "hidden" name = "idfr" value = "<?php echo $selectedAuthor; ?>">
		<input type = "hidden" name = "idto" value = "<?php echo $toDialog; ?>">
		<input type = "submit" name = "addform" value = "<?php htmlecho($button); ?>" class="btn_2 send-mess-dtn" id="send-mess">
	  </div>	
	</form>		
</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>