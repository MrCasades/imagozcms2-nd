<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>


<div class = "main-headers">
    <div class = "headers-places"> 
        <div class = "main-headers-txtplace"><h1><?php htmlecho ($headMain); ?> | <a href="#" onclick="history.back();">Назад</a></h1></div>
    </div>
</div>

<div class = "main-headers">
    <div class = "headers-places"> 
        <div class = "main-headers-txtplace">Статьи</div>
    </div>
    <div class = "main-headers-line"></div>
</div>

<div class = "main-post m-content">
		<?php if (empty($posts))
		{
			echo '<p>Статьи отсутствуют</p>';
		}
			
		else
				
		foreach ($posts as $post): ?>
		<a href="./viewdraftpost/?id=<?php htmlecho ($post['id']); ?>" class = "post-place-2" style="background-image: url(../../images/<?php echo $post['imghead']; ?>)">
			<div class = "post-top-1">
				<p><?php echo date("Y.m.d H:i", strtotime($post['postdate'])); ?></p>
				<span class="post-rubrics"><?php htmlecho ($post['categoryname']); ?></span>
			</div>
			<div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($post['posttitle'])), 0, 7)))); ?>...</div>
		</a>
			
		<?php endforeach; ?>		
</div>

<div class = "main-headers">
    <div class = "headers-places"> 
        <div class = "main-headers-txtplace">Новости</div>
    </div>
    <div class = "main-headers-line"></div>
</div>

<div class = "main-post m-content">
	<?php if (empty($newsIn))
	 {
		echo '<p>Статьи отсутствуют</p>';
	 }
		 
	 else
			 
	 foreach ($newsIn as $news): ?>
    <a href="./viewdraftnews/?id=<?php htmlecho ($news['id']); ?>" class = "post-place-2" style="background-image: url(../../images/<?php echo $news['imghead']; ?>)">
        <div class = "post-top-1">
            <p><?php echo date("Y.m.d H:i", strtotime($news['newsdate'])); ?></p>
			<span class="post-rubrics"><?php htmlecho ($news['categoryname']); ?></span>
        </div>
        <div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($news['newstitle'])), 0, 7)))); ?>...</div>
	</a>
		
	<?php endforeach; ?>
</div>

<div class = "main-headers">
    <div class = "headers-places"> 
        <div class = "main-headers-txtplace">Промоушен</div>
    </div>
    <div class = "main-headers-line"></div>
</div>

<div class = "main-post m-content">
		<?php if (empty($promotions))
		{
			echo '<p>Статьи отсутствуют</p>';
		}
				
		else
					
		foreach ($promotions as $promotion): ?>
		<a href="./viewdraftpromotion/?id=<?php htmlecho ($promotion['id']); ?>" class = "post-place-2" style="background-image: url(../../images/<?php echo $promotion['imghead']; ?>)">
			<div class = "post-top-1">
				<p><?php echo date("Y.m.d H:i", strtotime($promotion['promotiondate'])); ?></p>
				<span class="post-rubrics"><?php htmlecho ($promotion['categoryname']); ?></span>
			</div>
			<div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($promotion['promotiontitle'])), 0, 7)))); ?>...</div>
		</a>
			
		<?php endforeach; ?>			
</div>

<div class = "main-headers">
    <div class = "headers-places"> 
        <div class = "main-headers-txtplace">Видео</div>
    </div>
    <div class = "main-headers-line"></div>
</div>

<div class = "main-post m-content">
		<?php if (empty($videos))
		{
			echo '<p>Статьи отсутствуют</p>';
		}
				
		else
					
		foreach ($videos as $video): ?>
		<a href="./viewdraftvideo/?id=<?php htmlecho ($video['id']); ?>" class = "post-place-2" style="background-image: url(../../images/<?php echo $video['imghead']; ?>)">
			<div class = "post-top-1">
				<p><?php echo date("Y.m.d H:i", strtotime($video['videodate'])); ?></p>
				<span class="post-rubrics"><?php htmlecho ($video['categoryname']); ?></span>
			</div>
			<div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($video['videotitle'])), 0, 7)))); ?>...</div>
		</a>
			
		<?php endforeach; ?>			
</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>		