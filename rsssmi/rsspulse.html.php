<? 
	/*Загрузка функций в шаблон*/
	include_once MAIN_FILE . '/includes/func.inc.php';

$content = '<?xml version="1.0" encoding="UTF-8"?>

<rss xmlns:atom="http://www.w3.org/2005/Atom" version="2.0">

<channel>

<title>Hi-Tech новости, игры, наука, интернет в отражении на imagoz.ru</title>

<atom:link href="https://'.MAIN_URL.'/rsssmi/" rel="self" type="application/rss+xml"/>

<lastBuildDate>Thu, 15 Mar 2018 10:00:15 +0000</lastBuildDate>

<language>ru</language>

<generator>RSS Generator</generator>

<description>

	Портал IMAGOZ. Место где мы рассматриваем мир Hi-Tech, игровую индустрию, науку и технику в оригинальном авторском отражении!

</description>

<link>https://'.MAIN_URL.'/rsssmi/</link>

'?>
	
	


	<?php foreach ($newsMain as $newsMain_3): ?>
	
<?php $content .= '<item>

<title>'. $newsMain_3['newstitle'].'</title>

<description>

<![CDATA[<img src="https://imagoz.ru/images/'.$newsMain_3['imghead'].'"> '.
	
	markdown2html(implode(' ', array_slice(explode(' ', strip_tags($newsMain_3['textnews'])), 0, 50))).' [...]

]]>

</description>

<link>https://'.MAIN_URL.'/viewnews/?id='.$newsMain_3['id'].'</link>

<pubDate>'.date("D, j M Y G:i:s", strtotime($newsMain_3['newsdate'])).' +0300</pubDate>

<category>технологии</category>

</item>';?>

<?php endforeach; ?>

<?php foreach ($posts as $post): ?>

<?php $content .= '<item>

<title>'. $post['posttitle'].'</title>

<description>

<![CDATA[<img src="https://'.MAIN_URL.'/images/'.$post['imghead'].'"> '.
	
	markdown2html(implode(' ', array_slice(explode(' ', strip_tags($post['text'])), 0, 50))).' [...]

]]>

</description>

<link>https://'.MAIN_URL.'/viewpost/?id='.$post['id'].'</link>

<pubDate>'.date("D, j M Y G:i:s", strtotime($post['postdate'])).' +0300</pubDate>

<category>технологии</category>

</item>';?>

<?php endforeach; ?>

<?php $content .='</channel>

</rss>';

/*Генерация rss-ленты*/
$rssPulse = './rsspulse.xml';

file_put_contents($rssPulse, $content);

echo 'Файл создан!'

?>