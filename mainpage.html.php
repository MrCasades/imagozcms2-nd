<?php

/*Загрузка функций в шаблон*/
include_once __DIR__ . '/includes/func.inc.php';

/*Загрузка header*/
include_once __DIR__ . '/header.inc.php';

/*Загрузка adminnews*/
include_once __DIR__ . '/admin/adminnews/adminnews.inc.php';

?>
<div class="main-row">
	<div class="left-side">
		<div class = "main-headers">
			<div class = "main-headers-circle"></div>
			<div class = "main-headers-content">
				<a href = "./viewallnews/"><h2>Новостная лента</h2></a>
				<div class = "main-headers-line"></div>
				<div class = "sub-header"><?php htmlecho ($subHeaderNews); ?></div>
			</div>
		</div>

		<div class = "newsblock m-content last-news">
		<?php if (empty ($newsIn))
			{
				echo '<p>Новости отсутствуют</p>';
			}
			
			else
				
			foreach ($newsIn as $news): ?> 

			<a href = "./viewnews/?id=<?php htmlecho ($news['id']); ?>" class = "post-place-1" style="background-image: url(images/<?php echo $news['imghead']; ?>)">
				<div class = "post-top-1">			
					<span class="post-rubrics"><?php htmlecho ($news['categoryname']); ?></span>
				</div>
				<div class = "post-bottom-1">
					<span class="post-header-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($news['newstitle'])), 0, 7)))); ?>...</span>
					<br><span class="post-date-1"><?php echo date("Y.m.d H:i", strtotime($news['newsdate'])); ?></span>
				</div>
			</a>

			<?php endforeach; ?>
		</div>

		<!-- <div class="m-content">
				Место для рекламы
		</div> -->

		<div class = "main-headers">
			<div class = "main-headers-circle"></div>
			<div class = "main-headers-content">
				<h2 class="no-link-header">Новости наших партнёров</h2>
				<div class = "main-headers-line"></div>				
			</div>
		</div>
		<div class="gallery-place">
			<!-- Мир тесен -->
			<div id="unit_95706"><a href="http://mirtesen.ru/" >Новости МирТесен</a></div>
			<script type="text/javascript" charset="utf-8">
				(function() {
					var sc = document.createElement('script'); sc.type = 'text/javascript'; sc.async = true;
					sc.src = '//news.mirtesen.ru/data/js/95706.js'; sc.charset = 'utf-8';
					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(sc, s);
				}());
			</script> 
		</div>

		<div class = "main-headers">
			<div class = "main-headers-circle"></div>
			<div class = "main-headers-content">
				<a class = "main-headers-place" href="./viewallposts/"><h2>Статьи</h2></a>
				<div class = "main-headers-line"></div>
				<div class = "sub-header"><?php htmlecho ($subHeaderPost); ?></div>
			</div>
		</div>	

		<div class = "main-post m-content artickleblock">
		<?php if (empty($posts))
			{
				echo '<p>Статьи отсутствуют</p>';
			}
			
			else
				
			foreach ($posts as $post): ?>
			<a href="./viewpost/?id=<?php htmlecho ($post['id']); ?>" class = "post-place-2" style="background-image: url(images/<?php echo $post['imghead']; ?>)">
				<div class = "post-top-1">
					<span class="post-rubrics"><?php htmlecho ($post['categoryname']); ?></span>
				</div>
				<div class = "post-bottom-1">
					<span class="post-header-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($post['posttitle'])), 0, 7)))); ?>...</span>
					<br><span class="post-date-1"><?php echo date("Y.m.d H:i", strtotime($post['postdate'])); ?></span>
				</div>
			</a>
			
			<?php endforeach; ?>
		</div>

		<?php if (!empty ($pubs)): ?>
			<div class = "main-headers">
				<div class = "main-headers-circle"></div>
				<div class = "main-headers-content">
					<a href = "./blogs/"><h2>Блоги</h2></a>
					<div class = "main-headers-line"></div>				
				</div>
			</div>
		
			<div class = "newsblock m-content">			 
				<?php foreach ($pubs as $pub): ?> 
				<a href = "./blog/publication?id=<?php htmlecho ($pub['id']); ?>" class = "post-place-1" style="background-image: url(./images/<?php echo $pub['imghead']; ?>)">
					<div class = "post-top-1">
						<p><?php echo date("Y.m.d H:i", strtotime($pub['date'])); ?></p>
						<span class="post-rubrics"><?php htmlecho ($pub['categoryname']); ?></span>
					</div>
					<div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($pub['title'])), 0, 7)))); ?>...</div>
				</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<!-- <div class = "main-headers">
			<div class = "main-headers-circle"></div>
			<div class = "main-headers-content">
				<a class = "main-headers-place" href="./viewallrecommpost/"><h2>Пользователи рекомендуют</h2></a>
				<div class = "main-headers-line"></div>
				<div class = "sub-header"><?php htmlecho ($subHeaderRecomm); ?></div>
			</div>
		</div>

		<div class = "main-post m-content lastrecommblock">
		<?php if (empty($lastRecommPosts))
			{
				echo '<p>Рекомендации отсутствуют</p>';
			}
			
			else
				
			foreach ($lastRecommPosts as $lastRecommPost): ?>
			<a href = "./viewpost/?id=<?php htmlecho ($lastRecommPost['id']); ?>" class = "post-place-2" style="background-image: url(images/<?php echo $lastRecommPost['imghead']; ?>)">
				<div class = "post-top-1">			
					<span class="post-rubrics"><?php htmlecho ($lastRecommPost['categoryname']); ?></span>
				</div>
				<div class = "post-bottom-1">
					<span class="post-header-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($lastRecommPost['posttitle'])), 0, 7)))); ?>...</span>
					<br><span class="post-date-1"><?php echo date("Y.m.d H:i", strtotime($lastRecommPost['postdate'])); ?></span>
				</div>
			</a>
			
			<?php endforeach; ?>
		</div> -->

		<!-- <div class = "main-headers">
			<div class = "main-headers-circle"></div>
			<div class = "main-headers-content">
				<h2 class="no-link-header">Новости наших партнёров</h2>
				<div class = "main-headers-line"></div>				
			</div>
		</div>

		<div class="gallery-place">		
			<div class="pulse-widget" data-sid="partners_widget_imagozru_2"></div>
			<script async src="https://static.pulse.mail.ru/pulse-widget.js"></script>
			<br>
		</div> -->

		<div class = "main-headers">
			<div class = "main-headers-circle"></div>
			<div class = "main-headers-content">
				<a class = "main-headers-place" href="./viewallvideos/"><h2>Наше видео</h2></a>
				<div class = "main-headers-line"></div>
				<div class = "sub-header"><?php htmlecho ($subHeaderVideo); ?></div>
			</div>
		</div>

		<div class = "main-post m-content videoblock">
		<?php if (empty($videos))
			{
				echo '<p>Рекомендации отсутствуют</p>';
			}
			
			else
				
			foreach ($videos as $video): ?>
			<div class = "post-place-video">
				<a href="./video/?id=<?php htmlecho ($video['id']); ?>">
					<video controls width="100%" height="80%" poster="./images/<?php echo $video['imghead']; ?>" preload="none" class="prev-video" muted="muted">
						<source src="./videofiles/<?php echo $video['videofile']; ?>.mp4" type="video/mp4">
						<source src="./videofiles/<?php echo $video['videofile']; ?>.webm" type="video/webm"><!-- WebM/VP8 для Firefox4, Opera, и Chrome -->
						<source src="./videofiles/<?php echo $video['videofile']; ?>.ogv" type="video/ogg"><!-- Ogg/Vorbis для старых версий браузеров Firefox и Opera -->
						<object data="./videofiles/<?php echo $video['videofile']; ?>" type="application/x-shockwave-flash"><!-- добавляем видеоконтент для устаревших браузеров, в которых нет поддержки элемента video -->
							<param name="movie" value="./videofiles/<?php echo $video['videofile']; ?>.swf">
						</object>
										
					</video>
					<div class = "post-bottom-video">
						<?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($video['videotitle'])), 0, 7)))); ?>...			
					</div>
				</a>
				<p class = "post-bottom-video-2">
					<a href="./account/?id=<?php echo $video['idauthor'];?>"><?php echo $video['authorname'];?></a>
					<br><?php echo date("Y.m.d", strtotime($video['videodate'])); ?> | <i class="fa fa-eye" aria-hidden="true" title="Просмотры"></i> <?php echo $video['viewcount']; ?>
				</p>
			</div>
			
			<?php endforeach; ?>
		</div>
		
		<!-- <div class = "main-headers">
			<div class = "headers-places"> 
				<div class = "main-headers-txtplace">Облако тегов</div>
			</div>
			<div class = "main-headers-line"></div>
		</div> -->

		<div class="tags-place-m m-content"> 
				<?php if (empty($metas_1))
				{
					echo '<p>Нет тегов</p>';
				}
				
				else
				
				foreach ($metas_1 as $meta): ?> 
			
					<a href="./viewallmetas/?metaid=<?php echo $meta['id']; ?>"><?php echomarkdown ($meta['meta']); ?></a>
				
				<?php endforeach; ?>
		</div>

		<!-- <?php
		/*Загрузка компонента магазина*/
			//include_once MAIN_FILE . '/shopcomponent/shopcomponent.inc.php';?> -->

		<!-- <div class = "main-headers">
			<div class = "main-headers-circle"></div>
			<div class = "main-headers-content">
				<a class = "main-headers-place" href="./viewallrecommpost/"><h2>Отражение дня</h2></a>
				<div class = "main-headers-line"></div>
				<div class = "sub-header"><?php htmlecho ($subRefDay); ?></div>
			</div>
		</div>		

		<div class="gallery-place">
			<div class="owl-carousel owl-theme">
				<?php if (empty ($postsIMG))
				{
					echo '<p>Статьи отсутствуют</p>';
				}
				
				else
					
				foreach ($postsIMG as $postIMG): ?>
				<a href="./viewpost/?id=<?php htmlecho ($postIMG['id']); ?>">
				<div class = "day-reflection" style="background-image: url(images/<?php htmlecho ($postIMG['imghead']); ?>)">
					<div class = "post-top-1"><?php htmlecho ($postIMG['postdate']); ?></div>
					<div class = "post-bottom-1"><?php htmlecho ($postIMG['posttitle']); ?></div>
				</div>
				</a>
			<?php endforeach; ?>
			</div>
		</div> -->

		<div class="m-content">
			<!--Место для рекламы-->
			<!-- Yandex.RTB R-A-448222-17 -->
			<div id="yandex_rtb_R-A-448222-17"></div>
			<script>window.yaContextCb.push(()=>{
				Ya.Context.AdvManager.render({
					"blockId": "R-A-448222-17",
					"renderTo": "yandex_rtb_R-A-448222-17"
				})
			})
			</script>
		</div>

		<div class = "main-headers">
			<div class = "main-headers-circle"></div>
			<div class = "main-headers-content">
				<a class = "main-headers-place" href="./viewallpromotion/"><h2>Промоушен</h2></a>
				<div class = "main-headers-line"></div>
				<div class = "sub-header"><?php htmlecho ($subHeaderPromotion); ?></div>
			</div>
		</div>	

		<div class = "main-post m-content promotionblock">
		<?php if (empty($promotions))
			{
				echo '<p>Статьи отсутствуют</p>';
			}
			
			else
				
			foreach ($promotions as $promotion): ?>
			<a href="./viewpromotion/?id=<?php htmlecho ($promotion['id']); ?>" class = "post-place-1" style="background-image: url(images/<?php echo $promotion['imghead']; ?>)">
				<div class = "post-top-1">
					<span class="post-rubrics"><?php htmlecho ($promotion['categoryname']); ?></span>
				</div>
				<div class = "post-bottom-1">
					<span class="post-header-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($promotion['promotiontitle'])), 0, 7)))); ?>...</span>
					<br><span class="post-date-1"><?php echo date("Y.m.d H:i", strtotime($promotion['promotiondate'])); ?></span>
				</div>
			</a>
			
			<?php endforeach; ?>
		</div>
		
		<!-- <div class="m-content">
			Место для рекламы
		</div> -->

	</div>
	<div class="right-side">
		<div class="last-comments-pl">
		<div class = "main-headers">
			<div class = "main-headers-content">
				<h2 class="no-link-header">Последние комментарии</h2>
				<div class = "main-headers-line"></div>				
			</div>
		</div>
		

		<!-- <div class = "main-headers">
				<div class = "headers-places"> 
				<div class = "main-headers-txtplace">Последние комментарии</div>
			</div>
			<div class = "main-headers-line"></div>
		</div> -->
		<?php if (empty ($comments))
			{
				echo '<p>Пусто</p>';
			}
			
			else
				
			foreach ($comments as $comment): ?> 

			<?php
			/*Комментарии к типам статей */
				if ($comment['newstitle'] != '')
				{
					$title = $comment['newstitle'];
					$articleType = 'viewnews';
					$articleId = $comment['idnews'];
					$backLinkType = 'news';
				}					
				elseif ($comment['posttitle'] != '')
				{
					$title = $comment['posttitle'];
					$articleType = 'viewpost';
					$articleId = $comment['idpost'];
					$backLinkType = 'post';
				}			
				elseif ($comment['promotiontitle'] != '')
				{
					$title = $comment['promotiontitle'];
					$articleType = 'viewpromotion';
					$articleId = $comment['idpromotion'];
					$backLinkType = 'prom';
				}
				elseif ($comment['title'] != '')
				{
					$title = $comment['title'];
					$articleType = 'blog/publication';
					$articleId = $comment['idpublication'];
					$backLinkType = 'publication';
				}		
			/*Стили кнопок лайков дизлайков*/
				if ($comment['islike'] == 1)
				{
					$likeStyle = 'fa-thumbs-up';
					$dislikeStyle = 'fa-thumbs-o-down';
				}

				elseif ($comment['isdislike'] == 1)
				{
					$likeStyle = 'fa-thumbs-o-up';
					$dislikeStyle = 'fa-thumbs-down';
				}
				else
				{
					$likeStyle = 'fa-thumbs-o-up';
					$dislikeStyle = 'fa-thumbs-o-down';
				}
			?>
			
			<div class="comment-header-mp">
				<h4><a href="./<?php htmlecho($articleType);?>/?id=<?php htmlecho($articleId);?>#comment-<?php echo $comment['id'];?>"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($title)), 0, 10)))); ?>...</a></h4>
			</div>
			<div class="comment-mp">
				<div class="comment-auth-pl-mp">
					
					<?php if ($comment['avatar'] !== ''): ?>

					<div> 
						<img src="./avatars/<?php echo $comment['avatar'];?>" alt="<?php echo $comment['authorname'];?>"> 
					</div>

					<?php else: ?>
						<i class="fa fa-user-circle-o" aria-hidden="true"></i> 
					<?php endif; ?>
					
					<?php echo ('<a href="./account/?id='.$comment['idauthor'].'">'.$comment['authorname']).'</a>';?>
				</div>
				<div class="comment-txt-pl-mp"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($comment['text'])), 0, 70)))); ?>...</div>
				<div class="comment-bottom-mp">									
					<form class="comment-like-mp" id = "like_form_<?php echo $comment['id'];?>">
						<input type = "hidden" name = "idauthor" value = "<?php echo $selectedAuthor;?>">
						<input type = "hidden" name = "idcomment" value = "<?php echo $comment['id'];?>">
						<input type = "hidden" name = "type-like" id = "type_like_<?php echo $comment['id'];?>">
						<button id="like_<?php echo $comment['id'];?>" class="comment-like-btn-mp" name = "like" type="submit"><i id="lk_sign_<?php echo $comment['id'];?>" class="fa <?php echo $likeStyle;?>" aria-hidden="true"></i> <span id="likecount_<?php echo $comment['id'];?>"><?php echo $comment['likescount'];?></span></button>
						<button id="dislike_<?php echo $comment['id'];?>" class="comment-like-btn-mp" name ="dislike" type="submit"><i id="dlk_sign_<?php echo $comment['id'];?>" class="fa <?php echo $dislikeStyle;?>" aria-hidden="true"></i> <span id="dislikecount_<?php echo $comment['id'];?>"><?php echo $comment['dislikescount'];?></span></button>					
					</form>
					<div class="comment-ans-mp">
						<a href="<?php echo '//'.MAIN_URL;?>/viewwallpost/?id=<?php echo $comment['id']; ?>&typeart=<?php htmlecho($backLinkType);?>&idart=<?php htmlecho($articleId);?>"><button class="btn_1"><i class="fa fa-comments-o" aria-hidden="true"></i> Ответить</button></a>
					</div>
				</div>
			</div>
			
			<?php 
			/*Загрузка скрипта добавления лайков/дизлайков*/
			include MAIN_FILE . '/includes/likescript.inc.php';?>

			<?php endforeach; ?>
		</div>			
		<!-- <div class = "main-headers">
				<div class = "headers-places"> 
					<div class = "main-headers-txtplace">Проект FULL-ZEN</div>
				</div>
				<div class = "main-headers-line"></div>
		</div> -->

		<!-- <div class = "m-content for-blocks-m-top f-zen">
			<a href="https://full-zen.imagoz.ru/" ><img src="./full-zen.jpg" alt="Каталог FULL-ZEN" title="Каталог FULL-ZEN"/></a>
		</div> -->

		<!-- <div class="pulse-widget" data-sid="partners_widget_imagozru_1" style="height: 650px"></div>
		<script async src="https://static.pulse.mail.ru/pulse-widget.js"></script> -->
		
		<div class="article-top">
			<div class = "main-headers">
				<div class = "main-headers-content">
					<h2 class="no-link-header"><a href = "./viewfullnewstop/">Рейтинг новостей</a></h2>
					<div class = "main-headers-line"></div>				
				</div>
			</div>

			<!-- <div class = "main-headers">
				<div class = "headers-places"> 
					<div class = "main-headers-txtplace"><a href = "./viewfullnewstop/">Рейтинг новостей</a></div>
				</div>
				<div class = "main-headers-line"></div>
			</div> -->
			
			<div class = "rating">
				<?php if (empty ($newsInTOP))
					{
						echo '<p>Пусто</p>';
					}
					
					else
						
					foreach ($newsInTOP as $newsTOP): ?> 

					<a href = "./viewnews/?id=<?php htmlecho ($newsTOP['id']); ?>" class = "post-place-grid" style="background-image: url(images/<?php echo $newsTOP['imghead']; ?>)">
						<div class = "post-top-1">
							<div class="article-rating">
								<i class="fa fa-eye" aria-hidden="true" title="Просмотры"></i> <?php htmlecho ($newsTOP['viewcount']); ?> 
								<i class="fa fa-heartbeat" aria-hidden="true" title="Оценка"></i> <?php htmlecho ($newsTOP['averagenumber']); ?>
							</div>
						</div>
						<div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($newsTOP['newstitle'])), 0, 7)))); ?>...</div>
					</a>

					<?php endforeach; ?>

			</div>

			<div class = "main-headers">
				<div class = "main-headers-content">
					<h2 class="no-link-header"><a href = "./viewfullpromotiontop/">Рейтинг промоушена</a></h2>
					<div class = "main-headers-line"></div>				
				</div>
			</div>

			<!-- <div class = "main-headers">
				<div class = "headers-places"> 
					<div class = "main-headers-txtplace"><a href = "./viewfullpromotiontop/">Рейтинг промоушена</a></div>
				</div>
			<div class = "main-headers-line"></div>
			</div> -->

			<div class = "rating">
			<?php if (empty ($promotionsTOP))
				{
					echo '<p>Пусто</p>';
				}
				
				else
					
				foreach ($promotionsTOP as $promotionTOP): ?> 

				<a href = "./viewpromotion/?id=<?php htmlecho ($promotionTOP['id']); ?>" class = "post-place-grid" style="background-image: url(images/<?php echo $promotionTOP['imghead']; ?>)">
					<div class = "post-top-1">						
						<div class="article-rating">
							<i class="fa fa-eye" aria-hidden="true" title="Просмотры"></i> <?php htmlecho ($promotionTOP['viewcount']); ?> 
							<i class="fa fa-heartbeat" aria-hidden="true" title="Оценка"></i> <?php htmlecho ($promotionTOP['averagenumber']); ?>
						</div>
					</div>
					<div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($promotionTOP['promotiontitle'])), 0, 7)))); ?>...</div>
				</a>

				<?php endforeach; ?>

			</div>

			<div class = "main-headers">
				<div class = "main-headers-content">
					<h2 class="no-link-header"><a href = "./viewfullposttop/">Рейтинг статей</a></h2>
					<div class = "main-headers-line"></div>				
				</div>
			</div>

			<!-- <div class = "main-headers">
				<div class = "headers-places"> 
					<div class = "main-headers-txtplace"><a href = "./viewfullposttop/">Рейтинг статей</a></div>
				</div>
			<div class = "main-headers-line"></div>
			</div> -->

			<div class = "rating">
			<?php if (empty ($postsTOP))
				{
					echo '<p>Пусто</p>';
				}
				
				else
					
				foreach ($postsTOP as $postTOP): ?> 

				<a href = "./viewpost/?id=<?php htmlecho ($postTOP['id']); ?>" class = "post-place-grid" style="background-image: url(images/<?php echo $postTOP['imghead']; ?>)">
					<div class = "post-top-1">
						<div class="article-rating">
							<i class="fa fa-eye" aria-hidden="true" title="Просмотры"></i> <?php htmlecho ($postTOP['viewcount']); ?> 
							<i class="fa fa-heartbeat" aria-hidden="true" title="Оценка"></i> <?php htmlecho ($postTOP['averagenumber']); ?>
						</div>
					</div>
					<div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($postTOP['posttitle'])), 0, 7)))); ?>...</div>
				</a>

				<?php endforeach; ?>

			</div>
		</div>

		<div class="auth-top-1">
			<div class = "main-headers">
				<div class = "main-headers-content">
					<h2 class="no-link-header">Наши авторы. Топ-7</h2>
					<div class = "main-headers-line"></div>				
				</div>
			</div>
			<!-- <div class = "main-headers">
				<div class = "headers-places"> 
					<div class = "main-headers-txtplace">Наши авторы. Топ-7</div>
				</div>
			<div class = "main-headers-line"></div>
			</div> -->
			
			<?php if (empty ($authorsTOP))
			{
				echo '<p>Нет авторов</p>';
			}
				
			else
				
			foreach ($authorsTOP as $authorTOP): ?>
				<div class = "for-top-auth">

					<?php if ($authorTOP['avatar'] !== ''): ?>

					<div class="for-top-auth-ava-pl"> 
						<img src="./avatars/<?php echo $authorTOP['avatar'];?>" alt="<?php echo $authorTOP['authorname'];?>">&nbsp; 
					</div>

					<?php else: ?>

					<div class="for-top-auth-ava-pl"> 
						<i class="fa fa-user-circle-o" aria-hidden="true"></i> 
					</div>

					<?php endif; ?>

					<div class="for-top-auth-rate-name-pl">
						<a href="./account/?id=<?php echo $authorTOP['id'];?>"><?php echo $authorTOP['authorname'];?></a> 
						<br>
						<i class="fa fa-pencil-square-o" aria-hidden="true" title="Опубликовано материалов"></i><?php htmlecho ($authorTOP['countposts']); ?>&nbsp;  
						<i class="fa fa-diamond" aria-hidden="true" title="Рейтинг автора"></i> <?php htmlecho ($authorTOP['rating']); ?>
					</div>
				</div>	 
			<?php endforeach; ?>
		</div>
			<div class="zen-c-m">
				<div class = "main-headers">
					<div class = "main-headers-content">
						<h2 class="no-link-header">Наш Дзен-канал</h2>
						<div class = "main-headers-line"></div>				
					</div>
				</div>
				<!-- <div class = "main-headers">
					<div class = "headers-places"> 
						<div class = "main-headers-txtplace">Наш Дзен-канал</div>
					</div>
					<div class = "main-headers-line"></div>
				</div> -->
				<div class="zen-link-m">
					<a href="https://zen.yandex.ru/imagoz"><img src="./zen-icon.png" alt="Наш Дзен-канал" title="zen.yandex.ru/imagoz"></a>
				</div>
			</div>
			<div class="zen-c-m">
				<div class = "main-headers">
					<div class = "main-headers-content">
						<h2 class="no-link-header">Наш YouTube-канал</h2>
						<div class = "main-headers-line"></div>				
					</div>
				</div>
				<div class="zen-link-m">
					<a href="https://www.youtube.com/channel/UCYAlQfGJQC4de8gEmZwF9Yg"><img src="<?php echo '//'.MAIN_URL.'/decoration/youtubem.png';?>" alt="Мы на YouTube!" title="Мы на YouTube!"/></a>
				</div>
			</div>
			<div class="vk-m">
				<div class = "main-headers">
					<div class = "main-headers-content">
						<h2 class="no-link-header">Мы ВКонтакте</h2>
						<div class = "main-headers-line"></div>				
					</div>
				</div>
				<!-- <div class = "main-headers">
					<div class = "headers-places"> 
						<div class = "main-headers-txtplace">Мы ВКонтакте</div>
					</div>
					<div class = "main-headers-line"></div>
				</div> -->
				<div class="scr-cont">
				<script type="text/javascript" src="https://vk.com/js/api/openapi.js?169"></script>

					<!-- VK Widget -->
				<div id="vk_groups"></div>
				<script type="text/javascript">
					VK.Widgets.Group("vk_groups", {mode: 3, width: 170, no_cover: 1}, 54027668);
				</script>
					
			</div>
			<br>
				<!-- Yandex.RTB R-A-448222-18 -->
				<div id="yandex_rtb_R-A-448222-18"></div>
				<script>window.yaContextCb.push(()=>{
					Ya.Context.AdvManager.render({
						"blockId": "R-A-448222-18",
						"renderTo": "yandex_rtb_R-A-448222-18"
					})
				})
				</script>
		</div>
	</div>
