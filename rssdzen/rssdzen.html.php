<? 
	/*Загрузка функций в шаблон*/
	include_once MAIN_FILE . '/includes/func.inc.php';

$content = '<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0"
    xmlns:content="http://purl.org/rss/1.0/modules/content/"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:media="http://search.yahoo.com/mrss/"
    xmlns:atom="http://www.w3.org/2005/Atom"
    xmlns:georss="http://www.georss.org/georss">
<channel>

<title>IMAGOZ.ru | Игры и технологии</title>

<link>https://imagoz.ru/</link>

<language>ru</language>'?>

<?php if (empty($newssets))
	{
		echo '';
	}

      else

      foreach ($newssets as $newsset): ?>

<?php 
      $articleNews = markdown2html_pub($newsset['text']);
?>        
	
<?php $content .= '<item>

<title>'. $newsset['title'].'</title>

<link>https://imagoz.ru/viewnewsset/?id='.$newsset['id'].'</link>

<pdalink>https://imagoz.ru/viewnewsset/?id='.$newsset['id'].'</pdalink>

<guid>https://imagoz.ru/viewnewsset/?id='.$newsset['id'].'</guid>

<pubDate>'.date("D, j M Y G:i:s", strtotime($newsset['date'])).' +0300</pubDate>

<media:rating scheme="urn:simple">nonadult</media:rating>

<category>native-draft</category>

<enclosure url="https://imagoz.ru/images/'.$newsset['imghead'].'" type= "image/jpeg"/>

<content:encoded>

        <![CDATA[

        '.$articleNews.'
        <br><br> 
         Автор: 
         <br><br>
         <strong>Оригинал статьи на сайте imagoz.ru <a href="https://imagoz.ru/viewnewsset/?id='.$newsset['id'].'">по ссылке</a></strong>
         <br><br>
         <strong>Ставьте лайки, комментируйте, подписывайтесь на <a href="https://dzen.ru/imagoz">КАНАЛ</a>!</strong>

        ]]>

</content:encoded>

</item>';?>

<?php endforeach; ?>

<?php if (empty($posts))
	{
		echo '';
	}

      else

      foreach ($posts as $post): ?>

<?php $video = $post['videoyoutube'] != '' ? '<br><br><figure><iframe width="560" height="315" src="'.$post['videoyoutube'].'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></figure>' : ''; 
      $articlePost = markdown2html_pub($post['text']);
?> 

<?php $content .= '<item>

<title>'. $post['posttitle'].'</title>

<link>https://imagoz.ru/viewpost/?id='.$post['id'].'</link>

<pdalink>https://imagoz.ru/viewpost/?id='.$post['id'].'</pdalink>

<guid>https://imagoz.ru/viewpost/?id='.$post['id'].'</guid>

<pubDate>'.date("D, j M Y G:i:s", strtotime($post['postdate'])).' +0300</pubDate>

<media:rating scheme="urn:simple">nonadult</media:rating>

<category>native-draft</category>

<enclosure url="https://imagoz.ru/images/'.$post['imghead'].'" type= "image/jpeg"/>

<content:encoded>

        <![CDATA[

        '.delDetails(isertTagFigure($articlePost)).$video.'
         <br><br> 
         Автор: <strong>'.$post['authorname'].'</strong>
         <br><br>
         <strong>Оригинал статьи на сайте imagoz.ru <a href="https://imagoz.ru/viewpost/?id='.$post['id'].'">по ссылке</a></strong>
         <br><br>
         <strong>Ставьте лайки, комментируйте, подписывайтесь на <a href="https://dzen.ru/imagoz">КАНАЛ</a>!</strong>

        ]]>

</content:encoded>

</item>';?>

<?php endforeach; ?>

<?php $content .='</channel>

</rss>';

/*Генерация rss-ленты*/
$rssDzen = MAIN_FILE.'/rssdzen.xml';

file_put_contents($rssDzen, $content);

echo 'rssdzen Файл создан!'

?>