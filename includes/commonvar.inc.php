<?php

//Переменные общие для разных шаблонов
$subHeaderNews = 'Новости игровой индустрии, высоких технологий и популярной науки';
$subHeaderPost = 'Масштабные публикации, рейтинги, заметки';
$subHeaderPromotion = 'Материалы от наших уважаемых рекламодателей';
$subHeaderRecomm = 'Статьи, которые порекомендовали для главной страницы!';
$subHeaderVideo = 'Видео-обзоры, прохождения игр от нашей команды';
$subRefDay = 'Что-то забавное, занимательное, любопытное';


if (!empty($pubFolder))
{
    if ($pubFolder == 'viewnews')
    {
        $linkHeaderSP = '<a href = "../viewallnews/"><h2>Новости</h2></a>';
        $subHeaderCP = $subHeaderNews;
    }
        
    elseif ($pubFolder == 'viewpost')
    {
        $linkHeaderSP = '<a href = "../viewallposts/"><h2>Статьи</h2></a>';
        $subHeaderCP = $subHeaderPost;
    }
    
    elseif ($pubFolder == 'viewpromotion')
    {
        $linkHeaderSP = '<a href = "../viewallpromotion/"><h2>Промоушен</h2></a>';
        $subHeaderCP = $subHeaderPromotion;
    }
    
    elseif ($pubFolder == 'publication')
    {
        $linkHeaderSP = '';
        $subHeaderCP = '';
    }

    elseif ($pubFolder == 'viewnewsset')
    {
        $linkHeaderSP = '<a href = "../newssets/"><h2>Новостные дайджесты</h2></a>';
        $subHeaderCP = $subHeaderNews;
    }
}



