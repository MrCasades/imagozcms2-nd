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
            <a class = "main-headers-place" href="../viewmetanews/?metaid=<?php echo $idCategory; ?>"><h3>Новости</h3></a>
        </div>
        <div class = "main-headers-line"></div>
    </div>

	<div class = "newsblock m-content">
	<?php if (empty ($metas_news))
		 {
			 echo '<p align = "center">Новости отсутствуют</p>';
		 }
		 
		else
			 
		foreach ($metas_news as $meta_1): ?> 

		<a href = "../viewnews/?id=<?php htmlecho ($meta_1['id']); ?>" class = "post-place-1" style="background-image: url(../images/<?php echo $meta_1['imghead']; ?>)">
            <div class = "post-top-1">
                <p><?php echo date("Y.m.d H:i", strtotime($meta_1['newsdate'])); ?></p>
				<span class="post-rubrics"><?php htmlecho ($meta_1['categoryname']); ?></span>
            </div>
            <div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($meta_1['newstitle'])), 0, 7)))); ?>...</div>
        </a>

		<?php endforeach; ?>

	</div>

	<div class = "main-headers">
        <div class = "headers-places"> 
            <a class = "main-headers-place" href="../viewmetapromotion/?metaid=<?php echo $idCategory; ?>"><h3>Промоушен</h3></a>
        </div>
        <div class = "main-headers-line"></div>
    </div>

	<div class = "main-post m-content">
	<?php if (empty($metas_prom))
		 {
			 echo '<p align = "center">Статьи отсутствуют</p>';
		 }
		 
		 else
			 
		 foreach ($metas_prom as $meta_1): ?>
        <a href="../viewpromotion/?id=<?php htmlecho ($meta_1['id']); ?>" class = "post-place-2" style="background-image: url(../images/<?php echo $meta_1['imghead']; ?>)">
            <div class = "post-top-1">
                <p><?php echo date("Y.m.d H:i", strtotime($meta_1['promotiondate'])); ?></p>
				<span class="post-rubrics"><?php htmlecho ($meta_1['categoryname']); ?></span>
            </div>
            <div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($meta_1['promotiontitle'])), 0, 7)))); ?>...</div>
		</a>
		
		<?php endforeach; ?>
    </div>

	<div class = "main-headers">
        <div class = "headers-places"> 
            <a class = "main-headers-place" href="../viewmetapost/?metaid=<?php echo $idCategory; ?>"><h3>Статьи</h3></a>
        </div>
        <div class = "main-headers-line"></div>
    </div>

	<div class = "main-post m-content">
	<?php if (empty($metas_post))
		 {
			 echo '<p align = "center">Статьи отсутствуют</p>';
		 }
		 
		 else
			 
		 foreach ($metas_post as $meta_1): ?>
        <a href="../viewpost/?id=<?php htmlecho ($meta_1['id']); ?>" class = "post-place-2" style="background-image: url(../images/<?php echo $meta_1['imghead']; ?>)">
            <div class = "post-top-1">
                <p><?php echo date("Y.m.d H:i", strtotime($meta_1['postdate'])); ?></p>
                <span class="post-rubrics"><?php htmlecho ($meta_1['categoryname']); ?></span>
            </div>
            <div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($meta_1['posttitle'])), 0, 7)))); ?>...</div>
		</a>
		
		<?php endforeach; ?>
    </div>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>