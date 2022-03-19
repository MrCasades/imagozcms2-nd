<script>
    $(document).ready(function() {

        const url = '//<?php echo MAIN_URL;?>/addlike/addlike.inc.php'

        //Добавить лайк / дизлайк для комментария
        
        
        $('#like_<?php echo $comment['id']; ?>').click(function(e) {

            $('#type_like_<?php echo $comment['id'];?>[name="type-like"]').val('like');
            pushLike();
            if($("#like_form_<?php echo $comment['id'];?>").find('input[name="idauthor"]').val() > 0){
                changeClass('like');
            }       
            e.preventDefault(); 
            console.log($('#type_like_<?php echo $comment['id'];?>[name="type-like"]').val());
        })

        $('#dislike_<?php echo $comment['id']; ?>').click(function(e) {
            $('#type_like_<?php echo $comment['id'];?>[name="type-like"]').val('dislike');
            pushLike();    
            if($("#like_form_<?php echo $comment['id'];?>").find('input[name="idauthor"]').val() > 0){
                changeClass('dislike');
            }             
            e.preventDefault(); 
            console.log($('#type_like_<?php echo $comment['id'];?>[name="type-like"]').val());
        })

        function pushLike(){
                $.ajax({
                url:     url, //url страницы (action_ajax_form.php)
                type:     "POST", //метод отправки
                dataType: "html", //формат данных
                data: $("#like_form_<?php echo $comment['id'];?>").serialize(),  // Сеарилизуем объект
                success: function(response) { //Данные отправлены успешно
                    result = $.parseJSON(response);
                    $('#result_form_<?php echo $comment['id']; ?>').html(result.res);
                                       
                    console.log('ОК')                                     
                },
                error: function(response) { // Данные не отправлены
                    $('#result_form_<?php echo $comment['id']; ?>').html('Ошибка. Данные не отправлены.');                      
                }            
            });
        }     

        function changeClass(likeOrDislike){

            if (likeOrDislike === 'like'){
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
            } else if (likeOrDislike === 'dislike'){
                
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
                    $('#dislikecount_<?php echo $comment['id']; ?>').html(parseInt($('#dislikecount_<?php echo $comment['id']; ?>').html()) - 1);
                } 
            }
        }  
        
        

        //Добавить лайк / дизлайк для ответа
        
        $('#like_sc_<?php echo $subcomment['id']; ?>').click(function(e) {

            $('#type_like_<?php echo $subcomment['id'];?>[name="type-like"]').val('like');
            pushLikeSc();
            if($("#like_form_sc_<?php echo $subcomment['id'];?>").find('input[name="idauthor"]').val() > 0){
                changeClass('like');
            }       
            e.preventDefault(); 
            console.log($('#type_like_sc_<?php echo $subcomment['id'];?>[name="type-like"]').val());
        })

        $('#dislike_sc_<?php echo $subcomment['id']; ?>').click(function(e) {
            $('#type_like_sc_<?php echo $subcomment['id'];?>[name="type-like"]').val('dislike');
            pushLike();    
            if($("#like_form_sc_<?php echo $subcomment['id'];?>").find('input[name="idauthor"]').val() > 0){
                changeClassSc('dislike');
            }             
            e.preventDefault(); 
            console.log($('#type_like_sc_<?php echo $subcomment['id'];?>[name="type-like"]').val());
        })

        function pushLikeSc(){
                $.ajax({
                url:     url, //url страницы (action_ajax_form.php)
                type:     "POST", //метод отправки
                dataType: "html", //формат данных
                data: $("#like_form_sc_<?php echo $subcomment['id'];?>").serialize(),  // Сеарилизуем объект
                success: function(response) { //Данные отправлены успешно
                    result = $.parseJSON(response);
                    $('#result_form_<?php echo $subcomment['id']; ?>').html(result.res);
                                       
                    console.log('ОК')                                     
                },
                error: function(response) { // Данные не отправлены
                    $('#result_form_<?php echo $subcomment['id']; ?>').html('Ошибка. Данные не отправлены.');                      
                }            
            });
        }     

        function changeClassSc(likeOrDislike){

            if (likeOrDislike === 'like'){
                if ($('#lk_sc_sign_<?php echo $subcomment['id']; ?>').hasClass('fa-thumbs-o-up') && $('#dlk_sc_sign_<?php echo $subcomment['id']; ?>').hasClass('fa-thumbs-o-down')){
                    $('#lk_sc_sign_<?php echo $subcomment['id']; ?>').removeClass('fa-thumbs-o-up');
                    $('#lk_sc_sign_<?php echo $subcomment['id']; ?>').addClass('fa-thumbs-up');
                    $('#likecount_sc_<?php echo $subcomment['id']; ?>').html(parseInt($('#likecount_sc_<?php echo $subcomment['id']; ?>').html()) + 1);
                } else if ($('#lk_sign_<?php echo $subcomment['id']; ?>').hasClass('fa-thumbs-o-up') && $('#dlk_sc_sign_<?php echo $subcomment['id']; ?>').hasClass('fa-thumbs-down')){
                    $('#lk_sc_sign_<?php echo $subcomment['id']; ?>').removeClass('fa-thumbs-o-up');
                    $('#lk_sc_sign_<?php echo $subcomment['id']; ?>').addClass('fa-thumbs-up');
                    $('#dlk_sc_sign_<?php echo $subcomment['id']; ?>').removeClass('fa-thumbs-down');
                    $('#dlk_sc_sign_<?php echo $subcomment['id']; ?>').addClass('fa-thumbs-o-down');
                    $('#dislikecount_sc_<?php echo $subcomment['id']; ?>').html(parseInt($('#dislikecount_sc_<?php echo $subcomment['id']; ?>').html()) - 1);
                    $('#likecount_sc_<?php echo $subcomment['id']; ?>').html(parseInt($('#likecount_sc_<?php echo $subcomment['id']; ?>').html()) + 1);
                } else if ($('#lk_sc_sign_<?php echo $subcomment['id']; ?>').hasClass('fa-thumbs-up')) {
                    $('#lk_sc_sign_<?php echo $subcomment['id']; ?>').removeClass('fa-thumbs-up');
                    $('#lk_sc_sign_<?php echo $subcomment['id']; ?>').addClass('fa-thumbs-o-up');
                    $('#likecount_sc_<?php echo $subcomment['id']; ?>').html(parseInt($('#likecount_sc_<?php echo $subcomment['id']; ?>').html()) - 1);
                }   
            } else if (likeOrDislike === 'dislike'){
                
            if ($('#dlk_sc_sign_<?php echo $subcomment['id']; ?>').hasClass('fa-thumbs-o-down') && $('#lk_sc_sign_<?php echo $subcomment['id']; ?>').hasClass('fa-thumbs-o-up')){
                    $('#dlk_sc_sign_<?php echo $subcomment['id']; ?>').removeClass('fa-thumbs-o-down');
                    $('#dlk_sc_sign_<?php echo $subcomment['id']; ?>').addClass('fa-thumbs-down');
                    $('#dislikecount_sc_<?php echo $subcomment['id']; ?>').html(parseInt($('#dislikecount_sc_<?php echo $subcomment['id']; ?>').html()) + 1);
                } else if ($('#dlk_sc_sign_<?php echo $subcomment['id']; ?>').hasClass('fa-thumbs-o-down') && $('#lk_sc_sign_<?php echo $subcomment['id']; ?>').hasClass('fa-thumbs-up')){
                    $('#dlk_sc_sign_<?php echo $subcomment['id']; ?>').removeClass('fa-thumbs-o-down');
                    $('#dlk_sc_sign_<?php echo $subcomment['id']; ?>').addClass('fa-thumbs-down');
                    $('#lk_sc_sign_<?php echo $subcomment['id']; ?>').removeClass('fa-thumbs-up');
                    $('#lk_sc_sign_<?php echo $subcomment['id']; ?>').addClass('fa-thumbs-o-up');
                    $('#dislikecount_sc_<?php echo $subcomment['id']; ?>').html(parseInt($('#dislikecount_sc_<?php echo $subcomment['id']; ?>').html()) + 1);
                    $('#likecount_sc_<?php echo $subcomment['id']; ?>').html(parseInt($('#likecount_sc_<?php echo $subcomment['id']; ?>').html()) - 1);
                } else if ($('#dlk_sc_sign_<?php echo $subcomment['id']; ?>').hasClass('fa-thumbs-down')) {
                    $('#dlk_sc_sign_<?php echo $subcomment['id']; ?>').removeClass('fa-thumbs-down');
                    $('#dlk_sc_sign_<?php echo $subcomment['id']; ?>').addClass('fa-thumbs-o-down');
                    $('#dislikecount_sc_<?php echo $subcomment['id']; ?>').html(parseInt($('#dislikecount_sc_<?php echo $subcomment['id']; ?>').html()) - 1);
                } 
            }
        }   
    })
</script>