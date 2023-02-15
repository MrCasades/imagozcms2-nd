<!DOCTYPE html> 

<html lang="en">
<head>
	<!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-167532503-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'UA-167532503-1');
    </script>

	<?php 
			//канонический адрес
			echo $canonicalURL = $canonicalURL ?? '';?>

    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta name="robots" content="<?php echo $robots; ?>"/>
	<meta name="Description" content= "<?php echo $descr; ?>"/>
	<meta name="yandex-verification" content="b1b036a76e433a2f" />
	<meta name="msvalidate.01" content="B52E69B4EFB1372BDECC826BB005BFC2" />
	<meta name="11e66bf0747b49e92165b564157d94b9" content="">
	<meta name="pmail-verification" content="ddfba33030d7dda60e94c41aadfd4340">



	
    <link href="<?php echo '//'.MAIN_URL.'/styles/menu-nd2.css';?>" rel= "stylesheet" type="text/css">
    <link href="<?php echo '//'.MAIN_URL.'/styles/styles-nd.css';?>" rel= "stylesheet" type="text/css">
    <link href="<?php echo '//'.MAIN_URL.'/styles/adpt-styles-nd.css';?>" rel= "stylesheet" type="text/css">

	<?php 
		//Дополнительный код
		echo $customStyle = $customStyle ?? ''; ?>
    
    <link rel="stylesheet" href="<?php echo '//'.MAIN_URL.'/OwlCarousel/dist/assets/owl.carousel.min.css';?>">
    <link rel="stylesheet" href="<?php echo '//'.MAIN_URL.'/OwlCarousel/dist/assets/owl.theme.default.min.css';?>">
    <link rel="stylesheet"  href="<?php echo '//'.MAIN_URL.'/font-awesome-4.7.0/css/font-awesome.css ';?>" type="text/css">
	<link rel="stylesheet"  href="<?php echo '//'.MAIN_URL.'/Trumbowyg-main/dist/ui/trumbowyg.min.css ';?>" type="text/css">
	<link rel="stylesheet"  href="<?php echo '//'.MAIN_URL.'/Trumbowyg-main/dist/plugins/emoji/ui/trumbowyg.emoji.min.css ';?>" type="text/css">
	
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo '//'.MAIN_URL.'/favicons/apple-icon-57x57.png';?>">
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo '//'.MAIN_URL.'/favicons/apple-icon-60x60.png';?>">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo '//'.MAIN_URL.'/favicons/apple-icon-72x72.png';?>">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo '//'.MAIN_URL.'/favicons/apple-icon-76x76.png';?>">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo '//'.MAIN_URL.'/favicons/apple-icon-114x114.png';?>">
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo '//'.MAIN_URL.'/favicons/apple-icon-120x120.png';?>">
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo '//'.MAIN_URL.'/favicons/apple-icon-144x144.png';?>">
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo '//'.MAIN_URL.'/favicons/apple-icon-152x152.png';?>">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo '//'.MAIN_URL.'/favicons/apple-icon-180x180.png';?>">
	<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo '//'.MAIN_URL.'/favicons/android-icon-192x192.png';?>">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo '//'.MAIN_URL.'/favicons/favicon-32x32.png';?>">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo '//'.MAIN_URL.'/favicons/favicon-96x96.png';?>">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo '//'.MAIN_URL.'/favicons/favicon-16x16.png';?>">
	<link rel="manifest" href="<?php echo '//'.MAIN_URL.'/favicons/manifest.json';?>">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="<?php echo '//'.MAIN_URL.'/favicons/ms-icon-144x144.png';?>">
	<meta name="theme-color" content="#ffffff">

    <title><?php echo $title; ?> </title>

	<?php 
		//для reCapcha
        echo $reCapchaAPI = $reCapchaAPI ?? '';
        //Микроразметка
        echo $jQuery = $jQuery ?? '';
		//Микроразметка
        echo $dataMarkup = $dataMarkup ?? '';
		//Дополнительный код
        echo $otherCode = $otherCode ?? '';?>

