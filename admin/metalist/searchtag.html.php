<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';?>

<fieldset id="tags_list">
	<legend>Список</legend>
		<?php if (empty ($searshedMetas)): ?>
            <p class = "for-info-txt">Поиск не дал результата</p>
		<?php endif;?>
		
			 
        <?php if (isset ($searshedMetas)): ?>
            <?php foreach ($searshedMetas as $searshedMeta): ?>
            <div>
                <button type="button" class="btn_1" id = "btn<?php htmlecho ($searshedMeta['idmeta']);?>" value = "<?php htmlecho ($searshedMeta['idmeta']);?>"><?php htmlecho ($searshedMeta['metaname']);?></button>
            </div>

            <script>
                $('#btn<?php htmlecho ($searshedMeta['idmeta']);?>').click(function(){
                    $('#checked-tags').append('<span class="tags-plase-prew" id="prew'+<?php htmlecho ($searshedMeta['idmeta']);?>+'">'+'<?php htmlecho ($searshedMeta['metaname']);?>'+' <button type="button" onclick="RemoveTag('+<?php htmlecho ($searshedMeta['idmeta']);?>+')" class="btn_2" id="remove'+<?php htmlecho ($searshedMeta['idmeta']);?>+'">X</button></span>')
                    $('#tags-to-form').append('<input type = "hidden" class= "tags-form-pl" name = "metas[]" id = "meta'+ '<?php htmlecho ($searshedMeta['idmeta']);?>' +'" value = "'+ '<?php htmlecho ($searshedMeta['idmeta']);?>' +'">')
                    $('#addtags_form').val('');
                    $('#tags_list').remove();
                })
            </script>
            <?php endforeach; ?>
        <?php endif;?>
</fieldset>

<script>
    function RemoveTag(id){
                    console.log('click');
                  
                    $('#prew' + id).remove();
                    $('#meta' + id).remove();
                }
</script>
<!-- <script>
    


    checkedTags();    

    function checkedTags() {
        //hide show tags list
        const checked2 =[];
        const checked3=[];

        $('#tags_list input:checkbox:checked').each(function() {
                checked2.push('<span class="tags-plase-prew">' + $(this).attr('title') + '</span> ');
                checked3.push('<input type = "hidden" class= "tags-form-pl" name = "metas[]" id = "meta'+ $(this).attr('id') +'" value = "'+ $(this).attr('id') +'">');
                console.log(checked2);
            });

        $('#checked-tags').append(checked2)
        $('#tags-to-form').append(checked3)

        $('#tags_list input:checkbox').click(function(e) {
            if ($(this).is(':checked')){
                checked2.push('<span class="tags-plase-prew">' + $(this).attr('title') + '</span> ');
                checked3.push('<input type = "hidden" class= "tags-form-pl" name = "metas[]" id = "'+ $(this).attr('id') +'" value = "'+ $(this).attr('value') +'">');
                console.log(checked2);
                console.log(checked3);
            } else {
                // Array.prototype.remove = function(el) {
                //     return this.splice(this.indexOf(el), 1);
                // }
                console.log($(this).attr('title'));
                let index = checked2.indexOf('<span class="tags-plase-prew">' + $(this).attr('title') + '</span> ');
                let index2 = checked3.indexOf('<input type = "hidden" class= "tags-form-pl" name = "metas[]" id = "'+ $(this).attr('id') +'" value = "'+ $(this).attr('value') +'">');
                console.log(index);
                checked2.splice(index, 1);
                checked3.splice(index2, 1);
                $('#checked-tags').append(checked2)
                $('#tags-to-form').append(checked3)
                console.log(checked2);
                console.log(checked3);
            }

            $('#checked-tags').append(checked2)
            $('#tags-to-form').append(checked3)
        })
    }

    
</script> -->