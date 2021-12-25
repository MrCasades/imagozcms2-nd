<script>
    $(document).ready(function() {
        //Добавить новый ответ динамически
        $('#like_<?php echo $comment['id']; ?>').click(function(e) {
            $('#type_like_<?php echo $comment['id'];?>[name="type-like"]').val('like');
            pushLike();
            e.preventDefault(); 
            console.log($('#type_like_<?php echo $comment['id'];?>[name="type-like"]').val());
        })

        $('#dislike_<?php echo $comment['id']; ?>').click(function(e) {
            $('#type_like_<?php echo $comment['id'];?>[name="type-like"]').val('dislike');
            pushLike();
            e.preventDefault(); 
            console.log($('#type_like_<?php echo $comment['id'];?>[name="type-like"]').val());
        })

        function pushLike(){
                $.ajax({
                url:     '../addlike/addlike.inc.php', //url страницы (action_ajax_form.php)
                type:     "POST", //метод отправки
                dataType: "html", //формат данных
                data: $("#like_form_<?php echo $comment['id'];?>").serialize(),  // Сеарилизуем объект
                success: function(response) { //Данные отправлены успешно
                    result = $.parseJSON(response);
                    $('#result_form_<?php echo $comment['id']; ?>').prepend(result.res);
                    console.log('ОК')                                     
                },
                error: function(response) { // Данные не отправлены
                    $('#result_form_<?php echo $comment['id']; ?>').html('Ошибка. Данные не отправлены.');
                        
                }            
            });
        }        
    })
</script>