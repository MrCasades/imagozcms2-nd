<div class="categorypanel">
 <div>
		<h4 align = "center" title="Для того чтобы рекомендовать статью, жмите кнопку 'Рекомендовать статью' под текстом публикации. Услуга платная!">Рекомендованные статьи</h4>
		<?php if (!isset($recomPosts))
		 {
			 $noPosts = '<p align = "center">Статьи отсутствуют</p>';
			 echo $noPosts;
			 $recomPosts = null;
		 }
		 
		 else
			 
		 foreach ($recomPosts as $recomPost): ?> 
		  
			<div class = "post">
				<p><a href="/viewpost/?id=<?php htmlecho ($recomPost['id']); ?>"><?php htmlecho ($recomPost['posttitle']); ?></a></p>
			</div>			
		 <?php endforeach; ?>
		 <div class="for_allposts_link"><p align = "center"><a href="/viewallrecommpost/" style="color: white">Все рекомендации</a></p></div>
 </div> 
	
 <div>
		<h4 align = "center" title="Для того чтобы рекомендовать статью, жмите кнопку 'Рекомендовать статью' под текстом публикации. Услуга платная!">Рекомендованный промоушен</h4>
		<?php if (!isset($recomPromotions))
		 {
			 $noPosts = '<p align = "center">Статьи отсутствуют</p>';
			 echo $noPosts;
			 $recomPromotions = null;
		 }
		 
		 else
			 
		 foreach ($recomPromotions as $recomPromotion): ?> 
		  
			<div class = "post">
				<p><a href="/viewpromotion/?id=<?php htmlecho ($recomPromotion['id']); ?>"><?php htmlecho ($recomPromotion['promotiontitle']); ?></a></p>
			</div>			
		 <?php endforeach; ?>
		 <div class="for_allposts_link"><p align = "center"><a href="/viewallrecommpromotion/" style="color: white">Все рекомендации</a></p></div>
 </div> 
	
 <div>
		<h4 align = "center">Новостная лента</h4>
		<?php if (!isset($newsIn))
		 {
			 $noPosts = '<p align = "center">Новости отсутствуют</p>';
			 echo $noPosts;
			 $newsIn = null;
		 }
		 
		 else
			 
		 foreach ($newsIn as $news): ?> 
		  
			<div class = "post">
				<div  class = "posttitle"><strong><?php htmlecho ($news['newsdate']); ?> </strong></div>
				<p><a href="/viewnews/?id=<?php htmlecho ($news['id']); ?>"><?php htmlecho ($news['newstitle']); ?></a></p>
			</div>			
		 <?php endforeach; ?>
		 <div class="for_allposts_link"><p align = "center"><a href="/viewallnews/" style="color: white">Все новости</a></p></div>
 </div> 
	
<div>
	<h4 align = "center">Наш Дзен-канал</h4>
	<p align = "center"><a href="https://zen.yandex.ru/imagoz" rel = "nofollow"><img width = "75%" height = "75%" src="<?php echo '//'.$_SERVER['SERVER_NAME'];?>/zen-icon.png" alt="Наш Дзен-канал" title="zen.yandex.ru/imagoz"></a></p>
</div>	
	
	<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<!-- ForMainPage -->
	<ins class="adsbygoogle"
		 style="display:block"
		 data-ad-client="ca-pub-1348880364936413"
		 data-ad-slot="4312352787"
		 data-ad-format="auto"
		 data-full-width-responsive="true"></ins>
	<script>
		 (adsbygoogle = window.adsbygoogle || []).push({});
	</script>
 
 <div>
  <h4 align = "center">Случайные теги новостей</h4>
	 <?php if (!isset($metas_1))
		 {
			 $noPosts = '<p align = "center">Нет тегов</p>';
			 echo $noPosts;
			 $metas_1 = null;
		 }
		 
		 else
		
		foreach ($metas_1 as $meta): ?> 
		  
		<div>  
			<strong><a href="/viewmetanews/?metaid=<?php echo $meta['id']; ?>" class="btn btn-primary btn-sm btn-block"> <strong><?php echomarkdown ($meta['meta']); ?></strong></a></strong><br>  	
		</div>	   	
	 <?php endforeach; ?>
  </div>

 <div>
  <h4 align = "center">Случайные теги статей</h4>
	 <?php if (!isset($metas_2))
		 {
			 $noPosts = '<p align = "center">Нет тегов</p>';
			 echo $noPosts;
			 $metas_2 = null;
		 }
		 
		 else
		
		foreach ($metas_2 as $meta): ?> 
		  
		<div>  
			<a href="/viewmetapost/?metaid=<?php echo $meta['id']; ?>" class="btn btn-primary btn-sm btn-block"> <strong><?php echomarkdown ($meta['meta']); ?></strong></a><br>  	
		</div>	   	
	 <?php endforeach; ?>
 </div>
	
<div>
  <h4 align = "center">Случайные теги промоушен</h4>
	 <?php if (!isset($metas_3))
		 {
			 $noPosts = '<p align = "center">Нет тегов</p>';
			 echo $noPosts;
			 $metas_3 = null;
		 }
		 
		 else
		
		foreach ($metas_3 as $meta): ?> 
		  
		<div>  
			<a href="/viewmetapromotion/?metaid=<?php echo $meta['id']; ?>" class="btn btn-primary btn-sm btn-block"> <strong><?php echomarkdown ($meta['meta']); ?></strong></a><br>  	
		</div>	   	
	 <?php endforeach; ?>
 </div>
  
