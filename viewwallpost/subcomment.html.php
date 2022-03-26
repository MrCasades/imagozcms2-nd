<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';?>

<?php if (empty ($subcomments))
		{
			echo '<p class = "m-content" id="not_comment_sub">Ответы отсутствуют!</p>';
		}
				
	  else
				
	  foreach ($subcomments as $subcomment): ?> 

	<?php 
			/*Загрузка скрипта добавления лайков/дизлайков*/
			 include MAIN_FILE . '/includes/likescriptsc.inc.php';
			 

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
			?>

<div class="sub-comment m-content">
    <span class="sub-comment-info">
		Ответил <a href="../account/?id=<?php echo $subcomment['subidauthor']; ?>"><?php echo $subcomment['subauthorname']; ?></a> | <?php echo $subcomment['date'];?>
	  </span>
	<p><?php echomarkdown ($subcomment['text']); ?></p>
	<p>
		<form class="one-comment-like" id = "like_form_sc_<?php echo $subcomment['id'];?>">
			<input type = "hidden" name = "idauthor" value = "<?php echo $selectedAuthor;?>">
			<input type = "hidden" name = "idsubcomment" value = "<?php echo $subcomment['id'];?>">
			<input type = "hidden" name = "type-like" id = "type_like_sc_<?php echo $subcomment['id'];?>">
			<button id="like_sc_<?php echo $subcomment['id'];?>" class="comment-like-btn" name = "like_sc" type="submit"><i id="lk_sc_sign_<?php echo $subcomment['id'];?>" class="fa <?php echo $likeStyleSc;?>" aria-hidden="true"></i> <span id="likecount_sc_<?php echo $subcomment['id'];?>"><?php echo $subcomment['likescount'];?></span></button>
			<button id="dislike_sc_<?php echo $subcomment['id'];?>" class="comment-like-btn" name ="dislike_sc" type="submit"><i id="dlk_sc_sign_<?php echo $subcomment['id'];?>" class="fa <?php echo $dislikeStyleSc;?>" aria-hidden="true"></i> <span id="dislikecount_sc_<?php echo $subcomment['id'];?>"><?php echo $subcomment['dislikescount'];?></span></button>
		</form> 
	</p>
	<p><?php 
				   
	/*Вывод меню редактирования и удаления комментария для автора*/


	if ($selectedAuthor == $subcomment['subidauthor'])
		{
			$updAnddel = '<form action = "../viewwallpost/index.php" method = "post">
							<div>
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
</div>
<div class = "m-content comment-line"></div>

<?php endforeach; ?>