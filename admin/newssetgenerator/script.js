/*Загрузка результатов поиска*/

$( document ).ready(function() {


   $('#generate').click(function(e) {
      

      if ($('#dt1').val() == '' || $('#dt2').val() == '') {
         console.log('interval ' + $('#dt1').val() + '-' + $('#dt2').val());
         alert('Интервал не может быть пустым');
         
      } else if ($('#dt1').val() > $('#dt2').val() ) {
         console.log('interval ' + $('#dt1').val() + '-' + $('#dt2').val());
         alert('Интервал некорректный');

      } /*else if ($('#lengthtext').val() == 0 || isNAN($('#lengthtext').val())){
         alert('Число в поле не должно быть равно 0 или введено некорректное значение');

      }*/ else {
         console.log('interval ' + $('#dt1').val() + '-' + $('#dt2').val());
         
         let timeOutVal = 3000;//Длина таймаута

         $('#generate').attr('disabled', true);
         $('#generate').html('Заблокировано на '+timeOutVal/1000+' сек');

         setTimeout(function(){
            $('#generate').attr('disabled', false);
            $('#generate').html('Сгенерировать');
         }, timeOutVal);

         $.ajax({
                  url: 'generation.inc.php',
                  type: 'POST',
                  data: $("#generate_form").serialize(),  // Сеарилизуем объект

                  success: function(response) { //Данные отправлены успешно
                        result = $.parseJSON(response);  
                        console.log(result);
                        console.log('ОК');   
                        
                        if (result.res == 'generated'){
                              $('#succ_form').html('<b>Дайджест сгенерирован!</b><br>' + result.preview);
                        } else {
                              $('#succ_form').html('<b>Неудача</b>');
                        }
                  },
            });        
      }
   })
})
       
