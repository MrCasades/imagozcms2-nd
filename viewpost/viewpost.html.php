<?php 

/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<article>
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

	<div class="m-content">
	<!-- Yandex.RTB R-A-448222-9 -->
	<div id="yandex_rtb_R-A-448222-9"></div>
        <script type="text/javascript">
            (function(w, d, n, s, t) {
                      w[n] = w[n] || [];
                      w[n].push(function() {
                      Ya.Context.AdvManager.render({
                            blockId: "R-A-448222-9",
                            renderTo: "yandex_rtb_R-A-448222-9",
                            async: true
                        });
                        });
                     t = d.getElementsByTagName("script")[0];
                     s = d.createElement("script");
                     s.type = "text/javascript";
                     s.src = "//an.yandex.ru/system/context.js";
                     s.async = true;
                     t.parentNode.insertBefore(s, t);
            })(this, this.document, "yandexContextAsyncCallbacks");
        </script>
		</div>

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
				<div><?php echo $recommendation;?></div>
			</div>
			<div class = "zen-ch">
                <a href="https://zen.yandex.ru/imagoz" rel = "nofollow">
                <img src="./zen-icon.png" alt="Наш Дзен-канал" title="zen.yandex.ru/imagoz"><span class="zen-ch-title">Подписывайтесь на наш Дзен-канал!</span></a>
            </div>
		</div>

		<div class = "m-content">
			<p><?php echo $delAndUpd; ?></p>
			<p><?php echo $premoderation; ?></p>
		</div>

		<div class="m-content">
		<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<!-- ForPosts -->
		<ins class="adsbygoogle"
			 style="display:block"
			 data-ad-client="ca-pub-1348880364936413"
			 data-ad-slot="7237613613"
			 data-ad-format="auto"
			 data-full-width-responsive="true"></ins>
		<script>
			 (adsbygoogle = window.adsbygoogle || []).push({});
		</script>
		</div>

		<div class = "main-headers">
            <div class = "headers-places"> 
                <div class = "main-headers-txtplace">Случайные статьи рубрики</div>
            </div>
            <div class = "main-headers-line"></div>
        </div>

		<div class = "newsblock m-content">
			<?php if (empty($similarPosts))
			{
				echo '<p align = "center">Новости отсутствуют</p>';
			}
			
			else
				
			foreach ($similarPosts as $post_1): ?>
			
			<a href = "../viewpost/?id=<?php htmlecho ($post_1['id']); ?>" class = "post-place-1" style="background-image: url(../images/<?php echo $post_1['imghead']; ?>)">
                <div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($post_1['posttitle'])), 0, 7)))); ?>...</div>
            </a> 
			<?php endforeach; ?>
		</div>

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
		<script src="<?php echo '//'.MAIN_URL.'/jquery-3.5.1.min.js';?>"></script>	
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
					<div class="comment-text">
						<p><?php 
					   
					   //Вывод панели обновления - удаления комментария!
						if (($authorName == $comment['authorname']) || (userRole('Администратор')))
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
				<div class="comment-ans">
					<a href="#"><button class="btn_2" id = "op_form_<?php echo $comment['id'];?>"><i class="fa fa-share" aria-hidden="true"></i> Ответить</button></a> 
					<a href="#"><button class="btn_1" id = "load_<?php echo $comment['id'];?>"><i class="fa fa-comments-o" aria-hidden="true"></i> Ответы (<span id="subcomm_count_<?php echo $comment['id']; ?>"><?php echo $comment['subcommentcount']; ?></span>)</button></a>
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
				<div class="m-content" id="hide_open_pl_<?php echo $comment['id']; ?>" style="display: none;"><a href="#" id="subcomment_hide_<?php echo $comment['id']; ?>">Скрыть</a> <a href="../viewwallpost/?id=<?php echo $comment['id']; ?>">Все ответы</a></div>
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
					echo "<a href='./viewpost/?id=".$idPost."&page=$i'><button class='btn_2'>$i</button></a> ";
				} 
				else 
				{
					echo "<a href='./viewpost/?id=".$idPost."&page=$i'><button class='btn_1'>$i</button></a> ";
				}
			}?>
</div>

</article>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>