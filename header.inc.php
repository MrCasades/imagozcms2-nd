<!DOCTYPE html> 

<html lang="en">
<head>
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

	
    
    <link href="<?php echo '//'.MAIN_URL.'/menu.css';?>" rel= "stylesheet" type="text/css">
    <link href="<?php echo '//'.MAIN_URL.'/styles.css';?>" rel= "stylesheet" type="text/css">
    <link href="<?php echo '//'.MAIN_URL.'/adpt-styles.css';?>" rel= "stylesheet" type="text/css">
    
    <link rel="stylesheet" href="<?php echo '//'.MAIN_URL.'/OwlCarousel/dist/assets/owl.carousel.min.css';?>">
    <link rel="stylesheet" href="<?php echo '//'.MAIN_URL.'/OwlCarousel/dist/assets/owl.theme.default.min.css';?>">
    <link rel="stylesheet"  href="<?php echo '//'.MAIN_URL.'/font-awesome-4.7.0/css/font-awesome.css ';?>" type="text/css">
	
	<link href="<?php echo '//'.MAIN_URL.'/favicon.ico';?>" rel="icon" type="image/x-icon">

	<link href="<?php echo '//'.MAIN_URL.'/styles-old.css';?>" rel= "stylesheet" type="text/css">
	
    
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
        <a href = "<?php echo '//'.MAIN_URL;?>"><img src="<?php echo '//'.MAIN_URL.'/logomain.png';?>" alt="imagoz.ru | Hi-Tech, игры, интернет в отражении"/></a>
		<?php 
			/*Загрузка главного меню*/
			include_once MAIN_FILE . '/mainmenu/mainmenu.inc.php'; ?>
		
		<div class="authorization-form">
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
						<a href="//<?php echo MAIN_URL;?>/admin/registration/?reg#bottom">Регистрация</a> 
                        <a href="//<?php echo MAIN_URL;?>/admin/recoverpassword/?send">Забыли пароль?</a>
                    </div>  
                </form>
        </div> 
                   
    </header>
    <!-- <div class="subheader"></div> -->

	<main>
	
	<div>	   
		<?php 
		/*Загрузка меню авторизации*/
		include_once MAIN_FILE . '/admin/logpanel.html.inc.php';?>
		
		<?php 
		/*Загрузка кнопки добавления статьи*/
		include_once MAIN_FILE . '/admin/addpost.html.inc.php';
		    
		    echo '<div align = "center"><p>'.$logPanel.'</p></div>';
			echo '<div align = "center"><p>'.$superUser.'</p></div>';
			echo'<p  align = "center">'.$addPost.'</p>';
			echo'<p  align = "center"> <strong>'.$scoreTitle.'</strong>'.$payForms.'</p>';
			echo'<p  align = "center">'.$forAuthors.'</p>';?>	
	</div>

	<div>
		<!-- Yandex.RTB R-A-448222-6 -->
		<div id="yandex_rtb_R-A-448222-6"></div>
		<script type="text/javascript">
			(function(w, d, n, s, t) {
				w[n] = w[n] || [];
				w[n].push(function() {
					Ya.Context.AdvManager.render({
						blockId: "R-A-448222-6",
						renderTo: "yandex_rtb_R-A-448222-6",
						async: true
					});
				});
				t = d.getElementsByTagName("script")[0];
				s = d.createElement("script");
				s.type = "text/javascript";
				s.src = "//an.yandex.ru/system/context.js";
				s.async = true;
				t.parentNode.insertBefore(s, t);
			})(this, this.document, "yandexContextAsyncCallbacks");
		</script>
	</div> 
			
	<!-- <h1><?php htmlecho ($headMain); ?> </h1> -->
  
	
	