<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
	<div class = "main-headers-circle"></div>
	<div class = "main-headers-content">
    	<h2><?php htmlecho ($headMain); ?> | <a href="#" onclick="history.back();">Назад</a></h2>
		<div class = "main-headers-line"></div>
	</div>
</div>

<p class = "for-info-txt"> <a href="<?php echo '//'.MAIN_URL.'/admin/commentnewslist/';?>" class="btn btn-info">Комментарии новостей</a> | 
		<a href="<?php echo '//'.MAIN_URL.'/admin/commentpostlist/';?>" class="btn btn-primary btn-sm">Комментарии статей</a> |
		<a href="<?php echo '//'.MAIN_URL.'/admin/commentpromotionlist/';?>" class="btn btn-primary btn-sm">Комментарии промоушен статей</a></p>

	<?php if (empty ($newsComments))
			{
				echo '<p class = "for-info-txt">Комментарии отсутствуют!</p>';
			}
				
			else
				
			foreach ($newsComments as $newsComment): ?> 

	<div class="comment m-content">
                <div class="comment-person-pl">
                    <div>
                        <img src="../../avatars/<?php echo $newsComment['avatar'];?>" alt="ava"/>
                    </div> 
                    <div>
						<?php echo ('<a href="../../account/?id='.$newsComment['idauthor'].'">'.$newsComment['authorname']).'</a>';?><br>
						<?php echo $newsComment['date']; ?>
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
					if (($authorName == $newsComment['authorname']) || (userRole('Администратор')))
					{
						$updAnddel = '<form action = "../../viewnews/" method = "post">
							   <input type = "hidden" name = "id" value = "'.$newsComment ['id'].'">
							   <input type = "submit" name = "action" class="btn_1" value = "Редактировать">
							   <input type = "submit" name = "action" class="btn_2" value = "Del">				   
					   </form>';		 
					}	
					else
					{
						$updAnddel = '';
					}							 
					   
					echo $updAnddel;?></p>

					<?php echomarkdown ($newsComment['text']); ?>
                </div>
				
			</div> 
			<a href="../../viewwallpost/?id=<?php echo $newsComment['id']; ?>"><button class="comment-ans btn_1"><i class="fa fa-comments-o" aria-hidden="true"></i> Ответы (<?php echo $newsComment['subcommentcount']; ?>)</button></a>
			<p class = "for-info-txt"><strong>К материалу:</strong> <a href="../../viewnews/?id=<?php htmlecho ($newsComment['idnews']); ?>"><?php htmlecho ($newsComment['newstitle']); ?></a></P>
            <div class = "m-content comment-line"></div> 

			<?php endforeach; ?>

<?php 
/*Загрузка пагинации*/
include_once MAIN_FILE . '/pubcommonfiles/pagination.inc.php';?>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>
