<?php 

/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>
<article>
	<div class="article-row">
		<div class="left-side">
			<div class = "article-head m-content" style="background-image: url(../images/<?php echo $imgHead; ?>)">
				<div class = "article-head-top"> 
					<div class ="article-info">
						<p><?php echo $date;?> | Автор: <a href="../account/?id=<?php echo $authorId;?>"><?php echo $nameAuthor;?></a></p>
						<p>Рубрика: <span class="post-rubrics"><a href="../viewcategory/?id=<?php echo $categoryId; ?>"><?php echo $categoryName;?></a></span></p>
					</div>
				<div class="article-rating">
						<i class="fa fa-eye" aria-hidden="true" title="Просмотры"></i> <?php htmlecho ($viewCount); ?>  
						<i class="fa fa-heartbeat" aria-hidden="true" title="Оценка"></i> <?php htmlecho (round($averageNumber, 2, PHP_ROUND_HALF_DOWN)); ?>
						<i class="fa fa-check-square-o" aria-hidden="true" title="Добавили в избранное"></i> <?php htmlecho ($favouritesCount); ?>
				</div>
			</div>
			<h1><?php htmlecho ($headMain); ?></h1>
			</div>

				<!-- <div class="m-content">
					Место для рекламы
				</div> -->

				<div class="a-content m-content">

					<?php echomarkdown_pub ($articleText); ?>
					<p class="a-video"><?php echo $video; ?></p>
					<div class = "recomm-place">                       
						<script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
						<script src="//yastatic.net/share2/share.js"></script>
						<div class="ya-share2" data-services="collections,vkontakte,facebook,odnoklassniki,moimir,twitter,lj"></div>      
					</div>
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
				</div>
				<div class="m-content like-place">
					<div>
						<?php echo $votePanel; ?>
					</div>
					<div class="fav-and-recomm">
						<div><?php echo $addFavourites;?></div>
					</div>
					<!-- <div class = "zen-ch">
						<a href="https://zen.yandex.ru/imagoz" rel = "nofollow">
						<img src="./zen-icon.png" alt="Наш Дзен-канал" title="zen.yandex.ru/imagoz"><span class="zen-ch-title">Подписывайтесь на наш Дзен-канал!</span></a>
					</div> -->
				</div>

				<div class = "m-content">
					<p><?php echo $delAndUpd; ?></p>
					<p><?php echo $premoderation; ?></p>
				</div>

			<!-- <div class="m-content">
				Место для рекламы
			</div> -->

			<div class = "main-headers">
				<div class = "headers-places"> 
					<div class = "main-headers-txtplace">Новости наших партнёров</div>
				</div>
				<div class = "main-headers-line"></div>
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

			<div class = "main-headers">
				<div class = "headers-places"> 
					<div class = "main-headers-txtplace">Комментарии (<span id="comm_count"><?php echo $countPosts; ?></span>)</div>
				</div>
				<div class = "main-headers-line"></div>
			</div>
			
			<?php echo $addComment; ?>

			<div class = "m-content comment-line"></div> 
			<p><a name="bottom"></a></p>
			<div id="result_form"></div>
			<?php if (empty ($comments))
				{
					echo '<br/><p align="center" id="not_comment">Комментарии отсутствуют!</p>';
				}
					
				else
					
				foreach ($comments as $comment): ?> 

				<div class="comment m-content">
					<div class="comment-person-pl">
						<div>
							<img src="../avatars/<?php echo $comment['avatar'];?>" alt="ava"/>
						</div> 
						<div>
							<?php echo ('<a href="../account/?id='.$comment['idauthor'].'">'.$comment['authorname']).'</a>';?><br>
							<?php echo $comment['date']; ?>
						</div> 
					</div>
					<p><a name="comment-<?php echo $comment['id']; ?>"></a></p>
					<div class="comment-text">
						<p><?php 
					
					//Вывод панели обновления - удаления комментария и проверка на поставленные лайки/дизлайки!
					
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

						if (($selectedAuthor  == $comment['idauthor']) || (userRole('Администратор')))
						{
							$updAnddel = '<form action = "?" method = "post">
							<div>
								<input type = "hidden" name = "id" value = "'.$comment ['id'].'">
								<input type = "hidden" name = "idarticle" value = "'.$comment ['idarticle'].'">
								<input type = "submit" name = "action" class="btn_2" value = "Редактировать">
								<input type = "submit" name = "action" class="btn_1" value = "Del">
							</div>
						</form>';						 
						}	
						else
						{
							$updAnddel = '';
						}							 
						
						echo $updAnddel;?></p>

						<?php echomarkdown ($comment['text']); ?>		
					</div>
					
				</div>
				<div class="comment-bottom">
					<form class="comment-like" id = "like_form_<?php echo $comment['id'];?>">
						<input type = "hidden" name = "idauthor" value = "<?php echo $selectedAuthor;?>">
						<input type = "hidden" name = "idcomment" value = "<?php echo $comment['id'];?>">
						<input type = "hidden" name = "type-like" id = "type_like_<?php echo $comment['id'];?>">
						<button id="like_<?php echo $comment['id'];?>" class="comment-like-btn" name = "like" type="submit"><i id="lk_sign_<?php echo $comment['id'];?>" class="fa <?php echo $likeStyle;?>" aria-hidden="true"></i> <span id="likecount_<?php echo $comment['id'];?>"><?php echo $comment['likescount'];?></span></button>
						<button id="dislike_<?php echo $comment['id'];?>" class="comment-like-btn" name ="dislike" type="submit"><i id="dlk_sign_<?php echo $comment['id'];?>" class="fa <?php echo $dislikeStyle;?>" aria-hidden="true"></i> <span id="dislikecount_<?php echo $comment['id'];?>"><?php echo $comment['dislikescount'];?></span></button>					
					</form>

					<?php 
				/*Загрузка скрипта добавления лайков/дизлайков*/
				include MAIN_FILE . '/includes/likescript.inc.php';?>

					<div class="comment-ans">
						<a href="#"><button class="btn_2" id = "op_form_<?php echo $comment['id'];?>"><i class="fa fa-share" aria-hidden="true"></i> Ответить</button></a> 
						<a href="#"><button class="btn_1" id = "load_<?php echo $comment['id'];?>"><i class="fa fa-comments-o" aria-hidden="true"></i> Ответы (<span id="subcomm_count_<?php echo $comment['id']; ?>"><?php echo $comment['subcommentcount']; ?></span>)</button></a>
					</div>
				</div>
				<div class = "m-content comment-line"></div>
				<div class="m-content form-pl" id = "answ_<?php echo $comment['id'];?>" style="display: none;">
					<?php if (isset($_SESSION['loggIn'])):?>
						<form id="subcomm_form_<?php echo $comment['id'];?>" method = "post">
							<textarea class = "descr mark-textarea" id = "subcomment" name = "subcomment" rows="10"></textarea>	
							<input type = "hidden" name = "idauthor" value = "<?php echo $selectedAuthor; ?>">
							<input type = "hidden" name = "idcomment" value = "<?php echo $comment['id']; ?>">
							<input type = "submit" value = "Ответить" class="btn_2 addit-btn" id="add_subcomm_<?php echo $comment['id']; ?>">  
						</form>	
					<?php else:?>
						<div class="for-info-txt">
							<a href="../admin/registration/?log">Авторизируйтесь</a> в системе или 
							<a href="../admin/registration/?reg">зарегестрируйтесь</a> для того, чтобы ответиь на комментарий!
						</div>
					<?php endif;?>
				</div> 
				<div class="m-content" id="hide_open_pl_<?php echo $comment['id']; ?>" style="display: none;"><a href="#" id="subcomment_hide_<?php echo $comment['id']; ?>">Скрыть</a> <a href="../viewwallpost/?id=<?php echo $comment['id']; ?>&typeart=news&idart=<?php echo $idNews; ?>">Все ответы</a></div>
				<div id="result_form_<?php echo $comment['id']; ?>"></div>
				<div id="subcomments_<?php echo $comment['id']; ?>"></div>
				
				<?php 
				/*Загрузка скрипта получения субкомментов в шаблон*/
				include MAIN_FILE . '/includes/subcommentloadscript.inc.php';?>

			<?php endforeach; ?>

			<div class="page-output">	
			<?php
				/*Постраничный вывод информации*/
				for ($i = 1; $i <= $pagesCount; $i++) 
				{
					// если текущая старница
					if($i == $page)
					{
						echo "<a href='./viewnews/?id=".$idNews."&page=$i'><button class='btn_2'>$i</button></a> ";
					} 
					else 
					{
						echo "<a href='./viewnews/?id=".$idNews."&page=$i'><button class='btn_1'>$i</button></a> ";
					}
				}?>
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
				<div class = "headers-places"> 
					<div class = "main-headers-txtplace">Случайные новости рубрики</div>
				</div>
				<div class = "main-headers-line"></div>
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
			<div class="zen-c-m">
				<div class = "main-headers">
					<div class = "headers-places"> 
						<div class = "main-headers-txtplace">Наш Дзен-канал</div>
					</div>
					<div class = "main-headers-line"></div>
				</div>
				<div class="zen-link-m">
					<a href="https://zen.yandex.ru/imagoz"><img src="./zen-icon.png" alt="Наш Дзен-канал" title="zen.yandex.ru/imagoz"></a>
				</div>
			</div>
		</div>
	</div>
</article>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>