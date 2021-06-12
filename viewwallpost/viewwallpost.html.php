<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>
	
	<div class = "maincont_for_view"> 
			<div align = "center"><script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
			<script src="//yastatic.net/share2/share.js"></script>
			<div class="ya-share2" data-services="collections,vkontakte,facebook,odnoklassniki,moimir,twitter,lj"></div></div>
		
		<div>
		<?php if (empty ($comments))
		 {
			 echo '<p align = "center">Записи отсутствуют</p>';
		 }
		 
		 else
			 
		 foreach ($comments as $comment): ?> 
		  
			<div>
				
				<div class = "post">
				  <div class = "posttitle">
				    Дата записи: <?php echo ($comment['date']. ' | Автор: <a href="../account/?id='.$comment['idauthor'].'" style="color: white" >'.$comment['authorname']).'</a>';?>
				  </div>
				   <div class = "newstext">
					   <?php if ($comment['imghead'] == '')
						{
							$img = '';//если картинка в заголовке отсутствует
							echo $img;
						}
							else 
						{
							$img = '<p align="center"><img width = "40%" height = "20%" src="../images/'.$comment['imghead'].'"'. ' alt="'.$comment['imgalt'].'"'.'></p>';//если картинка присутствует
						}?>
					<p><?php echo $img;?></p>
					<p align = "justify"><?php echomarkdown ($comment['text']); ?></p>
				   </div>	
				 </div>
			</div>			
		 <?php endforeach; ?>
		 
		 <div align="center"><h4>Ответы (<?php echo $countPosts; ?>)</h4>
		 <a href="?addcomment" class="btn btn-primary">Ответить</a></div>
		<div>
		<?php if (empty ($subcomments))
				{
					echo '<p align="center">Ответы отсутствуют!</p>';
				}
				
			  else
				
				foreach ($subcomments as $subcomment): ?> 	   		
				<div class = "post">
				 <legend><h6><strong>Ответил <a href="../account/?id=<?php echo $subcomment['subidauthor']; ?>"><?php echo $subcomment['subauthorname']; ?></a></strong> <?php echo $subcomment['date'];?></h6> </legend>		
				  <p><?php echomarkdown ($subcomment['text']); ?></p>
				  
				   <?php 
				   
						/*Вывод меню редактирования и удаления комментария для автора*/
						 if (isset($_SESSION['loggIn']))
						 {
							$authorName = authorLogin ($_SESSION['email'], $_SESSION['password']);//имя автора вошедшего в систему
						 }
						 else
						 {
							 $authorName = '';
						 }
						 if ($authorName == $subcomment['subauthorname'])
						 {
							 $updAnddel = '<form action = "?" method = "post">
								<div>
									<input type = "hidden" name = "id" value = "'.$subcomment ['subid'].'">
									<input type = "submit" name = "action" class="btn btn-primary btn-sm" value = "Редактировать">
									<input type = "submit" name = "action" class="btn btn-primary btn-sm" value = "Del">
								</div>
							</form>';		 
						 }	
						 else
						 {
							 $updAnddel = '';
						 }							 
							
						 echo $updAnddel;?>
				</div>	  		   
				<?php endforeach; ?> 
				
				<div align = "center">
				 <?php
				 /*Постраничный вывод информации*/
				 for ($i = 1; $i <= $pagesCount; $i++) 
				 {
					 // если текущая старница
					 if($i == $page)
					 {
						 echo "<a href='../viewnews/?id=".$idComment."&page=$i' class='btn btn-info'>$i</a> ";
					 } 
					 else 
					 {
						 echo "<a href='../viewnews/?id=".$idComment."&page=$i' class='btn btn-primary btn-sm'>$i</a> ";
					 }
				 }?>
				 </div>				
		</div>		
		</div>
	</div>		

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>