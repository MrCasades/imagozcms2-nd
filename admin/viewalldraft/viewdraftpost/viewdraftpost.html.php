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

<div class="m-content">
	<div align="center">
		 <table>
		 <tr>
		  <td valign="top"><label for = "meta"> Теги:</label></td>
			   <?php if (empty($metas))
			  {
				 echo '';
		      }
		 
		      else
				  
			  foreach ($metas as $meta): ?>	  
				<td><div>	 
					<a href="../viewmetanews/?metaid=<?php echo $meta['id']; ?>"><?php echomarkdown ($meta['metaname']); ?></a>	 
				</div></td> 	
				<?php endforeach; ?>
		  </tr>
		 </table>
		</div>
		
		<div class = "post">	  
			<div  align="justify">
				<div class = "posttitle">
				  <?php echo ($date.' | Автор: <a href="../../../account/?id='.$authorId.'" style="color: white" >'.$nameAuthor).'</a>';?>
				  <p>Рубрика: <a href="../../../viewcategory/?id=<?php echo $categoryId; ?>" style="color: white"><?php echo $categoryName;?></a></p>
				</div>
				
				<?php if ($imgHead == '')
					{
						$img = '';//если картинка в заголовке отсутствует
						echo $img;
					}
						else 
					{
						$img = '<p align="center"><img width = "80%" height = "80%" src="../../../images/'.$imgHead.'"'. ' alt="'.$imgAlt.'"'.'></p>';//если картинка присутствует
					}?>
					<p><?php echo $img;?></p>
					<p><?php echomarkdown_pub ($articleText); ?></p>
					<p align="center"><?php echo $video; ?></p>
					<p><a name="bottom"></a></p> 
					<p><?php echo $pubAndUpd; ?></p>
		</div>	   	
</div>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>