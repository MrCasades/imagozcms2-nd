<?php 

/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<article>
	<div class="article-row">
		<div class="left-side">
			<div class = "main-headers">
				<div class = "main-headers-circle"></div>
				<div class = "main-headers-content">
					<a href = "../newssets/"><h2>Новостные дайджесты</h2></a>
					<div class = "main-headers-line"></div>
					<div class = "sub-header"><?php htmlecho ($subHeaderNews); ?></div>
				</div>
			</div>
			<div class = "article-head m-content" style="background-image: url(../images/<?php echo $imgHead; ?>)">
				<div class = "article-head-top"> 
					<div class ="article-info">
						<p><span class="post-rubrics"><?php echo $categoryName;?></span></p>
					</div>

			</div>
			
			</div>
			<h1 class="m-content"><?php htmlecho ($headMain); ?></h1>
			<div class="article-head-bottom m-content">
				<br><?php echo $date;?>
				<br>Период публикации: <?php echo $period;?>
			</div>

				<!-- <div class="m-content">
					Место для рекламы
				</div> -->

				<div class="pub-pl">
					<div class="a-line"></div>
					<div class="a-content">
						<?php echomarkdown_pub ($articleText); ?>
					</div>								
				</div>


				<div class = "m-content">
					<p><?php echo $delAndUpd; ?></p>

				</div>


			<div class="gallery-place">		
				<div id="unit_95706"><a href="http://mirtesen.ru/" >Новости МирТесен</a></div>
				<script type="text/javascript" charset="utf-8">
				(function() {
					var sc = document.createElement('script'); sc.type = 'text/javascript'; sc.async = true;
					sc.src = '//news.mirtesen.ru/data/js/95706.js'; sc.charset = 'utf-8';
					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(sc, s);
				}());
				</script>
			</div>

			<div class="gallery-place">		
				<div class="pulse-widget" data-sid="partners_widget_imagozru_2"></div>
				<script async src="https://static.pulse.mail.ru/pulse-widget.js"></script>
			</div>
		</div>
		<div class="right-side">
		<?php
			/*Загрузка компонента последних новостей*/
			include_once MAIN_FILE . '/newsblockinrightside/newsblockinrightside.inc.php';?>
			
			<!-- <div class="pulse-widget" data-sid="partners_widget_imagozru_1" style="height: 650px"></div>
			<script async src="https://static.pulse.mail.ru/pulse-widget.js"></script> -->

			<div class = "main-headers">
				<div class = "main-headers-content">
					<h2 class="no-link-header">Случайные новости рубрики</h2>
					<div class = "main-headers-line"></div>				
				</div>
			</div>

			<div class = "similar-art">
				<?php if (empty($similarNews))
				{
					echo '<p align = "center">Новости отсутствуют</p>';
				}
					
				else
						
				foreach ($similarNews as $news_1): ?>
					
				<a href = "../viewnews/?id=<?php htmlecho ($news_1['id']); ?>" class = "post-place-grid" style="background-image: url(../images/<?php echo $news_1['imghead']; ?>)">
					<div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($news_1['newstitle'])), 0, 7)))); ?>...</div>
				</a> 
				<?php endforeach; ?>
			</div>
			<!-- <div class="zen-c-m">
				<div class = "main-headers">
					<div class = "main-headers-content">
						<h2 class="no-link-header">Наш Дзен-канал</h2>
						<div class = "main-headers-line"></div>				
					</div>
				</div>
				<div class="zen-link-m">
					<a href="https://zen.yandex.ru/imagoz"><img src="./zen-icon.png" alt="Наш Дзен-канал" title="zen.yandex.ru/imagoz"></a>
				</div>
			</div> -->
		</div>
	</div>
</article>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>