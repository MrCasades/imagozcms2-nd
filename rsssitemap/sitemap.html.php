<? 
	/*Загрузка функций в шаблон*/
	include_once MAIN_FILE . '/includes/func.inc.php';

$content = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
   <url>
      <loc>https://'.MAIN_URL.'/</loc>
	  <lastmod>2020-01-01</lastmod>
	  <priority>1.0</priority>
   </url>
   <url>
      <loc>https://'.MAIN_URL.'/cooperation/</loc>
	  <lastmod>2020-01-01</lastmod>
	  <priority>0.65</priority>
   </url>
   <url>
      <loc>https://'.MAIN_URL.'/promotion/</loc>
	  <lastmod>2020-01-01</lastmod>
	  <priority>0.65</priority>
   </url>
'?>
	
<?php foreach ($newsMain as $news): ?>
	
<?php $content .= '<url>
      <loc>https://'.MAIN_URL.'/viewnews/?id='.$news['id'].'</loc>
	  <lastmod>'.date("Y-m-d", strtotime($news['newsdate'])).'</lastmod>
	  <priority>0.8</priority>
   </url>';?>

<?php endforeach; ?>

<?php foreach ($posts as $post): ?>

<?php $content .= '<url>
      <loc>https://'.MAIN_URL.'/viewpost/?id='.$post['id'].'</loc>
	  <lastmod>'.date("Y-m-d", strtotime($post['postdate'])).'</lastmod>
	  <priority>0.8</priority>
   </url>';?>

<?php endforeach; ?>

<?php foreach ($videos as $video): ?>

<?php $content .= '<url>
      <loc>https://'.MAIN_URL.'/video/?id='.$video['id'].'</loc>
	  <lastmod>'.date("Y-m-d", strtotime($video['videodate'])).'</lastmod>
	  <priority>0.8</priority>
   </url>';?>

<?php endforeach; ?>

<?php foreach ($blogs as $blog): ?>

<?php $content .= '<url>
      <loc>https://'.MAIN_URL.'/blog/?id='.$blog['id'].'</loc>
	  <lastmod>'.date("Y-m-d", strtotime($blog['date'])).'</lastmod>
	  <priority>0.8</priority>
   </url>';?>

<?php endforeach; ?>

<?php foreach ($pubs as $pub): ?>

<?php $content .= '<url>
      <loc>https://'.MAIN_URL.'/blog/publication/?id='.$pub['id'].'</loc>
	  <lastmod>'.date("Y-m-d", strtotime($pub['date'])).'</lastmod>
	  <priority>0.8</priority>
   </url>';?>

<?php endforeach; ?>

<?php foreach ($promotions as $promotion): ?>

<?php $content .= '<url>
      <loc>https://'.MAIN_URL.'/viewpromotion/?id='.$promotion['id'].'</loc>
	  <lastmod>'.date("Y-m-d", strtotime($promotion['promotiondate'])).'</lastmod>
	  <priority>0.75</priority>
   </url>';?>

<?php endforeach; ?>

<?php foreach ($authors as $author): ?>

<?php $content .= '<url>
      <loc>https://'.MAIN_URL.'/account/?id='.$author['id'].'</loc>
	  <lastmod>'.date("Y-m-d", strtotime($author['regdate'])).'</lastmod>
	  <priority>0.7</priority>
   </url>';?>

<?php endforeach; ?>

<?php $content .='</urlset>';

/*Генерация rss-ленты*/
$sitemap = MAIN_FILE.'/sitemap.xml';

file_put_contents($sitemap, $content);

echo 'Файл sitemap создан!'

?>