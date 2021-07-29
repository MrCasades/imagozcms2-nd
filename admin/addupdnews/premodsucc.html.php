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
	
	<div class = "maincont_for_view"> 
	 <div class = "post" align="center">
		<p>Материал сохранён в черновике! Если хотите отправить его сразу на проверку редактору, нажмите на кнопку ниже.</p>
		
		<p>Число знаков в статье (без пробелов) <?php echo $lengthText;?> | Стоимость  <?php echo $fullPrice;?>, с учётом бонуса Х<?php echo $bonus;?></p>
		<form action = "../../admin/addupdnews/" method = "post" id = "confirmok">
			<input type = "hidden" name = "id" value = "<?php echo $idpost_ind; ?>">
			<input type = "submit" name = "action" value = "ОПУБЛИКОВАТЬ" class= "btn_1">
		</form>
	 </div>	
		<h2>Предварительный просмотр</h2>
		<div align="center">
		 <table>
		 <tr>
		  <td valign="top"><label for = "meta"> Теги:</label></td>
			   <?php if (empty ($metas))
			  {
				 echo ' ';
		      }
		 
		      else
				  
			  foreach ($metas as $meta): ?>	  
				<td><div>	 
					<a href="../../viewmetanews/?metaid=<?php echo $meta['id']; ?>"><?php echomarkdown ($meta['metaname']); ?></a>	 
				</div></td> 	
				<?php endforeach; ?>
		  </tr>
		 </table>
		</div>
		
		<div class = "post">
		 <?php foreach ($newsIn as $news): ?> 	  
			<div  align="justify">
			
				<div class = "posttitle">
				  <?php echo ($news['newsdate']. ' | Автор: <a href="../../account/?id='.$news['idauthor'].'" style="color: white" >'.$news['authorname']).'</a>';?>
				  <p>Рубрика: <a href="../../viewcategory/?id=<?php echo $news['categoryid']; ?>" style="color: white"><?php echo $news['categoryname'];?></a></p>
				</div>
				   			 
				<?php if ($news['imghead'] == '')
					{
						$img = '';//если картинка в заголовке отсутствует
						echo $img;
					}
						else 
					{
						$img = '<p align="center"><img width = "60%" height = "40%" src="../../images/'.$news['imghead'].'"'. ' alt="'.$news['imgalt'].'"'.'></p>';//если картинка присутствует
					}?>
					<p><?php echo $img;?></p>
					<p><?php echomarkdown ($news['textnews']); ?></p>
					<p><?php echo $delAndUpd; ?></p>
			</div>	   	
		 <?php endforeach; ?>
		</div>
	</div> 
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>