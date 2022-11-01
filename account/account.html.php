<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<main>
	<div class = "main-headers">
		<div class = "main-headers-circle"></div>
		<div class = "main-headers-content">
				<h2><?php htmlecho ($headMain); ?></h2>
			<div class = "main-headers-line"></div>
		</div>
	</div>

	<div class="acc-m m-content">
        <div class="ava-pl">
			<?php echo $addRole; ?>
			<?php echo $addBonus; ?>
			<?php echo $addCategory; ?>
			<?php echo $addRoleAdvertiser; ?>
			<br/>
			<?php if ($avatar !== 'ava-def.jpg'): ?>
				<img src="../avatars/<?php echo $avatar;?>" alt="<?php echo $authorName;?>">
			<?php else: ?>
				<i class="fa fa-user-circle" aria-hidden="true" title="Вы вошли как: <?php echo $authorInSystem;?>"></i>
			<?php endif; ?>
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
			<nav class="acc-menu">
				<a href="#">Главная</a>
				<a href="#">Блог</a>
				<a href="#">Публикации</a>
			</nav>
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
		<div class = "main-headers-circle"></div>
		<div class = "main-headers-content">
			<a class = "main-headers-place" href = "./viewallfavourites/?id=<?php echo $idAuthor;?>"><h2>Избранное</h2></a>
			<div class = "main-headers-line"></div>
		</div>
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

	
	<?php if (($authorRole == 'Автор') || ($authorRole == 'Администратор'))//если пользователю присвоен определённый статус, то выводятся написанные им материалы
		{
			include MAIN_FILE . '/account/postandnews.inc.html.php';
		}?>

	<div class = "main-headers">
		<div class = "main-headers-content">
			<h2 class="no-link-header">Стена (<span id="comm_count"><?php echo $countPosts; ?></span>)</h2>
			<div class = "main-headers-line"></div>				
		</div>
	</div>
	
	<?php echo $addComment; ?>

	<div id="result_form"></div>
			<?php if (empty ($comments))
				{
					echo '<br/><p class="m-content" id="not_comment">Комментарии отсутствуют!</p>';
				}
					
				else
					
				foreach ($comments as $comment): ?> 

				<div class="comment m-content">
					<div class="comment-person-pl">
						<?php if ($comment['avatar'] !== 'ava-def.jpg'): ?>

						<div> 
							<img src="../avatars/<?php echo $comment['avatar'];?>" alt="<?php echo $comment['authorname'];?>"> 
						</div>

						<?php else: ?>
							<i class="fa fa-user-circle-o" aria-hidden="true"></i> 
						<?php endif; ?>
						<div class="comment-person-name">
							<?php echo ('<a href="../account/?id='.$comment['idauthor'].'">'.$comment['authorname']).'</a>';?><br>
							<span class="comment-date"><?php echo $comment['date']; ?></span>
						</div> 
					</div>
					<p><a name="comment-<?php echo $comment['id']; ?>"></a></p>
					<div class="comment-text">
						<p><?php 
					
					//Вывод панели обновления - удаления комментария и проверка на поставленные лайки/дизлайки!
					
						if ($comment['islike'] == 1)
						{
							$likeStyle = 'fa-thumbs-up';
							$dislikeStyle = 'fa-thumbs-o-down';
						}

						elseif ($comment['isdislike'] == 1)
						{
							$likeStyle = 'fa-thumbs-o-up';
							$dislikeStyle = 'fa-thumbs-down';
						}
						else
						{
							$likeStyle = 'fa-thumbs-o-up';
							$dislikeStyle = 'fa-thumbs-o-down';
						}

						if (($selectedAuthor  == $comment['idauthor']) || (userRole('Администратор')))
						{
							$updAnddel = '<form action = "?" method = "post">
							<div>
								<input type = "hidden" name = "id" value = "'.$comment ['id'].'">
								<input type = "hidden" name = "idaut" value = "'.$comment ['idauthor'].'">
								<input type = "submit" name = "action" class="btn_2" value = "Редактировать">
								<input type = "submit" name = "action" class="btn_1" value = "Del">
							</div>
						</form>';						 
						}	
						else
						{
							$updAnddel = '';
						}							 
						
						echo $updAnddel;?></p>

						<?php echomarkdown ($comment['text']); ?>		
					</div>
					
				</div>
				<div class="comment-bottom">
					<div class="comment-ans">
						<a href="#"><button class="btn_1" id = "op_form_<?php echo $comment['id'];?>">Ответить</button></a> 
						<!-- <a href="#"><button class="btn_1" id = "load_<?php echo $comment['id'];?>"><i class="fa fa-comments-o" aria-hidden="true"></i> Ответы (<span id="subcomm_count_<?php echo $comment['id']; ?>"><?php echo $comment['subcommentcount']; ?></span>)</button></a> -->
					</div>
					<form class="comment-like" id = "like_form_<?php echo $comment['id'];?>">
						<input type = "hidden" name = "idauthor" value = "<?php echo $selectedAuthor;?>">
						<input type = "hidden" name = "idcomment" value = "<?php echo $comment['id'];?>">
						<input type = "hidden" name = "type-like" id = "type_like_<?php echo $comment['id'];?>">
						<button id="like_<?php echo $comment['id'];?>" class="comment-like-btn" name = "like" type="submit"><i id="lk_sign_<?php echo $comment['id'];?>" class="fa <?php echo $likeStyle;?>" aria-hidden="true"></i> <span id="likecount_<?php echo $comment['id'];?>"><?php echo $comment['likescount'];?></span></button>
						<button id="dislike_<?php echo $comment['id'];?>" class="comment-like-btn" name ="dislike" type="submit"><i id="dlk_sign_<?php echo $comment['id'];?>" class="fa <?php echo $dislikeStyle;?>" aria-hidden="true"></i> <span id="dislikecount_<?php echo $comment['id'];?>"><?php echo $comment['dislikescount'];?></span></button>					
					</form>

					<?php 
				/*Загрузка скрипта добавления лайков/дизлайков*/
				include MAIN_FILE . '/includes/likescript.inc.php';?>

				</div>
				<div class = "comment-line"></div>
				<div class="m-content form-pl" id = "answ_<?php echo $comment['id'];?>" style="display: none;">
					<?php if (isset($_SESSION['loggIn'])):?>
						<form id="subcomm_form_<?php echo $comment['id'];?>" method = "post">
							<textarea class = "descr mark-textarea" id = "subcomment" name = "subcomment" rows="10"></textarea>	
							<input type = "hidden" name = "idauthor" value = "<?php echo $selectedAuthor; ?>">
							<input type = "hidden" name = "idcomment" value = "<?php echo $comment['id']; ?>">
							<input type = "submit" value = "Ответить" class="btn_2 addit-btn" id="add_subcomm_<?php echo $comment['id']; ?>">  
						</form>	
					<?php else:?>
						<div class="for-info-txt">
							<a href="../admin/registration/?log">Авторизируйтесь</a> в системе или 
							<a href="../admin/registration/?reg">зарегестрируйтесь</a> для того, чтобы ответиь на комментарий!
						</div>
					<?php endif;?>
				</div> 				
				<div id="result_form_<?php echo $comment['id']; ?>"></div>
				<div id="subcomments_<?php echo $comment['id']; ?>" class="all-sub-comments"></div>
				<?php if ($comment['subcommentcount'] != 0):?>
					<div class="sub-comment-open" id="hide_open_pl_<?php echo $comment['id']; ?>">
						<!-- <a href="#" id="subcomment_hide_<?php echo $comment['id']; ?>">Скрыть</a>  -->
						<a href="../viewwallpost/?id=<?php echo $comment['id']; ?>&typeart=acc&idart=<?php echo $idAuthor; ?>">Все ответы</a>
					</div>
				<?php endif;?>
				
				<?php 
				/*Загрузка скрипта получения субкомментов в шаблон*/
				include MAIN_FILE . '/includes/subcommentloadscript.inc.php';?>

			<?php endforeach; ?>
		
		<div  class="page-output">
				 <?php
				 /*Постраничный вывод информации*/
				 for ($i = 1; $i <= $pagesCount; $i++) 
				 {
					 // если текущая старница
					 if($i == $page)
					 {
						 echo "<a href='../account/?id=".$idAuthor."&page=$i'><button class='btn_2'>$i</button></a> ";
					 } 
					 else 
					 {
						 echo "<a href='../account/?id=".$idAuthor."&page=$i'><button class='btn_1'>$i</button></a> ";
					 }
				 }?>
		</div>	
</main>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>