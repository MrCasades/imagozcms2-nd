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
            <li class="menu-item"><a id="auth" href="#" ><i class="fa fa-home" aria-hidden="true"></i></a></li>
        </ul>
    </div>
</div>