<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
    <div class = "headers-places"> 
        <div class = "main-headers-txtplace"><h1><?php htmlecho ($headMain); ?> | <a href="<?php htmlecho ($URL); ?>"><?php htmlecho ($linkText); ?></a></h1></div>
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
        <div class = "main-headers-txtplace">Ответы (<span id="comm_count"><?php echo $countPosts; ?></span>) | <a href="#" id = "open_form"><button class="btn_2">Ответить</button></a></div>
    </div>
    <div class = "main-headers-line"></div>
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
								<input type = "hidden" name = "idcomment" value = "'.$idComment.'">
								<input type = "hidden" name = "id" value = "'.$subcomment ['subid'].'">
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

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>