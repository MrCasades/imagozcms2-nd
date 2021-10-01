$(document).ready(function() {
    $('#open_form').click(function(e) {  
        $('#subcomm_form').show();
        e.preventDefault();
    })

    $("#push_subcomm").on('click',
		function(e){
			if ($('.trumbowyg-editor').text() === ''){
				$('.trumbowyg-editor').html('');
				$('.trumbowyg-editor').attr("placeholder", "Поле комментария не может быть пустым");
				e.preventDefault();
			} else {
				addSubComment('result_form_subcomm', 'addsubcomm', '../addsubcomment/addsubcomment.inc.php');
				return false; 
			}		
		}
	);
})