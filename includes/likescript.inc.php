<script>
    $(document).ready(function() {
        //Добавить новый ответ динамически
        $('.push-data-<?php echo $comment['id']; ?>').click(function(e) {  
            $.ajax({
                url:     '../addlike/addlike.inc.php', //url страницы (action_ajax_form.php)
                type:     "POST", //метод отправки
                dataType: "html", //формат данных
                data: $("#subcomm_form_<?php echo $comment['id'];?>").serialize(),  // Сеарилизуем объект
                success: function(response) { //Данные отправлены успешно
                    result = $.parseJSON(response);
                    $('#result_form_<?php echo $comment['id']; ?>').prepend(result.res);
                    
                    
                    // countSubComm.innerHTML = Number(countSubComm.innerHTML) + 1;

                    // let notComment = document.getElementById('not_comment_sub');

                    // if (notComment)//Убираем надпись "Комментарии отсутствуют"
                    // {
                    //     notComment.innerHTML = '';
                    // }
     
                    // let commentPlace = document.getElementById('comment');
                    // commentPlace.innerHTML = '';
                    
                    //$('#checked-tags-add').append('<span class="tags-plase-prew">'+result.name+'</span>')
                // $('#addtags_form').val('');
                },
                error: function(response) { // Данные не отправлены
                    $('#result_form_<?php echo $comment['id']; ?>').html('Ошибка. Данные не отправлены.');
                    
                }
                
            });

            e.preventDefault(); 
        })
    })
</script>