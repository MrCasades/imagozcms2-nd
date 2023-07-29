<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';?>

<?php if (empty ($subcomments))
		{
			echo '';
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

				if ($selectedAuthor == $subcomment['subidauthor'])
					{
						$updAnddel = '<form action = "//'.MAIN_URL.'/viewwallpost/index.php" method = "post">
										<div>
											<input type = "hidden" name = "typeart" value = "'.$typeArt.'">
											<input type = "hidden" name = "idart" value = "'.$subcomment ['idart'].'">
											<input type = "hidden" name = "id" value = "'.$subcomment ['id'].'">
											<input type = "hidden" name = "idcomment" value = "'.$idComment.'">
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