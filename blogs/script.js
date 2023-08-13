/*Загрузка результатов поиска*/

$( document ).ready(function() {

  /*Загрузка результатов поиска*/

    $( "#search-btn" ).click(function(e) {
       let category = $('#category[name="category"]').val();
       let text = $('#text[name="text"]').val();
       text = text.replaceAll(' ', '&nbsp;');
       let articleType = $('input[name="article_type"]:checked').val();
        console.log("./searchpost/search.inc.php?text=" + text+"&category=" + category + "&article_type=" + articleType)

       if (text.length < 3 && text.length > 0){
          $( "#search-result" ).html('<p class="for-info-txt">Нужно ввести от 3-х знаков для поиска!</p>')
          e.preventDefault()
       } else if (text.length == 0){
         $('#search-result').empty();
         $('#pubs-pl').delay(500).fadeIn('fast')  
         e.preventDefault()
       }else {
          $( "#search-result" ).load( "../searchpost/search.inc.php?text=" + text+"&category=" + category + "&article_type=" + articleType)
          $('#pubs-pl').delay(500).fadeOut('fast')
          $('#search-result').delay(1000).fadeIn('slow')
          
          e.preventDefault()
       }
  })
})
       
       /*Инициализция таблицы для результатов поиска*/
//        function(e) {
//         $("#myTableSearch").tablesorter();
//       });

//        $( "#last-users" ).hide('fast')
//        $('#search-result').delay(100).fadeIn('slow')

//        e.preventDefault()
//     })
// })

// /*Инициализация TableSorter */
// $(function() {
//   $("#myTableUser").tablesorter({
//       widgets: ['zebra']
//     }
//   )
// })
