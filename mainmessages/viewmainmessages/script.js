//Добавить новый ответ динамически
$('#send-mess').click(function(e) {  
    $.ajax({
        url:     'adddellmess.inc.php', //url страницы (action_ajax_form.php)
        type:     "POST", //метод отправки
        dataType: "html", //формат данных
        data: $("#mess-form").serialize(),  // Сеарилизуем объект
        success: function(response) { //Данные отправлены успешно
            result = $.parseJSON(response);
            $('#result_form').prepend('<div class = "mess-pl-style-fr"><span class = "mess-header"></span><div class="del-mess"><form action = "..\..\mainmessages\addupdmainmessage\ " method = "post"><input type = "hidden" name = "idmessage" value = "'+ result.id +'"></div><input type = "submit" name = "action" value = "X" class="btn_1"></form><div class = "mess-text"><p>'+result.text+'</p></div>');
             
            //$('#answ_').hide();
            $('.trumbowyg-editor').html('');
            console.log('Ok');
            // let commentPlace = document.getElementById('comment');
            // commentPlace.innerHTML = '';
            
            //$('#checked-tags-add').append('<span class="tags-plase-prew">'+result.name+'</span>')
        // $('#addtags_form').val('');
        },
        error: function(response) { // Данные не отправлены
            $('#result_form').html('Ошибка. Данные не отправлены.');
            
        }
        
    });

    e.preventDefault(); 
})