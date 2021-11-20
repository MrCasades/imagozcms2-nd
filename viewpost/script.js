//Вывод сообщения об успешной рекомендации статьи!

const recommOk = document.querySelector('#recommok')

if (recommOk)
{
	recommOk.addEventListener('click', () => alert('Вы успешно рекомендовали статью! Она сейчас лидирует в списке рекомендаций!'))
}

//Вывод сообщения о подтверждении премодерации!

const confirmOk = document.querySelector('#confirmok')

if (confirmOk)
{
 	confirmOk.addEventListener('click', (event) => {confOk = confirm('Вы уверены, что хотите отправить статью на премодерацию? Вы больше не сможете внести в неё правки. Произойдёт перенаправление на главную страницу!')
								if (confOk === false)
								{
									 event.preventDefault();
								}	
							}, false)
											
}

//Вывод сообщения о подтверждении удаления объекта.

const confirmDel = document.querySelector('#delobject')

if (confirmDel)
{
 	confirmDel.addEventListener('click', (event) => {confDel = confirm('Вы уверены, что хотите удалить данный оъект? Данное действие может привести к НЕОБРАТИМЫМ последствиям!')
								 if (confDel === false)
								 {
									 event.preventDefault();
								 }
							}, false)
}

//Вывод сообщения о подтверждении обнуления конкурсных баллов.

const removeContest = document.querySelector('#removecontest')

if (removeContest)
{
 	removeContest.addEventListener('click', (event) => {confDel = confirm('Вы уверены, что хотите обнулить конкурсные баллы?')
								 if (confDel === false)
								 {
									 event.preventDefault();
								 }
							}, false)
}

/* AJAX JQuery */

//Добавление-удаление из избранного
$( document ).ready(function() {
    $("#btn_fav").click(
		function(){
			$("#btn_fav").attr('class', ' ');
			sendAjaxForm('result_form_fav', 'ajax_form_fav', 'favourites.inc.php');
			
			if ($("#val_fav").attr('value') === 'delfav'){
				$("#val_fav").attr('value', 'addfav');
				$("#btn_fav").attr('class', 'btn_fav_1');
				console.log('OK11');
				
			} else {
				$("#val_fav").attr('value', 'delfav');
				$("#btn_fav").attr('class', 'btn_fav_2');
			}
			
			return false; 
		}
	);
});

 
//Оценка статьи

$( document ).ready(function() {
		$("#btn_vot_5").click(
			function(event){
				confLk = confirm('Вы уверены, что хотите проголосовать за данный материал?')
				if (confLk === false){
					event.preventDefault();
				}
				
				else{
					voteClick('btn_vot_5');
					event.preventDefault();
				}
			}
		);
	
	$("#btn_vot_4").click(
			function(event){
				confLk = confirm('Вы уверены, что хотите проголосовать за данный материал?')
				if (confLk === false){
					event.preventDefault();
				}
				
				else{
					voteClick('btn_vot_4');
					event.preventDefault();
				}
			}
		);
	
	$("#btn_vot_3").click(
			function(event){
				confLk = confirm('Вы уверены, что хотите проголосовать за данный материал?')
				if (confLk === false){
					event.preventDefault();
				}
				
				else{
					voteClick('btn_vot_3');
					event.preventDefault();
				}
			}
		);
	
	$("#btn_vot_2").click(
			function(event){
				confLk = confirm('Вы уверены, что хотите проголосовать за данный материал?')
				if (confLk === false){
					event.preventDefault();
				}
				
				else{
					voteClick('btn_vot_2');
					event.preventDefault();
				}
			}
		);
	
	$("#btn_vot_1").click(
			function(event){
				confLk = confirm('Вы уверены, что хотите проголосовать за данный материал?')
				if (confLk === false){
					event.preventDefault();
				}
				
				else{
					voteClick('btn_vot_1');
					event.preventDefault();
				}
			}
		);
});

//Рекомендация статьи
$( document ).ready(function() {

	//Тест галлереи
	const images = $("img");
	images.clone().appendTo($(".gallery"));

	console.log(images);

	//Вывод 1-го изображения
	$("img").click(
		function(e){
			$(".one-pic").empty();
			$(this).clone().appendTo($(".one-pic"));
			$(".wrap").removeClass('hidden');
		}
	);
	//**********************************/

    $("#btn_recomm").click(
		function(event){
			confRecomm = confirm('Вы уверены, что хотите рекомендовать данную статью? С Вашего счёта будут списаны средства в размере '+ $("#recommprice").attr('value') + ' баллов!')
			if (confRecomm === false){
				event.preventDefault();
			}
			
			else{
				//Если средств на счету недостаточно
				if (parseInt($("#score").html()) < parseInt($("#recommprice").attr('value'))){
					alert('На счёте недостаточно средств!');
					
					$("#ajax_form_recomm").html('');
				}
				
				else {
					//$("#btn_fav").attr('src', ' ');
					sendAjaxForm('result_form_recomm', 'ajax_form_recomm', 'reccomendation.inc.php');
					console.log('OK1');
					
					$("#score").html(parseInt($("#score").html()) - parseInt($("#recommprice").attr('value')))//изменение счёта

					$("#ajax_form_recomm").html('');
					alert('Вы успешно рекомендовали статью! Она в данный момент на 1-м месте!');
				}

				return false; 
			}
		}
	);

	$("#push_comment").on('click',
		function(e){
			if ($('.trumbowyg-editor').text() === ''){
				$('.trumbowyg-editor').html('');
				$('.trumbowyg-editor').attr("placeholder", "Поле комментария не может быть пустым");
				e.preventDefault();
			} else {
				addComment('result_form', 'addcomment', '../addcomment/addcomment.inc.php');
				return false; 
			}		
		}
	);
});

//Функция AJAX
function sendAjaxForm(result_form, ajax_form, url) {
    $.ajax({
        url:     url, //url страницы (action_ajax_form.php)
        type:     "POST", //метод отправки
        //dataType: "html", //формат данных
        data: $("#"+ajax_form).serialize(),  // Сеарилизуем объект
        success: function(response) { //Данные отправлены успешно
        	//result = parseJSON(response);
			
			//if (result['err']) {
			//	alert(result['err']);	
			//}
				
			//$('#'+ajax_form).html('Ожидание...');
			//$('#'+ajax_form).html('');
        	//$('#'+result_form).html(' ');
			console.log('OK');
    	},
    	error: function(response) { // Данные не отправлены
            $('#result_form').html('Ошибка. Данные не отправлены.');
			console.log('no');
    	}
 	});
}

//Обработка действия кнопки для голосования

function voteClick(btn){
				$("#confirmlike").hide();
				const url = 'vote.inc.php?vote=' + $("#"+btn).attr('value');
				//$("#btn_vot").attr('src', ' ');
				sendAjaxForm('result_form_vot', 'confirmlike', url);
				$("#result_form_vot").html('Ваш голос принят!');

				console.log('OK1');
				console.log(url);

				return false; 
}