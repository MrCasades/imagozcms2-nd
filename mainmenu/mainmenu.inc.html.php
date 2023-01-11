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
            <li class="menu-item"><a href="#publications">Публикации</a>
                <ul>
                    <li class="menu-item"><a href="<?php echo '//'.MAIN_URL;?>/viewallnews/">Новости</a></li>
                    <li class="menu-item"><a href="<?php echo '//'.MAIN_URL;?>/viewallposts/">Статьи</a></li>
                    <li class="menu-item"><a href="<?php echo '//'.MAIN_URL;?>/viewallvideos/">Видео</a></li>
                    <li class="menu-item"><a href="<?php echo '//'.MAIN_URL;?>/viewallpromotion/">Промоушен</a></li>
                    <li class="menu-item"><a href="<?php echo '//'.MAIN_URL;?>/viewallrecommpost/">Рекомендации</a></li>        
                </ul>        
            </li>           
            <li class="menu-item"><a href="<?php echo '//'.MAIN_URL;?>/admin/adminmail/?addmessage#bottom"> Обратная связь</a></li> 
            <li class="menu-item"><a href="<?php echo '//'.MAIN_URL;?>/eshop/">Магазин</a></li>                                     
        </ul>
    </div>
</div>