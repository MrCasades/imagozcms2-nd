<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/">

<channel>

<language>ru</language>

<?php foreach ($newsMain as $newsMain_3): ?>

<?php 
	//$img = '<br><figure><img src="//'.MAIN_URL.'/images/'.$newsMain_3['imghead'].'"/></figure><br>';
	$header = '<h3>'.$newsMain_3['newstitle'].'</h3>';
	$video = $newsMain_3['videoyoutube'] != '' ? '<br><br><figure><iframe width="560" height="315" src="'.$newsMain_3['videoyoutube'].'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></figure>' : '';
    $articleNews = markdown2html_pub($newsMain_3['textnews']);
	$link = '<br><a href="https://'.MAIN_URL.'/viewnews/?id='.$newsMain_3['id'].'">Ссылка на публикацию</a>';
?>  

<item>

<image>
     https://<?php echo MAIN_URL; ?>/images/<?php echo $newsMain_3['imghead']; ?>
</image>

<pubDate><?php echo date("D, j M Y G:i:s", strtotime($newsMain_3['newsdate'])); ?> +0300</pubDate>

<author><?php echo $newsMain_3['authorname']; ?></author>

<category><?php echo $newsMain_3['categoryname']; ?></category>

<description>

<![CDATA[

	<?php echo $header.delDetails(isertTagFigure($articleNews)).$video.$link; ?>

]]>

</description>

</item>

<?php endforeach; ?>

</channel>

</rss>