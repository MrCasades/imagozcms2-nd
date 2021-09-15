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

//Проверка заполнения обязательных полей

const title = document.getElementById('posttitle')
const category = document.getElementById('category')
const text = document.getElementById('text')

const confirm = document.getElementById('confirm')


confirm.addEventListener('click', (event) => {
    if ((title.value === "") || (category.options.selectedIndex === 0) || 
        (text.value === "")){
        alert ('Заполните все обязательные поля!')
        event.preventDefault()	
    }

    else if (title.value.length > 200) {
        alert ('Длина заголовка превышена!')
        event.preventDefault()	
    }
})

//Подсчёт количества знаков в заголовке
const countTitleLen = document.getElementById('counttitlelen')

countTitleLen.innerHTML = title.value.length

title.addEventListener('input', (event) => {

        countTitleLen.innerHTML = title.value.length

        //Изменение цвета при привышении лимита
        if (title.value.length > 200){
            countTitleLen.style.color = ('red')
        }

        else {
            countTitleLen.style.color = ('black')
        }
})

//Txt-place

$(document).ready(function() {
    $('.mark-textarea-adm').trumbowyg({
        btnsDef: {
            image: {
                dropdown: ['upload'],
                ico: 'insertImage'
            }
        },

        btns: [
            ['viewHTML'],
            ['strong', 'em', 'h2', 'h3'],
            ['link'],
            ['image'],
            ['unorderedList', 'orderedList'],
            ['horizontalRule'],
            ['emoji'],
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

    //Hide show tags

    $('#hide_show_tags').click(function(e) {
        if ($('#tags_list').css('display') == 'none') {
            $('#tags_list').show();
            $('#hide_show_tags').html('Скрыть теги');
            e.preventDefault();
        } else {
            $('#tags_list').hide();
            $('#hide_show_tags').html('Вывести теги');
            e.preventDefault();
        }
    })

    //hide show tags list
    let checked =[];

    $('#tags_list input:checkbox:checked').each(function() {
            checked.push('<span class="tags-plase-prew">' + $(this).attr('title') + '</span> ');
            console.log(checked);
        });

    $('#checked-tags').html(checked)

    $('#tags_list input:checkbox').click(function(e) {
        if ($(this).is(':checked')){
            checked.push('<span class="tags-plase-prew">' + $(this).attr('title') + '</span> ');
            console.log(checked);
        } else {
            // Array.prototype.remove = function(el) {
            //     return this.splice(this.indexOf(el), 1);
            // }
            console.log($(this).attr('title'));
            let index = checked.indexOf('<span class="tags-plase-prew">' + $(this).attr('title') + '</span> ');
            console.log(index);
            checked.splice(index, 1);
            console.log(checked);
        }

        $('#checked-tags').html(checked)
    })

    $("#tags_to_base").on('click',
		function(){
			sendAjaxForm('result_form', 'addtags_form', '../metalist/addtag.inc.php');
			return false; 
		}
	);
})

function sendAjaxForm(res_form, ajax_form, url) {
    $.ajax({
        url:     url, //url страницы (action_ajax_form.php)
        type:     "POST", //метод отправки
        dataType: "html", //формат данных
        data: $("#"+ajax_form).serialize(),  // Сеарилизуем объект
        success: function(response) { //Данные отправлены успешно
        	result = $.parseJSON(response);
        	$('#result_form').html('<label for = "meta'+result.id+'"><input type = "checkbox" name = "metas[]" id = "meta'+result.id+'" value = "'+result.id+'" checked title="'+result.name+'">'+result.name+'</label>');
    	},
    	error: function(response) { // Данные не отправлены
            $('#result_form').html('Ошибка. Данные не отправлены.');
    	}
 	});
}
