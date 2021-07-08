<div class="menu-container">
    <div class="menu">
        <ul>
            <li class="menu-item"><a href="#link">Рубрики</a>
                <ul>
                    <?php 
                     if (empty($categorysMM))
                     {    
                        echo '<p align = "center">Новости в рубрике отсутствуют!</p>';
                     }
                                
                     else
                                
                     foreach ($categorysMM as $category): ?>
                            <li><a href="<?php echo '//'.MAIN_URL;?>/viewcategory/?id=<?php echo $category['id']; ?>" class="btn btn-primary btn-sm btn-block"><?php echomarkdown ($category['category']); ?></a></li>
                     <?php endforeach; ?>	
                </ul>
            </li>
            <li class="menu-item"><a href="<?php echo '//'.MAIN_URL;?>/searchpost/">Поиск</a></li>
            <li class="menu-item"><a href="<?php echo '//'.MAIN_URL;?>/cooperation/">Сотрудничество</a></li>
            <li class="menu-item"><a href="<?php echo '//'.MAIN_URL;?>/promotion/">Промоушен</a></li>
            <li class="menu-item"><a href="<?php echo '//'.MAIN_URL;?>/admin/adminmail/?addmessage#bottom"><i class="fa fa-envelope" aria-hidden="true"></i> обратная связь</a></li>

            <?php if (!isset($_SESSION['loggIn'])):?>
                <li class="menu-item"><a href="<?php echo '//'.MAIN_URL;?>/admin/registration/?log#bottom"><i class="fa fa-home" aria-hidden="true"></i> авторизация</a></li>
            <?php else:?>
                <form action = " " method = "post">
					<input type = "hidden" name = "action" value = "logout">
					<input type = "hidden" name = "goto" value = "//<?php echo MAIN_URL;?>">
					<input class="btn_2" type="submit" value="Exit">
			     </form>    
            <?php endif;?>
        </ul>
    </div>
</div>