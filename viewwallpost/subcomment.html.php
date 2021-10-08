<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';?>

<?php if (empty ($subcomments))
		{
			echo '<p class = "m-content" id="not_comment_sub">Ответы отсутствуют!</p>';
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


	if ($selectedAuthor == $subcomment['subidauthor'])
		{
			$updAnddel = '<form action = "../viewwallpost/index.php" method = "post">
							<div>
								<input type = "hidden" name = "id" value = "'.$subcomment ['subid'].'">
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