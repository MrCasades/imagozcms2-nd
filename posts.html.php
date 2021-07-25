<?php

/*Загрузка функций в шаблон*/
include_once __DIR__ . '/includes/func.inc.php';

/*Загрузка header*/
include_once __DIR__ . '/header.inc.php';

/*Загрузка adminnews*/
include_once __DIR__ . '/admin/adminnews/adminnews.inc.php';

?>

	<div class = "main-headers">
            <div class = "headers-places"> 
                <div class = "main-headers-place posts-op-n"><a href = "./viewallnews/">Новостная лента</a></div>
                <div class = "main-headers-place ratings-op-n"><a href = "./viewfullnewstop/">Рейтинг новостей</a></div>
                <div class = "adpt-title main-headers-txtplace">Новости игровой индустрии, высоких технологий и популярной науки</div>
            </div>
            <div class = "main-headers-line"></div>
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
                <p><?php echo date("Y.m.d H:i", strtotime($news['newsdate'])); ?></p>
                <span class="post-rubrics"><?php htmlecho ($news['categoryname']); ?></span>
            </div>
            <div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($news['newstitle'])), 0, 7)))); ?>...</div>
        </a>

		<?php endforeach; ?>

	</div>

	<div class = "newsblock m-content rating-n">
	<?php if (empty ($newsInTOP))
		 {
			 echo '<p>Пусто</p>';
		 }
		 
		else
			 
		foreach ($newsInTOP as $newsTOP): ?> 

		<a href = "./viewnews/?id=<?php htmlecho ($newsTOP['id']); ?>" class = "post-place-1" style="background-image: url(images/<?php echo $newsTOP['imghead']; ?>)">
            <div class = "post-top-1">
                <p><?php echo date("Y.m.d H:i", strtotime($newsTOP['newsdate'])); ?></p>
                <div class="article-rating">
                    <i class="fa fa-eye" aria-hidden="true" title="Просмотры"></i> <?php htmlecho ($newsTOP['viewcount']); ?> 
				    <i class="fa fa-heartbeat" aria-hidden="true" title="Оценка"></i> <?php htmlecho ($newsTOP['averagenumber']); ?>
                </div>
            </div>
            <div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($newsTOP['newstitle'])), 0, 7)))); ?>...</div>
        </a>

		<?php endforeach; ?>

	</div>

	<!-- Yandex.RTB R-A-448222-13 -->
	<div id="yandex_rtb_R-A-448222-13"></div>
	<script type="text/javascript">
		(function(w, d, n, s, t) {
			w[n] = w[n] || [];
			w[n].push(function() {
				Ya.Context.AdvManager.render({
					blockId: "R-A-448222-13",
					renderTo: "yandex_rtb_R-A-448222-13",
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

	<div class = "main-headers">
        <div class = "headers-places"> 
            <div class = "main-headers-txtplace">Новости наших партнёров</div>
        </div>
        <div class = "main-headers-line"></div>
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
        <div class = "headers-places"> 
            <div class = "main-headers-place"><a href="./viewallrecommpost/">Пользователи рекомендуют</a></div>
            <div class = "adpt-title main-headers-txtplace">Статьи, которые порекомендовали для главной страицы!</div>
        </div>
        <div class = "main-headers-line"></div>
    </div>

	<div class = "main-post m-content">
	<?php if (empty($lastRecommPosts))
		 {
			 echo '<p>Рекомендации отсутствуют</p>';
		 }
		 
		 else
			 
		 foreach ($lastRecommPosts as $lastRecommPost): ?>
        <a href="./viewpost/?id=<?php htmlecho ($lastRecommPost['id']); ?>" class = "post-place-2" style="background-image: url(images/<?php echo $lastRecommPost['imghead']; ?>)">
            <div class = "post-top-1">
                <p><?php echo date("Y.m.d H:i", strtotime($lastRecommPost['postdate'])); ?></p>
                <span class="post-rubrics"><?php htmlecho ($lastRecommPost['categoryname']); ?></span>
            </div>
            <div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($lastRecommPost['posttitle'])), 0, 7)))); ?>...</div>
		</a>
		
		<?php endforeach; ?>
    </div>
	
	<div class = "main-headers">
        <div class = "headers-places"> 
            <div class = "main-headers-txtplace">Облако тегов</div>
        </div>
        <div class = "main-headers-line"></div>
    </div>

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

	<?php
	 /*Загрузка компонента магазина*/
		include_once MAIN_FILE . '/shopcomponent/shopcomponent.inc.php';?>

	<div class = "main-headers">
        <div class = "headers-places"> 
            <div class = "main-headers-place">Отражение дня</div>
            <div class = "adpt-title main-headers-txtplace">Что-то забавное, занимательное, любопытное</div>
        </div>
        <div class = "main-headers-line"></div>
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
    </div>

	<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<!-- for_main_page_new -->
	<ins class="adsbygoogle"
		style="display:block"
		data-ad-client="ca-pub-1348880364936413"
		data-ad-slot="4608956908"
		data-ad-format="auto"
		data-full-width-responsive="true"></ins>
	<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
	</script>

	<div class = "main-headers">
        <div class = "headers-places"> 
            <div class = "main-headers-place posts-op-pr"><a href="./viewallpromotion/">Промоушен</a></div>
            <div class = "main-headers-place ratings-op-pr"><a href="./viewfullpromotiontop/">Рейтинг промоушена</a></div>
            <div class = "adpt-title main-headers-txtplace">Материалы от наших уважаемых рекламодателей</div>
        </div>
        <div class = "main-headers-line"></div>
    </div>

	<div class = "main-post m-content last-pr">
	<?php if (empty($promotions))
		 {
			 echo '<p>Статьи отсутствуют</p>';
		 }
		 
		 else
			 
		 foreach ($promotions as $promotion): ?>
        <a href="./viewpromotion/?id=<?php htmlecho ($promotion['id']); ?>" class = "post-place-2" style="background-image: url(images/<?php echo $promotion['imghead']; ?>)">
            <div class = "post-top-1">
                <p><?php echo date("Y.m.d H:i", strtotime($promotion['promotiondate'])); ?></p>
                <span class="post-rubrics"><?php htmlecho ($promotion['categoryname']); ?></span>
            </div>
            <div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($promotion['promotiontitle'])), 0, 7)))); ?>...</div>
		</a>
		
		<?php endforeach; ?>
    </div>

	<div class = "newsblock m-content rating-pr">
	<?php if (empty ($promotionsTOP))
		 {
			 echo '<p>Пусто</p>';
		 }
		 
		else
			 
		foreach ($promotionsTOP as $promotionTOP): ?> 

		<a href = "./viewpromotion/?id=<?php htmlecho ($promotionTOP['id']); ?>" class = "post-place-1" style="background-image: url(images/<?php echo $promotionTOP['imghead']; ?>)">
            <div class = "post-top-1">
                <p><?php echo date("Y.m.d H:i", strtotime($promotionTOP['promotiondate'])); ?></p>
                <div class="article-rating">
                    <i class="fa fa-eye" aria-hidden="true" title="Просмотры"></i> <?php htmlecho ($promotionTOP['viewcount']); ?> 
				    <i class="fa fa-heartbeat" aria-hidden="true" title="Оценка"></i> <?php htmlecho ($promotionTOP['averagenumber']); ?>
                </div>
            </div>
            <div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($promotionTOP['promotiontitle'])), 0, 7)))); ?>...</div>
        </a>

		<?php endforeach; ?>

	</div>

	<div class="for_mainpage_direct">
		 <!-- Yandex.RTB R-A-448222-8 -->
		<div id="yandex_rtb_R-A-448222-8"></div>
		<script type="text/javascript">
			(function(w, d, n, s, t) {
				w[n] = w[n] || [];
				w[n].push(function() {
					Ya.Context.AdvManager.render({
						blockId: "R-A-448222-8",
						renderTo: "yandex_rtb_R-A-448222-8",
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

	<div class = "main-headers">
        <div class = "headers-places"> 
            <div class = "main-headers-place posts-op-art"><a href="./viewallposts/">Статьи</a></div>
            <div class = "main-headers-place ratings-op-art"><a href="./viewfullposttop/">Рейтинг статей</a></div>
            <div class = "adpt-title main-headers-txtplace">Масштабные публикации, рейтинги, заметки</div>
        </div>
        <div class = "main-headers-line"></div>
    </div>

	<div class = "main-post m-content last-art">
	<?php if (empty($posts))
		 {
			 echo '<p>Статьи отсутствуют</p>';
		 }
		 
		 else
			 
		 foreach ($posts as $post): ?>
        <a href="./viewpost/?id=<?php htmlecho ($post['id']); ?>" class = "post-place-2" style="background-image: url(images/<?php echo $post['imghead']; ?>)">
            <div class = "post-top-1">
                <p><?php echo date("Y.m.d H:i", strtotime($post['postdate'])); ?></p>
                <span class="post-rubrics"><?php htmlecho ($post['categoryname']); ?></span>
            </div>
            <div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($post['posttitle'])), 0, 7)))); ?>...</div>
		</a>
		
		<?php endforeach; ?>
    </div>

	<div class = "newsblock m-content rating-art">
	<?php if (empty ($postsTOP))
		 {
			 echo '<p>Пусто</p>';
		 }
		 
		else
			 
		foreach ($postsTOP as $postTOP): ?> 

		<a href = "./viewpost/?id=<?php htmlecho ($postTOP['id']); ?>" class = "post-place-1" style="background-image: url(images/<?php echo $postTOP['imghead']; ?>)">
            <div class = "post-top-1">
                <p><?php echo date("Y.m.d H:i", strtotime($postTOP['postdate'])); ?></p>
                <div class="article-rating">
                    <i class="fa fa-eye" aria-hidden="true" title="Просмотры"></i> <?php htmlecho ($postTOP['viewcount']); ?> 
				    <i class="fa fa-heartbeat" aria-hidden="true" title="Оценка"></i> <?php htmlecho ($postTOP['averagenumber']); ?>
                </div>
            </div>
            <div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($postTOP['posttitle'])), 0, 7)))); ?>...</div>
        </a>

		<?php endforeach; ?>

	</div>

	<div class = "footer-prev m-content">
		<div class="auth-top">
			<div class = "main-headers">
				<div class = "headers-places"> 
					<div class = "main-headers-txtplace">Наши авторы. Топ-7</div>
				</div>
				<div class = "main-headers-line"></div>
    		</div>
		
			<?php if (empty ($authorsTOP))
			{
				echo '<p>Нет авторов</p>';
			}
			
			else
			
			foreach ($authorsTOP as $authorTOP): ?>
				<div class = "for-top-auth"> 
					<img src="./avatars/<?php echo $authorTOP['avatar'];?>" alt="<?php echo $authorTOP['authorname'];?>">&nbsp; 
					<a href="./account/?id=<?php echo $authorTOP['id'];?>"><?php echo $authorTOP['authorname'];?></a>&nbsp; 
					<i class="fa fa-pencil-square-o" aria-hidden="true" title="Опубликовано материалов"></i><?php htmlecho ($authorTOP['countposts']); ?>&nbsp;  
					<i class="fa fa-diamond" aria-hidden="true" title="Рейтинг автора"></i> <?php htmlecho ($authorTOP['rating']); ?>
				</div>	 
			<?php endforeach; ?>
		</div>
		<div class = "social-links">
			<div class="zen-c-m">
				<div class = "main-headers">
					<div class = "headers-places"> 
						<div class = "main-headers-txtplace">Наш Дзен-канал</div>
					</div>
					<div class = "main-headers-line"></div>
				</div>
				<div class="zen-link-m">
					<a href="https://zen.yandex.ru/imagoz" rel = "nofollow"><img src="./zen-icon.png" alt="Наш Дзен-канал" title="zen.yandex.ru/imagoz"></a>
				</div>
			</div>
			<div class="vk-m">
				<div class = "main-headers">
					<div class = "headers-places"> 
						<div class = "main-headers-txtplace">Мы ВКонтакте</div>
					</div>
					<div class = "main-headers-line"></div>
				</div>
				<div class="scr-cont">
				<script type="text/javascript" src="https://vk.com/js/api/openapi.js?169"></script>

					<!-- VK Widget -->
					<div id="vk_groups"></div>
					<script type="text/javascript">
					VK.Widgets.Group("vk_groups", {mode: 3, no_cover: 1}, 54027668);
				</script>
				</div>
			</div>
		</div>
		<div class="about-proj">
			<div class = "main-headers">
				<div class = "headers-places"> 
					<div class = "main-headers-txtplace">О проекте</div>
				</div>
				<div class = "main-headers-line"></div>
			</div>
			<p>Добро пожаловать на портал <strong>IMAGOZ</strong> (от лат. imago - отражение)! Здесь мы объеденили в общую картину мира тему высоких технологий (hi-tech), индустрию компьютерных игр, 
			взгляд на самые необычные современные гаджеты, достижения науки и техники и насыщенную событиями жизнь интернета.</p>
			
			<p>Такой подход является на первый взгляд несколько 
			нестандартным, но мы считаем, что все эти тематики могут органично сочетаться, заинтересовав широкий круг разносторонне развитых читателей, которые хотят быть на острие 
			прогресса!</p>

			<p>Создатели портала <strong>IMAGOZ</strong> собирают самые интересные и актуальные новости и подают их в оригинальном авторском отражении. Мы не стремимся полностью охватить этот необъятный
			мир Hi-tech, науки, игр и прочего, но публикуем самые интересные материалы по этим темам.</p>
			
			<p>Стоит также отметить, что портал <strong>IMAGOZ</strong> возрождает такой казалось бы мёртвый в нашей стране своеобразный  жанр в публицистике, как <strong>"игрожур"</strong>. Игровая журналистика со своим своеобразным, самобытным 
			стилем изложения материала для многих связана с самыми тёплыми "ламповыми" воспоминаниями из 90-х, начала 2000 годов.</p> 
			
			<p><strong>IMAGOZ</strong> вбирает в себя лучшие черты этого условного жанра и порождает новое явление - <strong>Постигрожур</strong>. Постигрожур - публикации об играх и тому что интересно геймерам без "игрожура"!</p>
		</div>
	</div>

<?php 
/*Загрузка footer*/
include_once __DIR__ . '/footer.inc.php';?>

