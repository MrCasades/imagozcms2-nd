$(document).ready(function() {
  //Txt-place
  $('.mark-textarea-adm').trumbowyg({
      btnsDef: {
          image: {
              dropdown: ['upload'],
              ico: 'insertImage'
          }
      },

      btns: [
          ['viewHTML'],
          ['strong', 'em', 'h2', 'h3'],
          ['link'],
          ['image'],
          ['unorderedList', 'orderedList'],
          ['emoji'],
          ['horizontalRule'],
          ['removeformat'],
          ['fullscreen']
      ],
      plugins: {
          // Add imagur parameters to upload plugin for demo purposes
          upload: {
                  serverPath: '//' + window.location.hostname + '/upload.inc.php',
                  statusPropertyName: 'message',
                  urlPropertyName: 'file'
              }
          },
      autogrow: true,
      lang: 'ru',
      removeformatPasted: true,
      resetCss: true,
      minimalLinks: true,
      defaultLinkTarget: '_blank'
  });
})