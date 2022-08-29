<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

	<div class = "main-headers">
		<div class = "main-headers-content">
			<h2><?php htmlecho ($headMain); ?></h2>
		</div>
	</div>

	<div class = "main-headers">
		<div class = "main-headers-circle"></div>
		<div class = "main-headers-content">
			<a class = "main-headers-place" href="../viewmetanews/?metaid=<?php echo $idMeta; ?>"><h2>Новости</h2></a>
			<div class = "main-headers-line"></div>
			<div class = "sub-header"><?php htmlecho ($subHeaderNews); ?></div>
		</div>
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
		<div class = "main-headers-circle"></div>
		<div class = "main-headers-content">
			<a class = "main-headers-place" href="../viewmetavideo/?metaid=<?php echo $idMeta; ?>"><h2>Видео</h2></a>
			<div class = "main-headers-line"></div>
			<div class = "sub-header"><?php htmlecho ($subHeaderVideo); ?></div>
		</div>
	</div>

	<div class = "main-post m-content">
	<?php if (empty($metas_video))
		 {
			 echo '<p align = "center">Видео отсутствуют</p>';
		 }
		 
		 else
			 
		 foreach ($metas_video as $meta_1): ?>
            <div class = "post-place-video">
				<a href="./video/?id=<?php htmlecho ($meta_1['id']); ?>">
					<video controls width="100%" height="80%" poster="../images/<?php echo $meta_1['imghead']; ?>" preload="none" class="prev-video" muted="muted">
						<source src="../videofiles/<?php echo $meta_1['videofile']; ?>.mp4" type="video/mp4">
						<source src="../videofiles/<?php echo $meta_1['videofile']; ?>.webm" type="video/webm"><!-- WebM/VP8 для Firefox4, Opera, и Chrome -->
						<source src="../videofiles/<?php echo $meta_1['videofile']; ?>.ogv" type="video/ogg"><!-- Ogg/Vorbis для старых версий браузеров Firefox и Opera -->
						<object data="../videofiles/<?php echo $meta_1['videofile']; ?>" type="application/x-shockwave-flash"><!-- добавляем видеоконтент для устаревших браузеров, в которых нет поддержки элемента video -->
							<param name="movie" value="../videofiles/<?php echo $meta_1['videofile']; ?>.swf">
						</object>
										
					</video>
					<div class = "post-bottom-video">
						<?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($meta_1['videotitle'])), 0, 7)))); ?>...			
					</div>
				</a>
				<p class = "post-bottom-video-2">
					<a href="../account/?id=<?php echo $meta_1['idauthor'];?>"><?php echo $meta_1['authorname'];?></a>
					<br><?php echo date("Y.m.d", strtotime($meta_1['videodate'])); ?> | <i class="fa fa-eye" aria-hidden="true" title="Просмотры"></i> <?php echo $meta_1['viewcount']; ?>
				</p>
			</div>	
		<?php endforeach; ?>
    </div>

	<div class = "main-headers">
		<div class = "main-headers-circle"></div>
		<div class = "main-headers-content">
			<a class = "main-headers-place" href="../viewmetapromotion/?metaid=<?php echo $idMeta; ?>"><h2>Промоушен</h2></a>
			<div class = "main-headers-line"></div>
			<div class = "sub-header"><?php htmlecho ($subHeaderPromotion); ?></div>
		</div>
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
		<div class = "main-headers-circle"></div>
		<div class = "main-headers-content">
			<a class = "main-headers-place" href="../viewmetapost/?metaid=<?php echo $idMeta; ?>"><h2>Статьи</h2></a>
			<div class = "main-headers-line"></div>
			<div class = "sub-header"><?php htmlecho ($subHeaderPost); ?></div>
		</div>
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