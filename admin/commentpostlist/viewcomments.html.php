<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
    <div class = "headers-places"> 
        <div class = "main-headers-txtplace"><h1><?php htmlecho ($headMain); ?> | <a href="#" onclick="history.back();">Назад</a></h1></div>
    </div>
    <div class = "main-headers-line"></div>
</div>

<p class = "for-info-txt"> <a href="<?php echo '//'.MAIN_URL.'/admin/commentnewslist/';?>" class="btn btn-info">Комментарии новостей</a> | 
		<a href="<?php echo '//'.MAIN_URL.'/admin/commentpostlist/';?>" class="btn btn-primary btn-sm">Комментарии статей</a> |
		<a href="<?php echo '//'.MAIN_URL.'/admin/commentpromotionlist/';?>" class="btn btn-primary btn-sm">Комментарии промоушен статей</a></p>

	<?php if (empty ($postComments))
			{
				echo '<p class = "for-info-txt">Комментарии отсутствуют!</p>';
			}
				
			else
				
			foreach ($postComments as $postComment): ?> 

	<div class="comment m-content">
                <div class="comment-person-pl">
                    <div>
                        <img src="../../avatars/<?php echo $postComment['avatar'];?>" alt="ava"/>
                    </div> 
                    <div>
						<?php echo ('<a href="../../account/?id='.$postComment['idauthor'].'">'.$postComment['authorname']).'</a>';?><br>
						<?php echo $postComment['date']; ?>
                    </div> 
                </div>
                <div class="comment-text">
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
					if (($authorName == $postComment['authorname']) || (userRole('Администратор')))
					{
						$updAnddel = '<form action = "../../viewpost/" method = "post">
							   <input type = "hidden" name = "id" value = "'.$postComment ['id'].'">
							   <input type = "submit" name = "action" class="btn_1" value = "Редактировать">
							   <input type = "submit" name = "action" class="btn_2" value = "Del">				   
					   </form>';		 
					}	
					else
					{
						$updAnddel = '';
					}							 
					   
					echo $updAnddel;?></p>

					<?php echomarkdown ($postComment['text']); ?>
                </div>
				
			</div> 
			<a href="../../viewwallpost/?id=<?php echo $postComment['id']; ?>"><button class="comment-ans btn_1"><i class="fa fa-comments-o" aria-hidden="true"></i> Ответы (<?php echo $postComment['subcommentcount']; ?>)</button></a>
			<p class = "for-info-txt"><strong>К материалу:</strong> <a href="../../viewpost/?id=<?php htmlecho ($postComment['idposts']); ?>"><?php htmlecho ($postComment['posttitle']); ?></a></P>
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
						echo "<a href='index.php?page=$i'><button class='btn_2'>$i</button></a> ";
					} 
					else 
					{
						echo "<a href='index.php?page=$i'><button class='btn_1'>$i</button></a> ";
					}
				}?>	
			</div>
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>
