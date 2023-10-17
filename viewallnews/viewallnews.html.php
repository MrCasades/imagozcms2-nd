<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
	<div class = "main-headers-circle"></div>
	<div class = "main-headers-content">
		<h2><?php htmlecho ($headMain); ?></h2>
		<div class = "main-headers-line"></div>
		<div class = "sub-header"><?php htmlecho ($subHeaderNews); ?></div>
	</div>
</div>

<div class = "main-post m-content">
	<?php if (empty($newsIn))
	 {
		echo '<p>Статьи отсутствуют</p>';
	 }
		 
	 else
			 
	 foreach ($newsIn as $news): ?>
    <a href="../viewnews/?id=<?php htmlecho ($news['id']); ?>" class = "post-place-2" style="background-image: url(../images/<?php echo $news['imghead']; ?>)">
        <div class = "post-top-1">
            <p><?php echo date("Y.m.d H:i", strtotime($news['newsdate'])); ?></p>
			<span class="post-rubrics"><?php htmlecho ($news['categoryname']); ?></span>
        </div>
        <div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($news['newstitle'])), 0, 7)))); ?>...</div>
	</a>
		
	<?php endforeach; ?>
	
</div>

<div class="page-output">	
		 <?php
			/*Постраничный вывод информации*/
			if($page > 1){
				echo "<a href='index.php?page=1'><button class='btn_1'><<</button></a>";
				echo "<a href='index.php?page=$previousPage'><button class='btn_1'><</button></a>";
			}

			if ($pagesCount <= 10)
			{
				for ($i = 1; $i <= $pagesCount; $i++) 
				{
					// если текущая старница
					if($i == $page)
					{
						echo "<a href='index.php?page=$i'><button class='btn_2'>$i</button></a> ";
					} 
					else 
					{
						echo "<a href='index.php?page=$i'><button class='btn_1'>$i</button></a> ";
					}
				}
			}

			elseif ($pagesCount > 10)
			{
				if($page <= 4) 
				{			
					for ($i = 1; $i < 8; $i++) {		 
					   if ($i == $page) {
						  echo "<a href='index.php?page=$i'><button class='btn_2'>$i</button></a>";	
						   }
						   
						   else
						   {
							  echo "<a href='index.php?page=$i'><button class='btn_1'>$i</button></a>";
						   }
				   }
				   echo "<a>...</a>";
				   echo "<a href='index.php?page=$secondLast'><button class='btn_1'>$secondLast</button></a>";
				   echo "<a href='index.php?page=$pagesCount'><button class='btn_1'>$pagesCount</button></a>";
				}

				elseif($page > 4 && $page < $pagesCount - 4) 
				{		 
					echo "<a href='index.php?page=1'><button class='btn_1'>1</button></a>";
					echo "<a href='index.php?page=2'><button class='btn_1'>2</button></a>";
					echo "<a>...</a>";
					for ($i = $page - 2;$i <= $page + 2;$i++) 
					{		
						if ($i == $page) 
						{
							echo "<a href='index.php?page=$i'><button class='btn_2'>$i</button></a>";	
						}
						else
						{
							echo "<a href='index.php?page=$i'><button class='btn_1'>$i</button></a>";
						}                  
					}
					echo "<a>...</a>";
				    echo "<a href='index.php?page=$secondLast'><button class='btn_1'>$secondLast</button></a>";
				    echo "<a href='index.php?page=$pagesCount'><button class='btn_1'>$pagesCount</button></a>";
				}
				else 
				{
					echo "<a href='index.php?page=1'><button class='btn_1'>1</button></a>";
					echo "<a href='index.php?page=2'><button class='btn_1'>2</button></a>";
					echo "<a>...</a>";
					for ($i = $pagesCount - 6;$i <= $pagesCount;$i++) 
					{
						if ($i == $page) 
						{
							echo "<a href='index.php?page=$i'><button class='btn_2'>$i</button></a>";
						}
						else
						{
							echo "<a href='index.php?page=$i'><button class='btn_1'>$i</button></a>";
						}                   
					}
				}
			}

			if($page < $pagesCount){				
				echo "<a href='index.php?page=$nextPage'><button class='btn_1'>></button></a>";
				echo "<a href='index.php?page=$pagesCount'><button class='btn_1'>>></button></a>";
			}
			
			?>
</div>	
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>
