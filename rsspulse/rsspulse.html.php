<? 
	/*Загрузка функций в шаблон*/
	include_once MAIN_FILE . '/includes/func.inc.php';

$content = '<?xml version="1.0" encoding="UTF-8"?>

<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/">

<channel>

<title>Hi-Tech новости, игры, наука, интернет в отражении на imagoz.ru</title>

<link>https://imagoz.ru/</link>

<description>

Портал IMAGOZ. Место где мы рассматриваем мир Hi-Tech, игровую индустрию, науку и технику в оригинальном авторском отражении!

</description>
<image>
     <url>https://imagoz.ru/logomain.jpg</url>
</image>

<language>ru</language>'?>

<?php foreach ($newssets as $newsset): ?>

<?php 
      $articleNews = markdown2html_pub($newsset['text']);
?>        
	
<?php $content .= '<item>

<title>'. $newsset['title'].'</title>

<guid isPermaLink="false">newssetid='.$newsset['id'].'</guid>

<link>https://imagoz.ru/viewnewsset/?id='.$newsset['id'].'</link>

<pubDate>'.date("D, j M Y G:i:s", strtotime($newsset['date'])).' +0300</pubDate>

<author>'.$newsset['authorname'].'</author>

<category>'.$newsset['categoryname'].'</category>

<enclosure url="https://imagoz.ru/images/'.$newsset['imghead'].'" type= "image/jpeg"/>

<description>

<![CDATA['.

markdown2html_pub($newsset['description']).'

]]>

</description>

<content:encoded>

        <![CDATA[

            '.$articleNews.'<br><br>Ставьте лайки, комментируйте, подписывайтесь на КАНАЛ!

        ]]>

</content:encoded>

</item>';?>

<?php endforeach; ?>
	
	
<?php foreach ($newsMain as $newsMain_3): ?>

<?php $video = $newsMain_3['videoyoutube'] != '' ? '<br><br><figure><iframe width="560" height="315" src="'.$newsMain_3['videoyoutube'].'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></figure>' : '';
      $articleNews = markdown2html_pub($newsMain_3['textnews']);
?>        
	
<?php $content .= '<item>

<title>'. $newsMain_3['newstitle'].'</title>

<guid isPermaLink="false">newsid='.$newsMain_3['id'].'</guid>

<link>https://imagoz.ru/viewnews/?id='.$newsMain_3['id'].'</link>

<pubDate>'.date("D, j M Y G:i:s", strtotime($newsMain_3['newsdate'])).' +0300</pubDate>

<author>'.$newsMain_3['authorname'].'</author>

<category>'.$newsMain_3['categoryname'].'</category>

<enclosure url="https://imagoz.ru/images/'.$newsMain_3['imghead'].'" type= "image/jpeg"/>

<description>

<![CDATA['.

markdown2html_pub($newsMain_3['description']).'

]]>

</description>

<content:encoded>

        <![CDATA[

        '.delDetails(isertTagFigure($articleNews)).$video.'<br><br>Ставьте лайки, комментируйте, подписывайтесь на канал!

        ]]>

</content:encoded>

</item>';?>

<?php endforeach; ?>

<?php foreach ($posts as $post): ?>

<?php $video = $post['videoyoutube'] != '' ? '<br><br><figure><iframe width="560" height="315" src="'.$post['videoyoutube'].'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></figure>' : ''; 
      $articlePost = markdown2html_pub($post['text']);
?> 

<?php $content .= '<item>

<title>'.$post['posttitle'].'</title>

<guid isPermaLink="false">postid='.$post['id'].'</guid>

<link>https://imagoz.ru/viewpost/?id='.$post['id'].'</link>

<pubDate>'.date("D, j M Y G:i:s", strtotime($post['postdate'])).' +0300</pubDate>

<author>'.$post['authorname'].'</author>

<category>'.$post['categoryname'].'</category>

<enclosure url="https://imagoz.ru/images/'.$post['imghead'].'" type= "image/jpeg"/>

<description>

<![CDATA['.

markdown2html_pub ($post['description']).'

]]>

</description>

<content:encoded>

        <![CDATA[

        '.delDetails(isertTagFigure($articlePost)).$video.'<br><br>Ставьте лайки, комментируйте, подписывайтесь на канал!

        ]]>

</content:encoded>

</item>';?>

<?php endforeach; ?>

<?php $content .='</channel>

</rss>';

/*Генерация rss-ленты*/
$rssPulse = MAIN_FILE.'/rsspulse.xml';

file_put_contents($rssPulse, $content);

echo 'rsspulse Файл создан!'

?>