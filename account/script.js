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

//Вывод сообщения о подтверждении голосования.

const confirmLike = document.querySelector('#confirmlike')

if (confirmLike)
{
 	confirmLike.addEventListener('click', (event) => {confLk = confirm('Вы уверены, что хотите проголосовать за данный материал')
								 if (confLk === false)
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

$(document).ready(function() {

	//Вкладки профиля
	const tab = $('#tabs .tabs-items > div'); 
	tab.hide().filter(':first').show(); 
	console.log('OK!!')
	
	// Клики по вкладкам.
	$('#tabs .tabs-nav a').click(function(){
		tab.hide(); 
		tab.filter(this.hash).show(); 
		$('#tabs .tabs-nav a').removeClass('active');
		$(this).addClass('active');
		console.log('OK!')
		return false;
	}).filter(':first').click();
 
	// Клики по якорным ссылкам.
	// $('.tabs-target').click(function(){
	// 	$('#tabs .tabs-nav a[href=' + $(this).attr('href')+ ']').click();
	// });
	
	// Отрытие вкладки из хеша URL
	if(window.location.hash){
		$('#tabs-nav a[href=' + window.location.hash + ']').click();
		window.scrollTo(0, $("#" . window.location.hash).offset().top);
	}

	//Прелоадер
	$(window).on('load', function () {
		$('.preloader').delay(100).fadeOut('fast');
	  });

	//Добавление записи на стену
	$("#push_comment").on('click',
			function(e){
				if ($('.trumbowyg-editor').text() === ''){
					$('.trumbowyg-editor').html('');
					$('.trumbowyg-editor').attr("placeholder", "Поле комментария не может быть пустым");
					e.preventDefault();
				} else {
					addComment('result_form', 'addcomment', '../includes/addcomment.inc.php');
					return false; 
				}		
			}
		);
})
