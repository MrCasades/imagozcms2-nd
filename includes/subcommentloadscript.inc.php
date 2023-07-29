<script>
    $(document).ready(function() {
        $('#subcomments_<?php echo $comment['id'];?>').load("//"+"<?php echo MAIN_URL; ?>"+"/viewwallpost/getsubcomment.inc.php/?id=<?php echo $comment['id'];?>&selauthid=<?php echo $selectedAuthor;?>&typeart=<?php echo $pubFolder; ?>");
       
        //Получение ответов
        // $('#load_<?php echo $comment['id'];?>').click(function(e) {  
        //     $('#result_form_<?php echo $comment['id']; ?>').empty();
        //     // $('#subcomments_<?php echo $comment['id'];?>').load("../viewwallpost/getsubcomment.inc.php/?id=<?php echo $comment['id'];?>&selauthid=<?php echo $selectedAuthor;?>");
        //     $('#hide_open_pl_<?php echo $comment['id']; ?>').show();
        //     e.preventDefault();
        // })

        //Скрытие ответов
        // $('#subcomment_hide_<?php echo $comment['id'];?>').click(function(e){
        //     $('#result_form_<?php echo $comment['id']; ?>').empty();
        //     $('#subcomments_<?php echo $comment['id'];?>').empty();
        //     $('#hide_open_pl_<?php echo $comment['id'];?>').hide();
        //     e.preventDefault();
        // })

        //Показать форму ответа
        $('#op_form_<?php echo $comment['id'];?>').click(function(e) {  
            console.log("Klick");
            $('#answ_<?php echo $comment['id'];?>').show();
            e.preventDefault();
        })

        //Добавить новый ответ динамически
        $('#add_subcomm_<?php echo $comment['id']; ?>').click(function(e) {  
            $.ajax({
                url:     '//<?php echo MAIN_URL; ?>/includes/addsubcomment.inc.php', //url страницы (action_ajax_form.php)
                type:     "POST", //метод отправки
                dataType: "html", //формат данных
                data: $("#subcomm_form_<?php echo $comment['id'];?>").serialize(),  // Сеарилизуем объект
                success: function(response) { //Данные отправлены успешно
                    result = $.parseJSON(response);
                    let avatar = result.avatar !== '' ? '<div><img src="//<?php echo MAIN_URL; ?>/avatars/'+result.avatar+'" alt="ava"/></div>' : '<i class="fa fa-user-circle-o" aria-hidden="true"></i>'
                    $('#result_form_<?php echo $comment['id']; ?>').prepend('<div class="all-sub-comments"><div class="comment m-content "><div class="comment-person-pl">'+avatar+'<div class="comment-person-name"><a href="../account/?id='+result.idauthor+'">'+result.authorname+'</a><br><span class="comment-date">Только что</span></div></div><div class="comment-text"><p><form action = "//<?php echo MAIN_URL; ?>/viewwallpost/index.php" method = "post"><div><input type = "hidden" name = "id" value = "'+result.id+'"><input type = "hidden" name = "idarticle" value = "'+result.idarticle+'"><input type = "submit" name = "action" class="btn_2" value = "Редактировать"><input type = "submit" name = "action" class="btn_1" value = "Del"></div></form></p>'+result.text+'</div></div><div class = "comment-line"></div></div>');
                    
                    // let countSubComm = document.getElementById('subcomm_count_<?php echo $comment['id']; ?>');//счётчик комментариев
                    // countSubComm.innerHTML = Number(countSubComm.innerHTML) + 1;

                    let notComment = document.getElementById('not_comment_sub');

                    if (notComment)//Убираем надпись "Комментарии отсутствуют"
                    {
                        notComment.innerHTML = '';
                    }

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