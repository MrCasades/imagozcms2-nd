/*Загрузка результатов поиска*/

$( document ).ready(function() {

   //Обновление карты сайта
   $('#sitemap').click(function(e) {
      let url = '//'+document.location.host + '/rsssitemap/';
      console.log (url)
      $('#result').load(url, function() {
         alert('sitemap');
      });
   })

   //Обновление rsssmi.xml
   $('#rsssmi').click(function(e) {
      let url = '//'+document.location.host + '/rsssmi/';
      console.log (url)
      $('#result').load(url, function() {
         alert('rsssmi');
      }); 
   })

   //Обновление rsspulse.xml
   $('#rsspulse').click(function(e) {
      let url = '//'+document.location.host + '/rsspulse/';
      console.log (url)
      $('#result').load(url, function() {
         alert('rsspulse');
      });         
   })

   //Обновление rssvk.xml
   $('#rssvk').click(function(e) {
      let url = '//'+document.location.host + '/rssvk/';
      console.log (url)
      $('#result').load(url, function() {
         alert('rssvk');
      });  
   })

   //Обновление rssdzen.xml
   $('#rssdzen').click(function(e) {
      let url = '//'+document.location.host + '/rssdzen/';
      console.log (url)
      $('#result').load(url, function() {
         alert('rssdzen');
      });  
   })
})
       
