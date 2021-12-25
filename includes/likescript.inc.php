<script>
    $(document).ready(function() {
        //Добавить новый ответ динамически
        $('#like_<?php echo $comment['id']; ?>').click(function(e) {
            $('#type_like_<?php echo $comment['id'];?>[name="type-like"]').val('like');
            pushLike();

            if ($('#lk_sign_<?php echo $comment['id']; ?>').hasClass('fa-thumbs-o-up') && $('#dlk_sign_<?php echo $comment['id']; ?>').hasClass('fa-thumbs-o-down')){
                        $('#lk_sign_<?php echo $comment['id']; ?>').removeClass('fa-thumbs-o-up');
                        $('#lk_sign_<?php echo $comment['id']; ?>').addClass('fa-thumbs-up');
                        $('#likecount_<?php echo $comment['id']; ?>').html(parseInt($('#likecount_<?php echo $comment['id']; ?>').html()) + 1);
                    } else if ($('#lk_sign_<?php echo $comment['id']; ?>').hasClass('fa-thumbs-o-up') && $('#dlk_sign_<?php echo $comment['id']; ?>').hasClass('fa-thumbs-down')){
                        $('#lk_sign_<?php echo $comment['id']; ?>').removeClass('fa-thumbs-o-up');
                        $('#lk_sign_<?php echo $comment['id']; ?>').addClass('fa-thumbs-up');
                        $('#dlk_sign_<?php echo $comment['id']; ?>').removeClass('fa-thumbs-down');
                        $('#dlk_sign_<?php echo $comment['id']; ?>').addClass('fa-thumbs-o-down');
                        $('#dislikecount_<?php echo $comment['id']; ?>').html(parseInt($('#dislikecount_<?php echo $comment['id']; ?>').html()) - 1);
                        $('#likecount_<?php echo $comment['id']; ?>').html(parseInt($('#likecount_<?php echo $comment['id']; ?>').html()) + 1);
                    } else if ($('#lk_sign_<?php echo $comment['id']; ?>').hasClass('fa-thumbs-up')) {
                        $('#lk_sign_<?php echo $comment['id']; ?>').removeClass('fa-thumbs-up');
                        $('#lk_sign_<?php echo $comment['id']; ?>').addClass('fa-thumbs-o-up');
                        $('#likecount_<?php echo $comment['id']; ?>').html(parseInt($('#likecount_<?php echo $comment['id']; ?>').html()) - 1);
                    }
            e.preventDefault(); 
            console.log($('#type_like_<?php echo $comment['id'];?>[name="type-like"]').val());
        })

        $('#dislike_<?php echo $comment['id']; ?>').click(function(e) {
            $('#type_like_<?php echo $comment['id'];?>[name="type-like"]').val('dislike');
            pushLike();    

            if ($('#dlk_sign_<?php echo $comment['id']; ?>').hasClass('fa-thumbs-o-down') && $('#lk_sign_<?php echo $comment['id']; ?>').hasClass('fa-thumbs-o-up')){
                        $('#dlk_sign_<?php echo $comment['id']; ?>').removeClass('fa-thumbs-o-down');
                        $('#dlk_sign_<?php echo $comment['id']; ?>').addClass('fa-thumbs-down');
                        $('#dislikecount_<?php echo $comment['id']; ?>').html(parseInt($('#dislikecount_<?php echo $comment['id']; ?>').html()) + 1);
                    } else if ($('#dlk_sign_<?php echo $comment['id']; ?>').hasClass('fa-thumbs-o-down') && $('#lk_sign_<?php echo $comment['id']; ?>').hasClass('fa-thumbs-up')){
                        $('#dlk_sign_<?php echo $comment['id']; ?>').removeClass('fa-thumbs-o-down');
                        $('#dlk_sign_<?php echo $comment['id']; ?>').addClass('fa-thumbs-down');
                        $('#lk_sign_<?php echo $comment['id']; ?>').removeClass('fa-thumbs-up');
                        $('#lk_sign_<?php echo $comment['id']; ?>').addClass('fa-thumbs-o-up');
                        $('#dislikecount_<?php echo $comment['id']; ?>').html(parseInt($('#dislikecount_<?php echo $comment['id']; ?>').html()) + 1);
                        $('#likecount_<?php echo $comment['id']; ?>').html(parseInt($('#likecount_<?php echo $comment['id']; ?>').html()) - 1);
                    } else if ($('#dlk_sign_<?php echo $comment['id']; ?>').hasClass('fa-thumbs-down')) {
                        $('#dlk_sign_<?php echo $comment['id']; ?>').removeClass('fa-thumbs-down');
                        $('#dlk_sign_<?php echo $comment['id']; ?>').addClass('fa-thumbs-o-down');
                        $('#dislikecount_<?php echo $comment['id']; ?>').html(parseInt($('#likecount_<?php echo $comment['id']; ?>').html()) - 1);
                    }       
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