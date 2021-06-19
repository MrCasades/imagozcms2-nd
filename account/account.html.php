<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<main>
    <div class = "main-headers">
        <div class = "headers-places"> 
            <div class = "main-headers-txtplace"><h1><?php htmlecho ($headMain); ?></h1></div>
        </div>
        <div class = "main-headers-line"></div>   
    </div>

	<div class="acc-m m-content">
        <div class="ava-pl">
			<?php echo $addRole; ?>
			<?php echo $addBonus; ?>
			<?php echo $addRoleAdvertiser; ?>
			<br/>
			<img src="../avatars/<?php echo $avatar;?>" alt="<?php echo $authorName;?>">
			<?php echo $setAccount; ?>
			<?php echo $mainMessagesForm; ?>
			<p><?php if (($authorRole === 'Автор') || ($authorRole === 'Администратор'))//если пользователю присвоен определённый статус, то выводятся его ранг
				
				{
					echo $rangView.$score.$rating;
					echo $prices;
					echo $ewallet;
				}?></p>
		</div> 
		<div class="acc-info-pl">
                <h3>Инфо</h3>
                <div>
					<?php echomarkdown ($accountInfo);?>
                </div>
                <p>
					Сайт: <?php if ($www !== '')//если автор приложил ссылку
							{
								echo '<a href="//';
								htmlecho ($www);
								echo '" rel = "nofollow">';
								htmlecho ($www);
								echo '</a>';
							}?> 
				</p>     
        </div>   
	</div> 

	<?php if (!empty ($favourites)): ?>

	<div class = "main-headers">
        <div class = "headers-places"> 
            <div class = "main-headers-place"><a href = "./viewallfavourites/?id=<?php echo $idAuthor;?>">Избранное</a></div>
        </div>
        <div class = "main-headers-line"></div>
    </div>
	
	<?php endif; ?>
	
	<div class = "newsblock m-content">
	<?php
		if (empty ($favourites)) 
				{
					echo '<div class = "m-content">Здесь отображаются материалы добавленные пользователем в избранное</div>';
					$favourites = '';
				}
		 	
			else
		 
		 foreach ($favourites as $favourite): ?>

	
            <a href = "//<?php echo $favourite['url']; ?>" class = "post-place-1" style="background-image: url(../images/<?php htmlecho ($favourite['imghead']);?>)">
                <div class = "post-top-1"><?php htmlecho ($favourite['date']);?></div>
                <div class = "post-bottom-1"> <?php htmlecho ($favourite['title']); ?></div>
            </a>
	
	<?php endforeach; ?>

	</div>
</main>
	<div class = "maincont_for_view"> 
				 
		 <div>
		  <?php if (($authorRole == 'Автор') || ($authorRole == 'Администратор'))//если пользователю присвоен определённый статус, то выводятся написанные им материалы
				{
					include MAIN_FILE . '/account/postandnews.inc.html.php';
				}?>
		</div>
	
		 <h4 align="center">Стена (<?php echo $countPosts; ?>)</h4>
		 <p align="center"><?php echo $addComment; ?></p>
		<div>
		<?php if (empty ($comments))
				{
					echo'<p align="center">Записи на стене отсутствуют!</p>';
				}
				
			  else
				
				foreach ($comments as $comment): ?> 	   		
				<div class = "post">
				 <div class = "posttitle">
				    Дата записи: <?php echo ($comment['date']. ' | Автор: <a href="../account/?id='.$comment['idauthor'].'" style="color: white" >'.$comment['authorname']).'</a>';?>
				  </div>
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
						 if ($authorName == $comment['authorname'])
						 {
							 $updAnddel = '<form action = "../account/addupdwallpost/" method = "post">
								<div>
									<input type = "hidden" name = "id" value = "'.$comment ['id'].'">
									<input type = "hidden" name = "idaut" value = "'.$comment['idauthor'].'">
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
				  <p><?php echomarkdown (implode(' ', array_slice(explode(' ', strip_tags($comment['text'])), 0, 50))); ?> [...]</p>
				  <p><img width = "5%" height = "5%" src="<?php echo '//'.MAIN_URL;?>/answers.jpg" alt="Ответы на комментарий" title="Количество ответов"> 
					  <strong>[<?php echo $comment['subcommentcount']; ?>]</strong></p>
				  <a href="../viewwallpost/?id=<?php echo $comment['id']; ?>" class="btn btn-primary btn-sm">Открыть</a>   
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
						 echo "<a href='../account/?id=".$idAuthor."&page=$i' class='btn btn-info'>$i</a> ";
					 } 
					 else 
					 {
						 echo "<a href='../account/?id=".$idAuthor."&page=$i' class='btn btn-primary btn-sm'>$i</a> ";
					 }
				 }?>
				 </div>				
	
	
		</div>
	</div>		
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>