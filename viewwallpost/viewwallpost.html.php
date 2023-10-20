<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
	<div class = "main-headers-circle"></div>
	<div class = "main-headers-content">
		<h2><?php htmlecho ($headMain); ?></h2>
		<div class = "main-headers-line"></div>
	</div>
</div>

<div class="comment m-content">
	<div class="comment-person-pl">
		<?php if ($avatar !== ''): ?>

			<div> 
				<img src="//<?php echo MAIN_URL; ?>/avatars/<?php echo $avatar;?>" alt="<?php echo $nameAuthor;?>"> 
			</div>

			<?php else: ?>
				<i class="fa fa-user-circle-o" aria-hidden="true"></i> 
			<?php endif; ?>
			<div class="comment-person-name">
				<?php echo ('<a href="../account/?id='.$authorId.'">'.$nameAuthor).'</a>';?><br>
				<span class="comment-date"><?php echo $date; ?></span>
			</div> 
	</div>
    <div class="comment-text">
		<img src="../images/<?php echo $imgHead;?>" alt="<?php echo $imgAlt;?>"/>
        <?php echomarkdown ($articleText);?>
    </div>

</div> 
<div class="comment-bottom">
	<div class="comment-ans">
		<a href="#" id = "open_form"><button class="btn_2">Ответить</button></a>
		<!-- <a href="#"><button class="btn_1" id = "load_<?php echo $comment['id'];?>"><i class="fa fa-comments-o" aria-hidden="true"></i> Ответы (<span id="subcomm_count_<?php echo $comment['id']; ?>"><?php echo $comment['subcommentcount']; ?></span>)</button></a> -->
	</div>
	
	<?php 	
		//Вывод панели обновления - удаления комментария и проверка на поставленные лайки/дизлайки!				
		if ($isLike == 1)
		{
			$likeStyle = 'fa-thumbs-up';
			$dislikeStyle = 'fa-thumbs-o-down';
		}

		elseif ($isDisLike == 1)
		{
			$likeStyle = 'fa-thumbs-o-up';
			$dislikeStyle = 'fa-thumbs-down';
		}
		else
		{
			$likeStyle = 'fa-thumbs-o-up';
			$dislikeStyle = 'fa-thumbs-o-down';
		}
	?>
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


<div class = "main-headers">
	<div class = "main-headers-content">
		<h2 class="no-link-header">Ответы (<span id="comm_count"><?php echo $countPosts; ?></span>)</h2>
		<div class = "main-headers-line"></div>				
	</div>
</div>

<div class="m-content form-pl" id = "subcomm_form" style="display: none;">
	<?php if (isset($_SESSION['loggIn'])):?>
			<form method = "post" id="addsubcomm">
				<textarea class = "descr mark-textarea" id = "subcomment" name = "subcomment" rows="10"></textarea>	
				<input type = "hidden" name = "idauthor" value = "<?php echo $selectedAuthor; ?>">
				<input type = "hidden" name = "idcomment" value = "<?php echo $idComment; ?>">
			<input type = "submit" value = "Ответить" class="btn_2 addit-btn" id="push_subcomm">  
		</form>	
	<?php else:?>
		<div class="for-info-txt">
			<a href="../admin/registration/?log">Авторизируйтесь</a> в системе или 
			<a href="../admin/registration/?reg">зарегестрируйтесь</a> для того, чтобы ответиь на комментарий!
		</div>
	<?php endif;?>
</div>
<div id="result_form_subcomm"></div>
<?php if (empty ($subcomments))
		{
			echo '<p class = "m-content" id="not_comment">Ответы отсутствуют!</p>';
		}
				
	  else
				
	  foreach ($subcomments as $subcomment): ?> 

<div class="comment m-content">
			<div class="comment-person-pl">
				<?php if ($subcomment['subavatar'] !== ''): ?>

				<div> 
					<img src="//<?php echo MAIN_URL; ?>/avatars/<?php echo $subcomment['subavatar'];?>" alt="<?php echo $subcomment['subauthorname'];?>"> 
				</div>

				<?php else: ?>
					<i class="fa fa-user-circle-o" aria-hidden="true"></i> 
				<?php endif; ?>
				<div class="comment-person-name">
					<?php echo ('<a href="../account/?id='.$subcomment['subidauthor'].'">'.$subcomment['subauthorname']).'</a>';?><br>
					<span class="comment-date"><?php echo $subcomment['date']; ?></span>
				</div> 
			</div>
			<div class="comment-text">
				<p><?php 
			
			//Вывод панели обновления - удаления комментария и проверка на поставленные лайки/дизлайки!
			
			if ($subcomment['islike'] == 1)
			{
			   $likeStyleSc = 'fa-thumbs-up';
			   $dislikeStyleSc = 'fa-thumbs-o-down';
			}

		   elseif ($subcomment['isdislike'] == 1)
		   {
			   $likeStyleSc = 'fa-thumbs-o-up';
			   $dislikeStyleSc = 'fa-thumbs-down';
		   }
		   else
		   {
			   $likeStyleSc = 'fa-thumbs-o-up';
			   $dislikeStyleSc = 'fa-thumbs-o-down';
		   }

				if ($selectedAuthor == $subcomment['subidauthor'] && !$isBlocked)
					{
						$updAnddel = '<form action = "?" method = "post">
							<div>
							<input type = "hidden" name = "id" value = "'.$subcomment ['id'].'">
								<input type = "hidden" name = "idart" value = "'.$subcomment ['idart'].'">
								<input type = "hidden" name = "id" value = "'.$subcomment ['id'].'">
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

				<?php echomarkdown ($subcomment['text']); ?>		
			</div>
			
		</div>
		<div class="comment-bottom">
			<!-- <div class="comment-ans">
				<a href="#"><button class="btn_1" id = "op_form_<?php echo $comment['id'];?>">Ответить</button></a> 
				
			</div> -->
			<form class="one-comment-like" id = "like_form_sc_<?php echo $subcomment['id'];?>">			
				<input type = "hidden" name = "idauthor" value = "<?php echo $selectedAuthor;?>">
				<input type = "hidden" name = "idsubcomment" value = "<?php echo $subcomment['id'];?>">
				<input type = "hidden" name = "type-like" id = "type_like_sc_<?php echo $subcomment['id'];?>">
				<button id="like_sc_<?php echo $subcomment['id'];?>" class="comment-like-btn" name = "like_sc" type="submit"><i id="lk_sc_sign_<?php echo $subcomment['id'];?>" class="fa <?php echo $likeStyleSc;?>" aria-hidden="true"></i> <span id="likecount_sc_<?php echo $subcomment['id'];?>"><?php echo $subcomment['likescount'];?></span></button>
				<button id="dislike_sc_<?php echo $subcomment['id'];?>" class="comment-like-btn" name ="dislike_sc" type="submit"><i id="dlk_sc_sign_<?php echo $subcomment['id'];?>" class="fa <?php echo $dislikeStyleSc;?>" aria-hidden="true"></i> <span id="dislikecount_sc_<?php echo $subcomment['id'];?>"><?php echo $subcomment['dislikescount'];?></span></button>
			</form> 

			<?php 
		/*Загрузка скрипта добавления лайков/дизлайков*/
		include MAIN_FILE . '/includes/likescriptsc.inc.php';?>
		</div>
<div class = "comment-line"></div>

<?php endforeach; ?>

<?php 
/*Загрузка пагинации*/
include_once MAIN_FILE . '/pubcommonfiles/pagination.inc.php';?>	

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>