</div>

<div class = "about-project-pl">
	<div class = "main-headers">
		<div class = "main-headers-circle"></div>
		<div class = "main-headers-content">
			<h2 class="no-link-header">О проекте</h2>
			<div class = "main-headers-line"></div>				
		</div>
	</div>
	<div class = "about-project">
		<p>Добро пожаловать! На портале <strong>imagoz.ru</strong> (от лат. Imago - отражение) мы пишем <a href="./viewcategory/?id=1">об играх</a> и игровой индустрии, 
			достижениях в области высоких технологий (<a href="./viewcategory/?id=2">Hi-Tech</a>) и <a href="./viewcategory/?id=3">популярной науки</a>, об интересных <a href="./viewcategory/?id=4">гаджетах</a>. Одним словом о 
			самом интересном и технологичном, что окружает нас. Мы публикуем новости, статьи, различные интересные подборки, 
			а также создаём видео на указанные темы.</p>

		<p>Первая версия портала <strong>imagoz.ru</strong> была создана в 2013 году. Сайт изначально был посвящён Интернет культуре, 
			мемам, разным медиа-вирусам. В 2019 году он приобрёл нынешнюю концепцию. Над материалами сайта периодически 
			работает множество авторов. Вы можете к ним <a href="./cooperation#forauth">присоединиться</a>.</p>

		<p>Также, стоит отметить, что <strong>imagoz.ru</strong> делает акцент публикациях, которые рассказывают об играх от малоизвестных 
			разработчиков. Если вы являетесь таковым, то мы можем оказать <a href="./cooperation#infopart">информационную поддержку</a> вашему проекту, 
			рассказать о нём на страницах портала.</p>

		<p>Ещё <strong>imagoz.ru</strong> представлен во многих социальных сетях и сервисах. Ознакомиться и подписаться можно 
			на <a href="./links">отдельной странице</a>.</p>
		<!-- <p>Добро пожаловать на портал <strong>IMAGOZ</strong> (от лат. imago - отражение)! Здесь мы объеденили в общую картину мира тему высоких технологий (hi-tech), индустрию компьютерных игр, 
		взгляд на самые необычные современные гаджеты, достижения науки и техники и насыщенную событиями жизнь интернета.</p>
					
		<p>Такой подход является на первый взгляд несколько 
		нестандартным, но мы считаем, что все эти тематики могут органично сочетаться, заинтересовав широкий круг разносторонне развитых читателей, которые хотят быть на острие 
		прогресса!</p>

		<p>Создатели портала <strong>IMAGOZ</strong> собирают самые интересные и актуальные новости и подают их в оригинальном авторском отражении. Мы не стремимся полностью охватить этот необъятный
		мир Hi-tech, науки, игр и прочего, но публикуем самые интересные материалы по этим темам.</p>
					
		<p>Стоит также отметить, что портал <strong>IMAGOZ</strong> возрождает такой казалось бы мёртвый в нашей стране своеобразный  жанр в публицистике, как <strong>"игрожур"</strong>. Игровая журналистика со своим своеобразным, самобытным 
		стилем изложения материала для многих связана с самыми тёплыми "ламповыми" воспоминаниями из 90-х, начала 2000 годов.</p> 
					
		<p><strong>IMAGOZ</strong> вбирает в себя лучшие черты этого условного жанра и порождает новое явление - <strong>Постигрожур</strong>. Постигрожур - публикации об играх и тому что интересно геймерам без "игрожура"!</p> -->
	</div>	
</div>
<?php 
/*Загрузка footer*/
include_once __DIR__ . '/footer.inc.php';?>

