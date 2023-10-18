<div class="page-output">	
		 <?php
			/*Постраничный вывод информации*/
			if($page > 1){
				echo "<a href='index.php?page=1$additData'><button class='btn_1'><<</button></a>";
				echo "<a href='index.php?page=$previousPage$additData'><button class='btn_1'><</button></a>";
			}

			if ($pagesCount <= 10)
			{
				for ($i = 1; $i <= $pagesCount; $i++) 
				{
					// если текущая старница
					if($i == $page)
					{
						echo "<a href='index.php?page=$i$additData'><button class='btn_2'>$i</button></a> ";
					} 
					else 
					{
						echo "<a href='index.php?page=$i$additData'><button class='btn_1'>$i</button></a> ";
					}
				}
			}

			elseif ($pagesCount > 10)
			{
				if($page <= 4) 
				{			
					for ($i = 1; $i < 8; $i++) {		 
					   if ($i == $page) {
						  echo "<a href='index.php?page=$i$additData'><button class='btn_2'>$i</button></a>";	
						   }
						   
						   else
						   {
							  echo "<a href='index.php?page=$i$additData'><button class='btn_1'>$i</button></a>";
						   }
				   }
				   echo "<a>...</a>";
				   echo "<a href='index.php?page=$secondLast$additData'><button class='btn_1'>$secondLast</button></a>";
				   echo "<a href='index.php?page=$pagesCount$additData'><button class='btn_1'>$pagesCount</button></a>";
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
							echo "<a href='index.php?page=$i$additData'><button class='btn_2'>$i</button></a>";	
						}
						else
						{
							echo "<a href='index.php?page=$i$additData'><button class='btn_1'>$i</button></a>";
						}                  
					}
					echo "<a>...</a>";
				    echo "<a href='index.php?page=$secondLast$additData'><button class='btn_1'>$secondLast</button></a>";
				    echo "<a href='index.php?page=$pagesCount$additData'><button class='btn_1'>$pagesCount</button></a>";
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
							echo "<a href='index.php?page=$i$additData'><button class='btn_2'>$i</button></a>";
						}
						else
						{
							echo "<a href='index.php?page=$i$additData'><button class='btn_1'>$i</button></a>";
						}                   
					}
				}
			}

			if($page < $pagesCount){				
				echo "<a href='index.php?page=$nextPage$additData'><button class='btn_1'>></button></a>";
				echo "<a href='index.php?page=$pagesCount$additData'><button class='btn_1'>>></button></a>";
			}
			
			?>
</div>	