<h4 align = "center">Топ-5 новостей</h4>
	 <?php if (!isset($newsInTOP))
		 {
			 $noPosts = '<p align = "center">Нет статей</p>';
			 echo $noPosts;
			 $newsInTOP = null;
		 }
		 
		 else
		
		foreach ($newsInTOP as $newsTOP): ?> 
		  
		<div class = "fortop5">  
          <img width = "10%" height = "10%" src="<?php echo '//'.$_SERVER['SERVER_NAME'];?>/view.jpg" alt="Число просмотров материала" title="Просмотры"> <?php htmlecho ($newsTOP['viewcount']); ?> 
		  <img width = "8%" height = "8%" src="<?php echo '//'.$_SERVER['SERVER_NAME'];?>/like.jpg" alt="Оценка материала" title="Оценка"> <?php htmlecho ($newsTOP['averagenumber']); ?>			
			<a href="/viewnews/?id=<?php echo $newsTOP['id']; ?>"> <?php echomarkdown ($newsTOP['newstitle']); ?></a>
		</div>	   	
	 <?php endforeach; ?>   
	 
<h4 align = "center">Топ-5 статей</h4>
	 <?php if (!isset($postsTOP))
		 {
			 $noPosts = '<p align = "center">Нет статей</p>';
			 echo $noPosts;
			 $postsTOP = null;
		 }
		 
		 else
		
		foreach ($postsTOP as $postTOP): ?> 
		  
		<div class = "fortop5">  
          <img width = "10%" height = "10%" src="<?php echo '//'.$_SERVER['SERVER_NAME'];?>/view.jpg" alt="Число просмотров материала" title="Просмотры"> <?php htmlecho ($postTOP['viewcount']); ?> 
		  <img width = "8%" height = "8%" src="<?php echo '//'.$_SERVER['SERVER_NAME'];?>/like.jpg" alt="Оценка материала" title="Оценка"> <?php htmlecho ($postTOP['averagenumber']); ?>			
			<a href="/viewpost/?id=<?php echo $postTOP['id']; ?>"> <?php echomarkdown ($postTOP['posttitle']); ?></a>
		</div>	   	
	 <?php endforeach; ?> 
	
<h4 align = "center">Топ-5 промоушен</h4>
	 <?php if (!isset($promotionsTOP))
		 {
			 $noPosts = '<p align = "center">Нет статей</p>';
			 echo $noPosts;
			 $promotionsTOP = null;
		 }
		 
		 else
		
		foreach ($promotionsTOP as $promotionTOP): ?> 
		  
		<div class = "fortop5">  
          <img width = "10%" height = "10%" src="<?php echo '//'.$_SERVER['SERVER_NAME'];?>/view.jpg" alt="Число просмотров материала" title="Просмотры"> <?php htmlecho ($promotionTOP['viewcount']); ?> 
		  <img width = "8%" height = "8%" src="<?php echo '//'.$_SERVER['SERVER_NAME'];?>/like.jpg" alt="Оценка материала" title="Оценка"> <?php htmlecho ($promotionTOP['averagenumber']); ?>			
			<a href="/viewpromotion/?id=<?php echo $promotionTOP['id']; ?>"> <?php echomarkdown ($promotionTOP['promotiontitle']); ?></a>
		</div>	   	
	 <?php endforeach; ?> 
	 
	<!-- Yandex.RTB R-A-448222-7 -->
<div id="yandex_rtb_R-A-448222-7"></div>
<script type="text/javascript">
    (function(w, d, n, s, t) {
        w[n] = w[n] || [];
        w[n].push(function() {
            Ya.Context.AdvManager.render({
                blockId: "R-A-448222-7",
                renderTo: "yandex_rtb_R-A-448222-7",
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
	
	<h4 align = "center">Топ-5 авторов</h4>
	 <?php if (!isset($authorsTOP))
		 {
			 $noPosts = '<p align = "center">Нет авторов</p>';
			 echo $noPosts;
			 $postsTOP = null;
		 }
		 
		 else
		
		foreach ($authorsTOP as $authorTOP): ?> 
		  
		<div class = "fortop5">  
          <img width = "40 px" height = "40 px" src="/avatars/<?php echo $authorTOP['avatar'];?>" alt="<?php echo $authorTOP['authorname'];?>">
		  <a href="/account/?id=<?php echo $authorTOP['id'];?>"><?php echo $authorTOP['authorname'];?></a>
		</div>	   	
	 <?php endforeach; ?>
	
	<?php echo $hederContest; ?>
	 <?php if (!isset($contestsTOP))
		 {
			 $noPosts = '';
			 echo $noPosts;
			 $postsTOP = null;
		 }
		 
		 else
		
		foreach ($contestsTOP as $contestTOP): ?> 
		  
		<div class = "fortop5">
		 	
          <img width = "40 px" height = "40 px" src="/avatars/<?php echo $contestTOP['avatar'];?>" alt="<?php echo $contestTOP['authorname'];?>">
		  <a href="/account/?id=<?php echo $contestTOP['id'];?>"><?php echo $contestTOP['authorname'];?></a> | 
		  <?php echo $contestTOP['contestscore'];?>	 
		  
		</div>	   	
	 <?php endforeach; ?>

<div>
<h4 align = "center">Наше сообщество</h4>
	 
	<script type="text/javascript" src="https://vk.com/js/api/openapi.js?160"></script>

	<!-- VK Widget -->
	 <div id="vk_groups"></div>
		<script type="text/javascript">
		VK.Widgets.Group("vk_groups", {mode: 3, no_cover: 1, width: "160"}, 54027668);
	</script>
</div>
</div>


