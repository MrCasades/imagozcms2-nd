<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
    <div class = "headers-places"> 
        <div class = "main-headers-txtplace"><h1><?php htmlecho ($headMain); ?></h1></div>
    </div>
</div>

<div class="comment m-content">
    <div class="comment-text">
		<img src="../images/<?php echo $imgHead;?>" alt="<?php echo $imgAlt;?>"/>
        <?php echomarkdown ($articleText);?>
    </div>    
</div>  

<div class = "main-headers">
    <div class = "headers-places"> 
        <div class = "main-headers-txtplace">Ответы (<?php echo $countPosts; ?>) | <a href="?addcomment"><button class="btn_2">Ответить</button></a></div>
    </div>
    <div class = "main-headers-line"></div>
</div>

<?php if (empty ($subcomments))
		{
			echo '<p align="center">Ответы отсутствуют!</p>';
		}
				
	  else
				
	  foreach ($subcomments as $subcomment): ?> 

<div class="sub-comment m-content">
    <span class="sub-comment-info">
		Ответил <a href="../account/?id=<?php echo $subcomment['subidauthor']; ?>"><?php echo $subcomment['subauthorname']; ?></a> | <?php echo $subcomment['date'];?>
	  </span>
	<p><?php echomarkdown ($subcomment['text']); ?></p>
	<p><?php 
				   
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
							
			echo $updAnddel;?></p>
</div>
<div class = "m-content comment-line"></div>

<?php endforeach; ?>

<div class="page-output">
	<?php
	/*Постраничный вывод информации*/
	for ($i = 1; $i <= $pagesCount; $i++) 
	{
		// если текущая старница
		if($i == $page)
		{
			echo "<a href='../viewnews/?id=".$idComment."&page=$i'><button class='btn_2'>$i</button></a> ";
		} 
		else 
		{
			echo "<a href='../viewnews/?id=".$idComment."&page=$i'><button class='btn_1'>$i</button></a> ";
		}
	}?>
</div>	

		
				
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