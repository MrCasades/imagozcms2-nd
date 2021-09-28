<script>
    $(document).ready(function() {
        $('#load_<?php echo $comment['id'];?>').click(function(e) {  
            $('#subcomments_<?php echo $comment['id'];?>').load("../viewwallpost/gessubcomment.inc.php/?id=<?php echo $comment['id'];?>&selauthid=<?php echo $selectedAuthor;?>");
            $('#hide_open_pl_<?php echo $comment['id']; ?>').show();
            e.preventDefault();
        })

        $('#subcomment_hide_<?php echo $comment['id'];?>').click(function(e){
            $('#subcomments_<?php echo $comment['id'];?>').empty();
            $('#hide_open_pl_<?php echo $comment['id'];?>').hide();
            e.preventDefault();
        })

        $('#op_form_<?php echo $comment['id'];?>').click(function(e) {  
            console.log("Klick");
            $('#answ_<?php echo $comment['id'];?>').show();
            e.preventDefault();
        })

        $('#add_subcomm_<?php echo $comment['id']; ?>').click(function(e) {  
            $.ajax({
                url:     '../addsubcomment/addsubcomment.inc.php', //url страницы (action_ajax_form.php)
                type:     "POST", //метод отправки
                dataType: "html", //формат данных
                data: $("#subcomm_form_<?php echo $comment['id'];?>").serialize(),  // Сеарилизуем объект
                success: function(response) { //Данные отправлены успешно
                    result = $.parseJSON(response);
                    $('#result_form_<?php echo $comment['id']; ?>').prepend('<div class="sub-comment m-content"><span class="sub-comment-info">Ответил <a href="../account/?id='+result.subidauthor+'">'+result.subauthorname+'</a> | '+result.date+'</span><p>'+result.text+'</p>');
                    
                    let countSubComm = document.getElementById('subcomm_count_<?php echo $comment['id']; ?>');//счётчик комментариев
                    countSubComm.innerHTML = Number(countSubComm.innerHTML) + 1;

                    //let notComment = document.getElementById('not_comment');

                    // if (notComment)//Убираем надпись "Комментарии отсутствуют"
                    // {
                    //     notComment.innerHTML = '';
                    // }

                    $('#answ_<?php echo $comment['id'];?>').hide();
                    $('.trumbowyg-editor').html('');
                         
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