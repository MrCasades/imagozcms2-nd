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
            <a class = "main-headers-place" href="../viewallnewsincat/?id=<?php echo $idCategory;?>"><h3>Новости</h3></a>
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
            <a class = "main-headers-place" href="../viewallvideosincat/?id=<?php echo $idCategory;?>"><h3>Видео</h3></a>
        </div>
        <div class = "main-headers-line"></div>
    </div>

	<div class = "main-post m-content">
	<?php if (empty($videos))
		 {
			 echo '<p align = "center">Статьи отсутствуют</p>';
		 }
		 
		 else
			 
		 foreach ($videos as $video): ?>
            <div class = "post-place-video">
				<a href="../video/?id=<?php htmlecho ($video['id']); ?>">
					<video controls width="100%" height="80%" poster="../images/<?php echo $video['imghead']; ?>" preload="none" class="prev-video" muted="muted">
						<source src="../videofiles/<?php echo $video['videofile']; ?>.mp4" type="video/mp4">
						<source src="../videofiles/<?php echo $video['videofile']; ?>.webm" type="video/webm"><!-- WebM/VP8 для Firefox4, Opera, и Chrome -->
						<source src="../videofiles/<?php echo $video['videofile']; ?>.ogv" type="video/ogg"><!-- Ogg/Vorbis для старых версий браузеров Firefox и Opera -->
						<object data="../videofiles/<?php echo $video['videofile']; ?>" type="application/x-shockwave-flash"><!-- добавляем видеоконтент для устаревших браузеров, в которых нет поддержки элемента video -->
							<param name="movie" value="../videofiles/<?php echo $video['videofile']; ?>.swf">
						</object>
										
					</video>
					<div class = "post-bottom-video">
						<?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($video['videotitle'])), 0, 7)))); ?>...			
					</div>
				</a>
				<p class = "post-bottom-video-2">
					<a href="../account/?id=<?php echo $video['idauthor'];?>"><?php echo $video['authorname'];?></a>
					<br><?php echo date("Y.m.d", strtotime($video['videodate'])); ?> | <i class="fa fa-eye" aria-hidden="true" title="Просмотры"></i> <?php echo $video['viewcount']; ?>
				</p>
			</div>
		
		<?php endforeach; ?>
    </div>

	<div class = "main-headers">
        <div class = "headers-places"> 
            <a class = "main-headers-place" href="../viewallpromotionincat/?id=<?php echo $idCategory;?>"><h3>Промоушен</h3></a>
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
            <a class = "main-headers-place" href="../viewallpostsincat/?id=<?php echo $idCategory;?>"><h3>Статьи</h3></a>
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