<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
    <div class = "headers-places"> 
        <div class = "main-headers-txtplace"><h1><?php htmlecho ($headMain); ?> | <a href="#" onclick="history.back();">Назад</a></h1></div>
    </div>
    <div class = "main-headers-line"></div>
</div>


<div class="m-content">
	<div>
		<h3>Статьи</h3>
			
		<?php if (empty ($posts))
		{ 
			echo '<p>Отклонённые материалы отсутствуют</p>';
		}
			
		else
			
		foreach ($posts as $post): ?> 
			<div class = "post">
				<div class = "posttitle">
					<?php echo ($post['postdate']. ' | Автор: <a href="../../account/?id='.$post['idauthor'].'" style="color: white" >'.$post['authorname']).'</a>';
					echo $taskData = ($post['idtask'] == 0) ? ' ' : ' | <strong><a href="../../admin/refused/viewtask/?id='.$post['idtask'].'" style="color: red" onclick="viewTask(this.href); return false;" target="_blank" >Просмотр задания</a></strong>';?>
				</div>
				<div>
					<h3 align = "center"><?php echo $post['posttitle'];?></h3>		  	
				</div> 
				<div class = "posttitle" align="center">
					Причина отказа
				</div>
				<div>
					<p><?php echomarkdown ($post['reasonrefusal']);?></p>
					<form action = "../../admin/addupdpost/" method = "post">
							<input type = "hidden" name = "id" value = "<?php echo $post['id'];?>">
							<input type = "submit" name = "action" value = "Переделать" class="btn_1">
							<input type = "submit" name = "action" value = "Del" class="btn_2">
						</form>
				</div>
			</div>			
			<?php endforeach; ?> 
		</div>	
			
			<hr/>
			<div>
				<h3>Новости</h3>
			
			<?php if (empty ($newsIn))
			{ 
				echo '<p>Отклонённые материалы отсутствуют</p>';
			}
			
			else
			
			foreach ($newsIn as $news): ?> 
			<div class = "post">
				<div class = "posttitle">
					<?php echo ($news['newsdate']. ' | Автор: <a href="../../account/?id='.$news['idauthor'].'" style="color: white" >'.$news['authorname']).'</a>';
					echo $taskData = ($news['idtask'] == 0) ? ' ' : ' | <strong><a href="../../admin/refused/viewtask/?id='.$news['idtask'].'" style="color: red" onclick="viewTask(this.href); return false;" target="_blank">Просмотр задания</a></strong>';?>
				</div>
				<div>
					<h3 align = "center"><?php echo $news['newstitle'];?></h3>		  	
				</div> 
				<div class = "posttitle" align="center">
					Причина отказа
				</div>
				<div>
					<p><?php echomarkdown ($news['reasonrefusal']);?></p>
					<form action = "../../admin/addupdnews/" method = "post">
							<input type = "hidden" name = "id" value = "<?php echo $news['id'];?>">
							<input type = "submit" name = "action" value = "Переделать" class="btn_1">
							<input type = "submit" name = "action" value = "Del" class="btn_2">
						</form>
				</div>
			</div>			
			<?php endforeach; ?> 
		</div>	
			
			<hr/>
		<div>
				<h3>Промоушен</h3>
			
			<?php if (empty ($promotions))
			{ 
				echo '<p>Отклонённые материалы отсутствуют</p>';
			}
			
			else
			
			foreach ($promotions as $promotion): ?> 
			<div class = "post">
				<div class = "posttitle">
					<?php echo ($promotion['promotiondate']. ' | Автор: <a href="../../account/?id='.$promotion['idauthor'].'" style="color: white" >'.$promotion['authorname']).'</a>';?>
				</div>
				<div>
					<h3 align = "center"><?php echo $promotion['promotiontitle'];?></h3>		  	
				</div> 
				<div class = "posttitle" align="center">
					Причина отказа
				</div>
				<div>
					<p><?php echomarkdown ($promotion['reasonrefusal']);?></p>
					<form action = "../../admin/addupdpromotion/" method = "post">
							<input type = "hidden" name = "id" value = "<?php echo $promotion['id'];?>">
							<input type = "submit" name = "action" value = "Переделать" class="btn_1">
							<input type = "submit" name = "action" value = "Del" class="btn_2">
						</form>
				</div>
			</div>			
			<?php endforeach; ?> 
		</div>	
		<p><a name="bottom"></a></p>
</div>
  		
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>		