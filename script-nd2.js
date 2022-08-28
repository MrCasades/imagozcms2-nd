// Главное меню

// const nav = document.getElementById('nav')

// nav.addEventListener('click', function(e) {
//     const target = e.target;

//     const targetParent = target.closest('.menu-item')

//     if (targetParent) {
//         const subm = targetParent.getElementsByClassName('submenu')[0]
//         close()

//         if (subm) {
//             subm.style.display = 'block';
//         }
//   }
// });

// function close() {
//     const s = document.getElementsByClassName('submenu')
    
//     for (var i = 0; i < s.length; i++) {
//         s[i].style.display = 'none';
//   }
// }

//Txt-place

$(document).ready(function() {
    "use strict";
    $('.menu > ul > li:has( > ul)').addClass('menu-dropdown-icon');
    $('.menu > ul > li > ul:not(:has(ul))').addClass('normal-sub');
    $(".menu > ul").before("<span class=\"menu-mobile\"></span>");
    $(".menu > ul > li").hover(function(e) {
        if ($(window).width() > 768) {
            $(this).children("ul").stop(true, false).fadeToggle(150);
            e.preventDefault();
        }
    });
    $(".menu > ul > li").click(function() {
        if ($(window).width() <= 768) {
            $(this).children("ul").fadeToggle(150);
        }
    });
    $(".menu-mobile").click(function(e) {
        $(".menu > ul").toggleClass('show-on-mobile');
        $(".login-logout-btn-pl").toggleClass('hidden');
        $(".search-btn + a").toggleClass('hidden');
        $(".header-line").toggleClass('hidden');
        e.preventDefault();
    });

     //Цвет непрочитанных сообщений
			
	// countsViewAndColor("#countcolor", "red");
		
	// function countsViewAndColor(idcount, color) 
	// {
	// 	const countMess = document.querySelector(idcount); 
	// 	const countVal = countMess.innerHTML;
				
	// 	if (parseInt(countVal) > 0)
	// 	{
	// 		countMess.style.color = (color);
	// 			   countMess.innerHTML = "["+countVal+"]";
	// 	} 

	// 	else if (parseInt(countVal) === 0) 
	// 	{
	// 		countMess.innerHTML = "";
	// 	}
	// }

    //Форма авторизации

    $("#auth").click(function(e){
        $(".authorization-form").fadeIn(1000);
        e.preventDefault();
    })

    $(".close-btn").click(function(e){
        $(".authorization-form").fadeOut(1000);
    })
    
    $('.mark-textarea').trumbowyg({
        btnsDef: {
            image: {
                dropdown: ['upload'],
                ico: 'insertImage'
            }
        },

        btns: [
            ['emoji'],
            ['formatting'],
            ['strong', 'em', 'h2', 'h3'],
            ['link'],
            ['image'],
            ['unorderedList', 'orderedList'],
            ['horizontalRule'],
            ['removeformat'],
            ['fullscreen']
        ],
        plugins: {
            // Add imagur parameters to upload plugin for demo purposes
            upload: {
                    serverPath: '//' + window.location.hostname + '/upload.inc.php',
                    statusPropertyName: 'message',
                    urlPropertyName: 'file'
                }
            },
        autogrow: true,
        lang: 'ru',
        removeformatPasted: true,
        resetCss: true,
        minimalLinks: true,
        defaultLinkTarget: '_blank'
    });
    //owl-carousel
 
    $(".owl-carousel").owlCarousel({
        center: true,
        items:3,
        loop:true,
        margin:20,
        responsive:{
            1024:{
                items:3
            },
            600:{
                items:1
            },

            400:{
                items:1
            }
        }
    });

    $('.fls-textarea').click(function(){
        console.log('klick ');
        $('.fls-textarea').hide();
        $('.comment-form').show();
    })

    // $(document).mouseup(function (e){ // событие клика по веб-документу
	// 	const div = $(".comment-form"); // тут указываем ID элемента
	// 	if (!div.is(e.target) // если клик был не по нашему блоку
	// 	    && div.has(e.target).length === 0) { // и не по его дочерним элементам
	// 		div.hide(); // скрываем его
    //         $('.fls-textarea').show();
	// 	}
	// });

    //Открыть рейтинг

    // ratingOpCl(".ratings-op-n", ".posts-op-n", ".last-news", ".rating-n");
    // ratingOpCl(".ratings-op-pr", ".posts-op-pr", ".last-pr", ".rating-pr");
    // ratingOpCl(".ratings-op-art", ".posts-op-art", ".last-art", ".rating-art")


    // function ratingOpCl (titleR, titleP, postsClass, ratingClass){
    //     //открытие рейтинга
    //     $(titleR).mouseenter(function(){
    //         console.log('Ok');   
    //         $(postsClass).fadeOut(1000);
    //         $(ratingClass).css({"display": "flex"});
    //     }); 
    //     //открытие последних постов
    //     $(titleP).mouseenter(function(){
    //         console.log('Ok');
    //         $(ratingClass).hide();
    //         $(postsClass).fadeIn(1000);
    //     });
    // }

    //Запуск превью видео при наведении курсора.
    $(".prev-video").on("mouseover" , function(){
        this.play();
      });
      $(".prev-video").on("mouseleave",  function(){
        setTimeout(() => this.load(), 1000);
      })	
  });

  //Вывод 1-го изображения
	$(".pic-for-gallery").click(
		function(e){
			$(".one-pic").empty();
			$(this).clone().appendTo($(".one-pic"));
			$(".wrap").removeClass('hidden');
		}
	);

	//Закрытие изображения
	$(".close-pic").click(function (e){
		closePic();
	})

    $(".wrap").click(function (e){
		closePic();
	})

	document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && !$(".wrap").hasClass("hidden")) closePic()})

    //Функция закрытия изображения    
	function closePic(){
		$(".one-pic").empty();
		$(".wrap").addClass('hidden');
	}

  //Функция добавления
  function addComment (res_form, ajax_form, url) {
    $.ajax({
        url:     url, //url страницы (action_ajax_form.php)
        type:     "POST", //метод отправки
        dataType: "html", //формат данных
        data: $("#"+ajax_form).serialize(),  // Сеарилизуем объект
        success: function(response) { //Данные отправлены успешно
        	result = $.parseJSON(response);

            let avatar = result.avatar !== 'ava-def.jpg' ? '<div><img src="../avatars/'+result.avatar+'" alt="ava"/></div>' : '<i class="fa fa-user-circle-o" aria-hidden="true"></i>'
        	$('#result_form').prepend('<div class="comment m-content"><div class="comment-person-pl">'+avatar+'<div class="comment-person-name"><a href="../account/?id='+result.idauthor+'">'+result.authorname+'</a><br><span class="comment-date">Только что</span></div></div><div class="comment-text"><p><form action = "?" method = "post"><div><input type = "hidden" name = "id" value = "'+result.id+'"><input type = "hidden" name = "idarticle" value = "'+result.idarticle+'"><input type = "submit" name = "action" class="btn_2" value = "Редактировать"><input type = "submit" name = "action" class="btn_1" value = "Del"></div></form></p>'+result.text+'</div></div><div class = "comment-line"></div>');
            
			let countComm = document.getElementById('comm_count');//счётчик комментариев
			countComm.innerHTML = Number(countComm.innerHTML) + 1;

			let notComment = document.getElementById('not_comment');

			if (notComment)//Убираем надпись "Комментарии отсутствуют"
			{
				notComment.innerHTML = '';
			}

            $('#addcomment').hide();
            $('.fls-textarea').show();
            $('.trumbowyg-editor').html('');

            // let commentPlace = document.getElementById('comment');
            // commentPlace.innerHTML = '';
			
			//$('#checked-tags-add').append('<span class="tags-plase-prew">'+result.name+'</span>')
           // $('#addtags_form').val('');
    	},
    	error: function(response) { // Данные не отправлены
            $('#result_form').html('Ошибка. Данные не отправлены.');
            
    	}
 	});
}


