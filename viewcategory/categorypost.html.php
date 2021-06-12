<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

	<div class = "main-headers">
        <div class = "headers-places"> 
            <div class = "main-headers-txtplace"><h1><?php htmlecho ($headMain); ?></h1></div>
        </div>
    </div>

	<div class = "main-headers">
        <div class = "headers-places"> 
            <div class = "main-headers-place"><a href="../viewallnewsincat/?id=<?php echo $idCategory;?>">Новости</a></div>
        </div>
        <div class = "main-headers-line"></div>
    </div>

	<div class = "newsblock m-content">
	<?php if (empty ($newsIn))
		 {
			 echo '<p align = "center">Новости отсутствуют</p>';
		 }
		 
		else
			 
		foreach ($newsIn as $news): ?> 

		<a href = "../viewnews/?id=<?php htmlecho ($news['id']); ?>" class = "post-place-1" style="background-image: url(../images/<?php echo $news['imghead']; ?>)">
            <div class = "post-top-1">
                <p><?php echo date("Y.m.d H:i", strtotime($news['newsdate'])); ?></p>
            </div>
            <div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($news['newstitle'])), 0, 7)))); ?>...</div>
        </a>

		<?php endforeach; ?>

	</div>

	<div class = "main-headers">
        <div class = "headers-places"> 
            <div class = "main-headers-place"><a href="../viewallpromotionincat/?id=<?php echo $idCategory;?>">Промоушен</a></div>
        </div>
        <div class = "main-headers-line"></div>
    </div>

	<div class = "main-post m-content">
	<?php if (empty($promotions))
		 {
			 echo '<p align = "center">Статьи отсутствуют</p>';
		 }
		 
		 else
			 
		 foreach ($promotions as $promotion): ?>
        <a href="../viewpromotion/?id=<?php htmlecho ($promotion['id']); ?>" class = "post-place-2" style="background-image: url(../images/<?php echo $promotion['imghead']; ?>)">
            <div class = "post-top-1">
                <p><?php echo date("Y.m.d H:i", strtotime($promotion['promotiondate'])); ?></p>
            </div>
            <div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($promotion['promotiontitle'])), 0, 7)))); ?>...</div>
		</a>
		
		<?php endforeach; ?>
    </div>

	<div class = "main-headers">
        <div class = "headers-places"> 
            <div class = "main-headers-place"><a href="../viewallpostsincat/?id=<?php echo $idCategory;?>">Статьи</a></div>
        </div>
        <div class = "main-headers-line"></div>
    </div>

	<div class = "main-post m-content">
	<?php if (empty($posts))
		 {
			 echo '<p align = "center">Статьи отсутствуют</p>';
		 }
		 
		 else
			 
		 foreach ($posts as $post): ?>
        <a href="../viewpost/?id=<?php htmlecho ($post['id']); ?>" class = "post-place-2" style="background-image: url(../images/<?php echo $post['imghead']; ?>)">
            <div class = "post-top-1">
                <p><?php echo date("Y.m.d H:i", strtotime($post['postdate'])); ?></p>
                <span class="post-rubrics"><?php htmlecho ($post['categoryname']); ?></span>
            </div>
            <div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($post['posttitle'])), 0, 7)))); ?>...</div>
		</a>
		
		<?php endforeach; ?>
    </div>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>