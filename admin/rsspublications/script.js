/*Загрузка результатов поиска*/

$( document ).ready(function() {

   $('#sitemap').click(function(e) {
      let url = '//'+document.location.host + '/imagozcms2-nd/sitemap.php';
      console.log (url)
      $('#result').load(url, function() {
         alert('Load was performed.');
      });
         
   })

   // $('#generate').click(function(e) {

   //    if ($('#dt1').val() == '' || $('#dt2').val() == '') {
   //       console.log('interval ' + $('#dt1').val() + '-' + $('#dt2').val());
   //       alert('Интервал не может быть пустым');
         
   //    } else if ($('#dt1').val() > $('#dt2').val() ) {
   //       console.log('interval ' + $('#dt1').val() + '-' + $('#dt2').val());
   //       alert('Интервал некорректный');
         
   //    } else {
   //       console.log('interval ' + $('#dt1').val() + '-' + $('#dt2').val());
         
   //       let timeOutVal = 3000;//Длина таймаута

   //       $('#generate').attr('disabled', true);
   //       $('#generate').html('Заблокировано на '+timeOutVal/1000+' сек');

   //       setTimeout(function(){
   //          $('#generate').attr('disabled', false);
   //          $('#generate').html('Сгенерировать');
   //       }, timeOutVal);

   //       $.ajax({
   //                url: 'generation.inc.php',
   //                type: 'POST',
   //                data: $("#generate_form").serialize(),  // Сеарилизуем объект

   //                success: function(response) { //Данные отправлены успешно
   //                      result = $.parseJSON(response);  
   //                      console.log(result);
   //                      console.log('ОК');   
                        
   //                      if (result.res == 'generated'){
   //                            $('#succ_form').html('<b>Дайджест сгенерирован!</b>');
   //                      } else {
   //                            $('#succ_form').html('<b>Неудача</b>');
   //                      }
   //                },
   //          });        
   //    }
   // })
})
       
