/*Загрузка результатов поиска*/

$( document ).ready(function() {

  /*Загрузка результатов поиска*/

    $( "#search-btn" ).click(function(e) {
       const category = $('#category[name="category"]').val();
       const text = $('#text[name="text"]').val();
       const articleType = $('input[name="article_type"]:checked').val();
        console.log("search.inc.php?text=" + text+"&category=" + category + "&article_type=" + articleType)

       if (text.length < 3){
          $( "#search-result" ).html('<p class="for-info-txt">Нужно ввести от 3-х знаков для поиска!</p>')
          e.preventDefault()
       } else {
          $( "#search-result" ).load( "search.inc.php?text=" + text+"&category=" + category + "&article_type=" + articleType)
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
