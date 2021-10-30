<script>
    $(document).ready(function() {
        //Удаление диалога
        $('#dd_<?php echo $dialog['idauth'];?>').click(function(e){
            let delDialog = confirm('Вы хотите удалить диалог с пользователем <?php echo $dialog['authorname'];?>');

            if (delDialog) {
                    $.ajax({
                    url:     '../mainmessages/dd.inc.php', //url страницы (action_ajax_form.php)
                    type:     "POST", //метод отправки
                    dataType: "html", //формат данных
                    data: $("#dd_form_<?php echo $dialog['idauth'];?>").serialize(),  // Сеарилизуем объект
                    success: function(response) { //Данные отправлены успешно
                        $('#d_pl_<?php echo $dialog['idauth'];?>').remove();
                        console.log('Del OK');
                    },
                    error: function(response) { // Данные не отправлены
                        $('#result_form_<?php echo $dialog['idauth'];?>').html('Ошибка. Данные не отправлены.');
                    } 
                });
                e.preventDefault();   
            } else {
                e.preventDefault();
            }
        })     
    })
</script>