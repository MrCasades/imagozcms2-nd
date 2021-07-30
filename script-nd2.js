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
        btns: [
            ['strong', 'em', 'h2', 'h3'],
            ['link'],
            ['insertImage'],
            ['unorderedList', 'orderedList'],
            ['horizontalRule'],
            ['removeformat'],
            ['fullscreen']
        ],
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
            600:{
                items:1
            },

            400:{
                items:1
            }
        }
    });

    //Открыть рейтинг

    ratingOpCl(".ratings-op-n", ".posts-op-n", ".last-news", ".rating-n");
    ratingOpCl(".ratings-op-pr", ".posts-op-pr", ".last-pr", ".rating-pr");
    ratingOpCl(".ratings-op-art", ".posts-op-art", ".last-art", ".rating-art")


    function ratingOpCl (titleR, titleP, postsClass, ratingClass){
        //открытие рейтинга
        $(titleR).mouseenter(function(){
            console.log('Ok');   
            $(postsClass).fadeOut(1000);
            $(ratingClass).css({"display": "flex"});
        }); 
        //открытие последних постов
        $(titleP).mouseenter(function(){
            console.log('Ok');
            $(ratingClass).hide();
            $(postsClass).fadeIn(1000);
        });
    }
  });