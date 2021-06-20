<div class = "main-headers">
    <div class = "headers-places"> 
            <div class = "main-headers-place"><a href = "../account/allauthornews/?id=<?php htmlecho ($idAuthor); ?>">Новости автора</a></div>
    </div>
    <div class = "main-headers-line"></div>
</div>

<div class = "newsblock m-content">
	<?php  if (empty ($newsIn))
		 {
			 echo '<p>Автор не написал ни одной новости</p>';
		 }
		 
		 else

		 foreach ($newsIn as $news): ?>

		<a href = "../viewnews/?id=<?php htmlecho ($news['id']); ?>" class = "post-place-1" style="background-image: url(../images/<?php htmlecho ($news['imghead']); ?>)">
			<div class = "post-top-1"><?php htmlecho ($news['newsdate']); ?></div>
				<div class = "post-bottom-1"><?php htmlecho ($news['newstitle']); ?></div>
		</a>

	<?php endforeach; ?>
</div>

<div class = "main-headers">
    <div class = "headers-places"> 
            <div class = "main-headers-place"><a href = "../account/allauthorpost/?id=<?php htmlecho ($idAuthor); ?>">Статьи автора</a></div>
    </div>
    <div class = "main-headers-line"></div>
</div>

<div class = "newsblock m-content">
	<?php  if (empty ($posts))
		 {
			 echo '<p>Автор не написал ни одной новости</p>';
		 }
		 
		 else

		 foreach ($posts as $post): ?>

		<a href = "../viewnews/?id=<?php htmlecho ($post['id']); ?>" class = "post-place-1" style="background-image: url(../images/<?php htmlecho ($post['imghead']); ?>)">
			<div class = "post-top-1"><?php htmlecho ($post['postdate']); ?></div>
				<div class = "post-bottom-1"><?php htmlecho ($post['posttitle']); ?></div>
		</a>

	<?php endforeach; ?>
</div>
	
	
	<div>
	  <div>
	   <table>
		<tr>
		    <td><a href="../account/allauthornews/?id=<?php htmlecho ($idAuthor); ?>">Новости автора</a></td>
		    <td><a href="../account/allauthorpost/?id=<?php htmlecho ($idAuthor); ?>">Статьи автора</a></td>
		</tr> 
		<tr>
		<?php if (!isset($newsIn))
		 {
			 $noPosts = '<td><p align = "center">Автор не написал ни одной новости</p></td>';
			 echo $noPosts;
			 $newsIn = null;
		 }
		 
		 else
			 
		 echo '<td>'; 
		 foreach ($newsIn as $news): ?> 
		  <ul>
			<li><a href="../viewnews/?id=<?php htmlecho ($news['id']); ?>"><?php htmlecho ($news['newstitle']); ?></a></li> 
		  </ul>				
		 <?php endforeach; ?></td>
		 
	  </div>
      <div>	  
		 
		<?php if (!isset($posts))
		 {
			 $noPosts = '<td><p align = "center">Автор не написал ни одной новости</p></td>';
			 echo $noPosts;
			 $posts = null;
		 }
		 
		 else
			
		 echo '<td>';
		 foreach ($posts as $post): ?> 
		  <ul>
			<li><a href="../viewpost/?id=<?php htmlecho ($post['id']); ?>"><?php htmlecho ($post['posttitle']); ?></a></li>
		  </ul>			
		 <?php endforeach; ?></td>
		 </tr>
	    </table>	 
	  </div>	 
	</div>