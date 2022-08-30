<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

	<div class = "main-headers">
		<div class = "main-headers-circle"></div>
		<div class = "main-headers-content">
			<h2><?php htmlecho ($headMain); ?></h2>
			<div class = "main-headers-line"></div>
			<div class = "sub-header"><?php htmlecho ($subHeaderVideo); ?></div>
		</div>
	</div>

	<div class = "main-post m-content">
		<?php if (empty($videos))
		{
			echo '<p align = "center">Видео отсутствуют</p>';
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

	<div class="page-output">	
			<?php
				/*Постраничный вывод информации*/
				for ($i = 1; $i <= $pagesCount; $i++) 
				{
					// если текущая старница
					if($i == $page)
					{
						echo "<a href='index.php?page=$i&id=$idCategory'><button class='btn_2'>$i</button></a> ";
					} 
					else 
					{
						echo "<a href='index.php?page=$i&id=$idCategory'><button class='btn_1'>$i</button></a> ";
					}
				}?>
	</div>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>