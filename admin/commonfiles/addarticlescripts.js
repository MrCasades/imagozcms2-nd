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

const title = document.getElementById('articletitle')
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
    //Txt-place
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
            ['emoji'],
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

    //Поиск тегов
    $( "#search_tags_pl" ).keyup(function(e) {
        //let category = $('#category[name="category"]').val();
        let text = $('#addtags_form[name="tags"]').val();
        text = text.replaceAll(' ', '&nbsp;');
        //let articleType = $('input[name="article_type"]:checked').val();

        let forTest = '';

        if (window.location.hostname == 'localhost')
            forTest = '/imagozcms2-nd';

         console.log("//" + window.location.hostname + forTest + "/metalist/searchtag.inc.php?metaname=" + text)
 
         if (text.length < 3 && text.length > 0){
            $( "#search-result-tags" ).html('<p class="for-info-txt">Нужно ввести от 3-х знаков для поиска!</p>')
            e.preventDefault()
         } else if (text.length == 0){
           $('#search-result-tags').empty();
           //$('#pubs-pl').delay(500).fadeIn('fast')  
           e.preventDefault()
         }else {
            $( "#search-result-tags" ).load( "../metalist/searchtag.inc.php?metaname=" + text)
           // $('#pubs-pl').delay(500).fadeOut('fast')
            $('#search-result-blog').delay(1000).fadeIn('slow')
            
            e.preventDefault()
         }

        //  $('input[name="article_type"]').click(function(){
        //     $(".wrap-searchres").addClass('hidden');
        //     $('#text-site[name="text"]').val('');
        //     $('#search-result-site').empty();       
        //  })
        //  $('input[name="article_type"]').click(function(){
        //     let category = $('#category[name="category"]').val();
        //     let text = $('#text-site[name="text"]').val();
        //     text = text.replaceAll(' ', '&nbsp;');
        //     let articleType = $('input[name="article_type"]:checked').val();

        //     let forTest = '';

        //     console.log('ClickHere!')
        //     $('#search-result-site').empty();
        //     //$('#text-site[name="text"]').val('');
        //     searchContent(text, category, articleType, forTest, e)
        //  })
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
        function(e){
            const allTags = Array.from(document.querySelectorAll('.all-tags'), v=> v.getAttribute('title'));        

            if ($('#addtags_form').val() === ''){
                $('#addtags_form').html('');
                $('#addtags_form').attr("placeholder", "Введите значение!");
                console.log('kl!')
                e.preventDefault();
            } else {
                let inList = false;

                for (let i = 0; i < allTags.length; i++) {                 
                    if ($('#addtags_form').val() == allTags[i]){
                        e.preventDefault();
                        alert ('Тэг '+ $('#addtags_form').val() + ' уже есть в списке!');
                        inList = true;                      
                        break;                    
                    } 
                }
                   
                if (!inList){
                    sendAjaxForm('result_form', 'addtags_form', '../metalist/addtag.inc.php');               
                    return false;
                }           
            }                                                   		
        }
	);

    // $("#search_form").keyup(function(){
    //     const allTags = Array.from(document.querySelectorAll('.all-tags'), v=> v.getAttribute('title'));
    //     let searchText = $('#search_form').val();
    //     for (let i = 0; i < allTags.length; i++) {                 
    //             if (!searchText.includes (allTags[i])){
    //                 allTags[i].style.display = "none"                            
    //             } 
    //         }
    //     }
    // )
    
    //hide show hints list
    $('#hide_show_hints').click(function(e) {
        if ($('#hint_list').css('display') == 'none') {
            $('#hint_list').show();            
            e.preventDefault();
        } else {
            $('#hint_list').hide();
            e.preventDefault();
        }
    })
})

function sendAjaxForm(res_form, ajax_form, url) {
    $.ajax({
        url:     url, //url страницы (action_ajax_form.php)
        type:     "POST", //метод отправки
        dataType: "html", //формат данных
        data: $("#"+ajax_form).serialize(),  // Сеарилизуем объект
        success: function(response) { //Данные отправлены успешно
        	result = $.parseJSON(response);
        	$('#result_form').append('<div><label for = "meta'+result.id+'"><input type = "checkbox" name = "metas[]" id = "meta'+result.id+'" value = "'+result.id+'" checked title="'+result.name+'">'+result.name+'</label></div>');
            $('#checked-tags-add').append('<span class="tags-plase-prew">'+result.name+'</span>')
            $('#addtags_form').val('');
            $('#addtags_form').attr("placeholder", "");
    	},
    	error: function(response) { // Данные не отправлены
            $('#result_form').html('Ошибка. Данные не отправлены.');
            
    	}
 	});
}
