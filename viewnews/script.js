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
        	//result = $.parseJSON(response);
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


/*
//AJAX
function XmlHttp()
{
	//const xmlhttp
	
	//Объект для старых браузеров
	try 
	{
		const xmlhttp = new ActiveXObject("Msxml2.XMLHTTP")
	}
	catch(e)
	{
		try 
		{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP")
		} 
		catch (E) 
		{
			xmlhttp = false
		}
	}
	
	//Объект для новых браузеров
	if (!xmlhttp && typeof XMLHttpRequest!='undefined')
	{
		xmlhttp = new XMLHttpRequest()
	}
	
	return xmlhttp
}
 
function ajax(param)
{
                if (window.XMLHttpRequest) req = new XmlHttp();
                method=(!param.method ? "POST" : param.method.toUpperCase());
 
                if(method=="GET")
                {
                               send=null;
                               param.url=param.url+"&ajax=true";
                }
                else
                {
                               send="";
                               for (var i in param.data) send+= i+"="+param.data[i]+"&";
                               // send=send+"ajax=true"; // если хотите передать сообщение об успехе
                }
 
                req.open(method, param.url, true);
                if(param.statbox)document.getElementById(param.statbox).innerHTML = '<img src="wait.gif">';
                req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                req.send(send);
                req.onreadystatechange = function()
                {
                               if (req.readyState == 4 && req.status == 200) //если ответ положительный
                               {
                                               if(param.success)param.success(req.responseText);
                               }
                }
}
*/
//Оценка статьи
/*
const vote_5 = document.querySelector('#v5')

if (vote_5)
{
	vote_5.addEventListener('click', () => ajax({
                                                               url:" ",
                                                               statbox:"status",
                                                               method:"POST",
                                                               data: vote_5.value,
                                                               success:function(data){document.getElementById("status").innerHTML=data;}

                                               }))
}*/