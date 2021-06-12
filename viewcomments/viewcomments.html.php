<?php 

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

	<div class = "maincont">
	
	<a href="../viewpost/?addcomment" class="btn btn-primary">Добавить комментарий</a>
		
		<div>
		 <?php foreach ($comments as $comment): ?> 	   		
				<div>
				 <fieldset><legend><h6><b>Прокомментировал <?php echo $comment['authorname']; ?></b> <?php echo $comment['date'];?></h6> </legend>		
				  <p><?php echomarkdown ($comment['text']); ?></p>
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
						 if ($authorName == $comment['authorname'])
						 {
							 $updAnddel = '<form action = "../viewpost/?" method = "post">
								<div>
									<input type = "hidden" name = "id" value = "'.$comment ['id'].'">
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
			     </fieldset>
				</div>	  		   
		 <?php endforeach; ?> 
		 <?php
			/*Постраничный вывод информации*/
			for ($i = 1; $i <= $pagesCount; $i++) 
			{
				// если текущая старница
				if($i == $page)
				{
					echo "<a href='../viewcomments/?idpost=".$idPost."&page=$i' class='btn btn-info'>$i</a> ";
				} 
				else 
				{
					echo "<a href='../viewcomments/?idpost=".$idPost."&page=$i' class='btn btn-primary btn-sm'>$i</a> ";
				}
			}?>
		</div>			
	</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>	