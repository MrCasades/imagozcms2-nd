<div class="categorypanel">
<h6 align = "center">Рубрики</h6>
	 <?php if (!isset($categorys))
		 {
			 $noPosts = '<p align = "center">Нет категорий</p>';
			 echo $noPosts;
			 $categorys = null;
		 }
		 
		 else
		
		foreach ($categorys as $category): ?> 
		  
		<div>  
			<a href="../viewcategory/?id=<?php echo $category['id']; ?>" class="btn btn-primary btn-sm btn-block"> <strong><?php echomarkdown ($category['category']); ?></strong></a><br>  	
		</div>	   	
	 <?php endforeach; ?> 

<h6 align = "center">Топ-5 статей</h6>
	 <?php if (!isset($postsTOP))
		 {
			 $noPosts = '<p align = "center">Нет статей</p>';
			 echo $noPosts;
			 $postsTOP = null;
		 }
		 
		 else
		
		foreach ($postsTOP as $postTOP): ?> 
		  
		<div class = "fortop5">  
          <img width = "10%" height = "10%" src="./view.jpg" alt="Число просмотров материала" title="Просмотры"> <?php htmlecho ($postTOP['viewcount']); ?> 
		  <img width = "8%" height = "8%" src="./like.jpg" alt="Оценка материала" title="Оценка"> <?php htmlecho ($postTOP['averagenumber']); ?>			
			<a href="../viewpost/?id=<?php echo $postTOP['id']; ?>"> <?php echomarkdown ($postTOP['posttitle']); ?></a>
		</div>	   	
	 <?php endforeach; ?> 	 
</div>