function addSubComment (res_form, ajax_form, url) {
    $.ajax({
        url:     url, //url страницы (action_ajax_form.php)
        type:     "POST", //метод отправки
        dataType: "html", //формат данных
        data: $("#"+ajax_form).serialize(),  // Сеарилизуем объект
        success: function(response) { //Данные отправлены успешно
        	result = $.parseJSON(response);
        	$('#result_form_subcomm').prepend('<div class="sub-comment m-content"><span class="sub-comment-info">Ответил <a href="../account/?id='+result.idauthor+'">'+result.authorname+'</a> | '+result.date+'</span><p>'+result.text+'</p><p><form action = "../viewwallpost/index.php" method = "post"><div><input type = "hidden" name = "idcomment" value = "'+result.idcomment+'"><input type = "hidden" name = "id" value = "'+result.id+'"><input type = "submit" name = "action" class="btn_2" value = "Редактировать"><input type = "submit" name = "action" class="btn_1" value = "Del"></div></form></p></div>');
            
			let countComm = document.getElementById('comm_count');//счётчик комментариев
			countComm.innerHTML = Number(countComm.innerHTML) + 1;

			let notComment = document.getElementById('not_comment');

			if (notComment)//Убираем надпись "Комментарии отсутствуют"
			{
			    notComment.innerHTML = '';
			}

            $('.trumbowyg-editor').html('');

            // let commentPlace = document.getElementById('comment');
            // commentPlace.innerHTML = '';
			
			//$('#checked-tags-add').append('<span class="tags-plase-prew">'+result.name+'</span>')
           // $('#addtags_form').val('');
    	},
    	error: function(response) { // Данные не отправлены
            $('#result_form_subcomm').html('Ошибка. Данные не отправлены.');
            
    	}
 	});
}

//Фиксация панели редактирования текста
function fixTxtArea() {
    if ($('div').hasClass('trumbowyg-button-pane')){
        const $cache = $('.trumbowyg-button-pane');
        if ($(window).scrollTop() > $('.trumbowyg-box').position().top && !$('.trumbowyg-box').hasClass('trumbowyg-fullscreen') && $('.txt-area-block').hasClass('fixed-txt-area'))
        $cache.css({
            'position': 'fixed',
            'top': '0px',
            'width': '85%'
        });
        else
        $cache.css({
            'position': 'relative',
            'width': '100%'
        });
    }
    
  }
  $(window).scroll(fixTxtArea);
  fixTxtArea();