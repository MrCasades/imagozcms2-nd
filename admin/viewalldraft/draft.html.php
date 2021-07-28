<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>


<div class = "main-headers">
    <div class = "headers-places"> 
        <div class = "main-headers-txtplace"><h1><?php htmlecho ($headMain); ?></h1></div>
    </div>
    <div class = "main-headers-line"></div>
</div>

<div class="m-content">
<div>
		<h3>Статьи</h3>
		  
		  <?php if (empty ($posts))
		 { 
			 echo '<p>Материалы отсутствуют</p>';
		 }
		 
		 else
		  
		 foreach ($posts as $post): ?> 
		  		<div class = "post">
				  <div class = "posttitle">
				    <?php echo ($post['postdate']. ' | Автор: <a href="../../account/?id='.$post['idauthor'].'" style="color: white" >'.$post['authorname']).'</a>';?>
					<p>Рубрика: <a href="../../viewcategory/?id=<?php echo $post['categoryid']; ?>" style="color: white"><?php echo $post['categoryname'];?></a></p>
				  </div>
				  	 
				   <div class = "newstext">
				    <h3 class = "for-info-txt"><?php htmlecho ($post['posttitle']); ?></h3>
					   <div class = "newsimg">
					   <?php if ($post['imghead'] == '')
						{
							$img = '';//если картинка в заголовке отсутствует
							echo $img;
						}
						 else 
						{
							$img = '<img width = "90%" height = "90%" src="../../images/'.$post['imghead'].'"'. ' alt="'.$post['imgalt'].'"'.'>';//если картинка присутствует
						}?>
					  <p><?php echo $img;?></p>
				     </div>
					<p><?php echomarkdown (implode(' ', array_slice(explode(' ', strip_tags($post['text'])), 0, 50))); ?> [...]</p>
					<a href="./viewdraftpost/?id=<?php htmlecho ($post['id']); ?>"><button class="btn_2">Далее</button></a>
				   </div>	
				</div>			
		 <?php endforeach; ?> 
	</div>	
		
		<hr/>
		<div>
			<h3>Новости</h3>
		  
		  <?php if (empty ($newsIn))
		 { 
			 echo '<p>Материалы отсутствуют</p>';
		 }
		 
		 else
		  
		 foreach ($newsIn as $news): ?> 
		  	<div class = "post">
				  <div class = "posttitle">
				    <?php echo ($news['newsdate']. ' | Автор: <a href="../../account/?id='.$news['idauthor'].'" style="color: white" >'.$news['authorname']).'</a>';?>
					<p>Рубрика: <a href="../../viewcategory/?id=<?php echo $news['categoryid']; ?>" style="color: white"><?php echo $news['categoryname'];?></a></p>
				  </div>	  
				  <div class = "newstext">
					<h3 class = "for-info-txt"><?php htmlecho ($news['newstitle']); ?></h3>
					  <div class = "newsimg">
					   <?php if ($news['imghead'] == '')
						{
							$img = '';//если картинка в заголовке отсутствует
							echo $img;
						}
						 else 
						{
							$img = '<img width = "90%" height = "90%" src="../../images/'.$news['imghead'].'"'. ' alt="'.$news['imgalt'].'"'.'>';//если картинка присутствует
						}?>
					<p><?php echo $img;?></p>
				  </div>
					<p><?php echomarkdown (implode(' ', array_slice(explode(' ', strip_tags($news['textnews'])), 0, 50))); ?> [...]</p>
					<p><a href="./viewdraftnews/?id=<?php htmlecho ($news['id']); ?>"><button class="btn_2">Далее</button></a></p>
				  </div>
				 </div> 
			</div>			
		 <?php endforeach; ?> 
	</div>	
		
		<hr/>
	<div>
			<h3>Промоушен</h3>
		  
		  <?php if (empty ($promotions))
		 { 
			 echo '<p>Материалы отсутствуют</p>';
		 }
		 
		 else
		  
		 foreach ($promotions as $promotion): ?> 
		  		<div class = "post">
				  <div class = "posttitle">
				    <?php echo ($promotion['promotiondate']. ' | Автор: <a href="../../account/?id='.$promotion['idauthor'].'" style="color: white" >'.$promotion['authorname']).'</a>';?>
					<p>Рубрика: <a href="../../viewcategory/?id=<?php echo $promotion['categoryid']; ?>" style="color: white"><?php echo $promotion['categoryname'];?></a>
					   <?php if ($promotion['www'] != '')//если автор приложил ссылку
						{
							$link = '| <a href="//'.$promotion['www'].'" style="color: white" rel = "nofollow">Ссылка на ресурс</a>';
							echo $link;
						}?></p>
				  </div>
				   <div class = "newstext"> 
				    <h3 class = "for-info-txt"><?php htmlecho ($promotion['promotiontitle']); ?></h3>
						<div class = "newsimg">
						   <?php if ($promotion['imghead'] == '')
							{
								$img = '';//если картинка в заголовке отсутствует
								echo $img;
							}
							 else 
							{
								$img = '<img width = "90%" height = "90%" src="../../images/'.$promotion['imghead'].'"'. ' alt="'.$promotion['imgalt'].'"'.'>';//если картинка присутствует
							}?>
						  <p><?php echo $img;?></p>
						 </div>
					<p><?php echomarkdown (implode(' ', array_slice(explode(' ', strip_tags($promotion['text'])), 0, 50))); ?> [...]</p>
					<a href="./viewdraftpromotion/?id=<?php htmlecho ($promotion['id']); ?>"><button class="btn_2">Далее</button></a>
				   </div>	
				 </div>			
		 <?php endforeach; ?> 
	</div>	
	<p><a name="bottom"></a></p>
</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>		