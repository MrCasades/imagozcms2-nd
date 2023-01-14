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

<div class = "error-pl">
	<p class = "for-info-txt">Материал сохранён в черновике! Если хотите отправить его сразу на проверку редактору, нажмите на кнопку ниже.</p>
			
	<form action = "../../admin/addupdvideo/" method = "post" id = "confirmok">
		<input type = "hidden" name = "id" value = "<?php echo $idpost_ind; ?>">
		<input type = "submit" name = "action" value = "ОПУБЛИКОВАТЬ" class= "btn_3">
	</form>
</div>

<article>
	<h2 class="video-header"><?php htmlecho ($headMain); ?></h2>	
	<div class="video-pl">
		<video id = "videofile" controls width="90%" height="538" poster="../../images/<?php echo $imgHead; ?>" preload="metadata">
			<source src="../../videofiles/<?php echo $videoFile; ?>.mp4" type="video/mp4">
			<source src="../../videofiles/<?php echo $videoFile; ?>.webm" type="video/webm"><!-- WebM/VP8 для Firefox4, Opera, и Chrome -->
			<source src="../../videofiles/<?php echo $videoFile; ?>.ogv" type="video/ogg"><!-- Ogg/Vorbis для старых версий браузеров Firefox и Opera -->
			<object data="../../videofiles/<?php echo $videoFile; ?>" type="application/x-shockwave-flash"><!-- добавляем видеоконтент для устаревших браузеров, в которых нет поддержки элемента video -->
				<param name="movie" value="../../videofiles/<?php echo $videoFile; ?>.swf">
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
			<p><span id="duration_pl"></span></p>
			<p><?php echo $delAndUpd; ?></p>
			<form id="updmeta_form">
				<input id="for_durationform" type = "hidden" value = "" name="duration">
				<input type = "hidden" value = "<?php echo $idpost_ind; ?>" name="idvideo">
			</form>
		</div>
	</div>			
</article>

<script>
	const videoData = document.getElementById("videofile");
	const durationPl = document.getElementById("duration_pl");
	const durationForm = document.getElementById("for_durationform");
	
	videoData.addEventListener('loadedmetadata', function() {
    	console.log(videoData.duration);
		durationPl.innerHTML = videoData.duration;
		durationForm.value = Math.trunc(videoData.duration);

		$.ajax({
                  url: 'updmetadata.inc.php',
                  type: 'POST',
                  data: $("#updmeta_form").serialize(),  // Сеарилизуем объект

                  success: function(response) { //Данные отправлены успешно
                        result = $.parseJSON(response);  
                        console.log(result);
                        console.log('ОК');                          
            },
        });   
	});
</script>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>