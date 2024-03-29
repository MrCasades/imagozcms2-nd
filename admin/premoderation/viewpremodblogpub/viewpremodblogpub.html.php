<?php 

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
	<div class = "main-headers-circle"></div>
	<div class = "main-headers-content">
    	<h2><a href="#" onclick="history.back();">Назад</a></h2>
		<div class = "main-headers-line"></div>
	</div>
</div>

<article>
    <h2 class="video-header"><?php htmlecho ($headMain); ?></h2>	
	<div class="video-pl">
		<video controls width="90%" height="538" poster="../../../images/<?php echo $imgHead; ?>" preload="none">
			<source src="../../../videofiles/<?php echo $videoFile; ?>.mp4" type="video/mp4">
			<source src="../../../videofiles/<?php echo $videoFile; ?>.webm" type="video/webm"><!-- WebM/VP8 для Firefox4, Opera, и Chrome -->
			<source src="../../../videofiles/<?php echo $videoFile; ?>.ogv" type="video/ogg"><!-- Ogg/Vorbis для старых версий браузеров Firefox и Opera -->
			<object data="../../../videofiles/<?php echo $videoFile; ?>" type="application/x-shockwave-flash"><!-- добавляем видеоконтент для устаревших браузеров, в которых нет поддержки элемента video -->
				<param name="movie" value="../../../videofiles/<?php echo $videoFile; ?>.swf">
			</object>
		</video>
	</div>	

	<div class ="article-info-video video-pl">
		<p><?php echo $date;?> | Автор: <a href="../account/?id=<?php echo $authorId;?>"><?php echo $nameAuthor;?></a> | Рубрика: <a href="../viewcategory/?id=<?php echo $categoryId; ?>"><?php echo $categoryName;?></a></p>
		<p class="article-rating-video">
			<i class="fa fa-eye" aria-hidden="true" title="Просмотры"></i> 0  
			<i class="fa fa-heartbeat" aria-hidden="true" title="Оценка"></i> 0
			<i class="fa fa-check-square-o" aria-hidden="true" title="Добавили в избранное"></i> 0
		</p>
	</div>

	<div class="video-pl">				
		<?php echomarkdown_pub ($articleText); ?>
		<p class="a-video"><?php echo $video; ?></p>					
		<div class="tags-place-m"> 
			<?php if (empty($metas))
					{
						echo '';
					}
						
					else
						
					foreach ($metas as $meta): ?> 
					
						<a href="../viewallmetas/?metaid=<?php echo $meta['id']; ?>"><?php echomarkdown ($meta['metaname']); ?></a>
						
					<?php endforeach; ?>

		</div>
		<div class = "m-content">
            <p><?php echo $delAndUpd; ?></p>
			<p><?php echo $premoderation; ?></p>
		</div>
	</div>			
</article>
				
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>