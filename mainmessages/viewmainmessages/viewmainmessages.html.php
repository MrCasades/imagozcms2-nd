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
		
		<p><a name="bottom"></a></p>
		
  <form class="m-content comment-form" action = "?<?php htmlecho ($action); ?>" method = "post" enctype="multipart/form-data" autocomplete="on">
	<table> 
	 <div>
	  <tr>
		<td><label for = "upload">Загрузите файл изображения</label><input type = "file" name = "upload" id = "upload"></td>
		<td><input type = "hidden" name = "action" value = "upload"></td>
	  </tr>		 
	</div>
	</table>	
	 <div>
		<label for = "promotion">Введите текст сообщения</label><br>
		<textarea class = "descr" id = "text" name = "text" data-provide="markdown" rows="10"><?php htmlecho($text);?></textarea>	
	 </div>
	  <div>
		<input type = "hidden" name = "idto" value = "<?php echo $toDialog; ?>">
		<input type = "submit" name = "addform" value = "<?php htmlecho($button); ?>" class="btn_2">
	  </div>	
	</form>		
</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>