</head>

<html>
<body>
    <header>
		<div class = "header-logo-pl">
			<a href = "<?php echo '//'.MAIN_URL;?>"><img class="full-logo" src="<?php echo '//'.MAIN_URL.'/decoration/logo.png';?>" alt="imagoz.ru | Hi-Tech, игры, интернет в отражении" title="Главная страница"/><img class="adpt-logo" src="<?php echo '//'.MAIN_URL.'/decoration/logo2.png';?>" alt="imagoz.ru | Hi-Tech, игры, интернет в отражении" title="Главная страница"/></a>
			<?php if (empty($itIsBlog)) :?>
			<?php 
				/*Загрузка главного меню*/
				include MAIN_FILE . '/mainmenu/mainmenu.inc.php'; ?>
			
			<a class="search-btn" href="<?php echo '//'.MAIN_URL;?>/searchpost/"><i class="fa fa-search" aria-hidden="true"></i> <span class="hide-for-adpt-1">Поиск</span></a>
			<div class="header-social-net-pl">
				<a href = "https://vk.com/imagoz" target="_blank"><img src="<?php echo '//'.MAIN_URL.'/decoration/vк1.png';?>" alt="Наша группа VK" title="Наша группа VK"/></a>
				<a href = "https://zen.yandex.ru/imagoz" target="_blank"><img src="<?php echo '//'.MAIN_URL.'/decoration/zen2.png';?>" alt="Наш Дзен-канал" title="Наш Дзен-канал"/></a>
				<a href = "https://pulse.mail.ru/imagoz-igry-i-tehnologii/" target="_blank"><img src="<?php echo '//'.MAIN_URL.'/decoration/mail3.png';?>" alt="Мы на Пульсе!" title="Мы на Пульсе!"/></a>
			</div>
			<div class="login-logout-btn-pl">
				<?php if (!isset($_SESSION['loggIn'])):?>
					<a href="<?php echo '//'.MAIN_URL;?>/admin/registration/?log#bottom"><i class="fa fa-user" aria-hidden="true"></i> <span class="hide-for-adpt-2">Вход</span></a> 
				<?php else:?>
					<?php 
						/*Загрузка меню авторизации*/
						include_once MAIN_FILE . '/admin/logpanel/logpanel.inc.php';?>
				<?php endif;?>
			</div>
		</div>
		<!-- <div class="authorization-form">
                <div class=close-btn>x</div>
                <form action = " " method = "post">   
                    <div class="send">
                        <input type="text" placeholder="e-mail" name = "email" id = "email">
                        <input type="password" placeholder="password" name = "password" id = "password">
						<input type = "hidden" name = "action" value = "login">
						<input type = "hidden" name = "action_form" value = "login_form">
                        <button class="btn_1">Вход</button>
                    </div>
                    <div class="reg-group">
						<a href="//admin/registration/?reg#bottom">Регистрация</a> 
                        <a href="//admin/recoverpassword/?send">Забыли пароль?</a>
                    </div>  
                </form>
        </div>  -->          
		<div class="header-line"></div>
		<?php endif;?>
		<script src="<?php echo '//'.MAIN_URL.'/jquery-3.5.1.min.js';?>"></script>   
	</header>
    <!-- <div class="subheader"></div> -->

	<main>

	<!-- <div class="m-content">
				Место для рекламы
		</div> -->
  
	<div class="m-content">
		<div class="gallery hidden"></div> <!--Тестовый код-->
		<div class="wrap hidden">
			<button class="close-pic btn_3">X</button><div class="one-pic"></div> <!--Тестовый код-->
		</div>
		<br/>	
	</div>	

	<div class="bread-crumbs">
		<?php echo $breadPart1 = $breadPart1 ?? ''; ?><?php echo $breadPart2 = $breadPart2 ?? ''; ?><?php echo $breadPart3 = $breadPart3 ?? ''; ?>
	</div>
	
	