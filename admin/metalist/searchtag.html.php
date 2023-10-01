<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';?>

<fieldset id="tags_list">
	<legend>Список</legend>
		<?php if (empty ($metas_1)): ?>
            <p class = "for-info-txt">Поиск не дал результата</p>
		<?php endif;?>
		
			 
        <?php if (isset ($metas_1)): ?>
            <?php foreach ($metas_1 as $meta): ?>
            <div>
            <label for = "meta<?php htmlecho ($meta['idmeta']);?>">
            <input class = "all-tags" type = "checkbox" name = "metas[]" id = "meta<?php htmlecho ($meta['idmeta']);?>"
            value = "<?php htmlecho ($meta['idmeta']);?>"
            <?php if ($meta['selected'])
            {
                echo ' checked';
            }
            ?> title="<?php htmlecho ($meta['metaname']);?>"><?php htmlecho ($meta['metaname']);?>
            </label>
            </div>
            <?php endforeach; ?>
        <?php endif;?>
</fieldset>

<script>
    checkedTags();    

    function checkedTags() {
        //hide show tags list
        const checked2 =[];

        $('#tags_list input:checkbox:checked').each(function() {
                checked2.push('<span class="tags-plase-prew">' + $(this).attr('title') + '</span> ');
                console.log(checked2);
            });

        $('#checked-tags').append(checked2)

        $('#tags_list input:checkbox').click(function(e) {
            if ($(this).is(':checked')){
                checked2.push('<span class="tags-plase-prew">' + $(this).attr('title') + '</span> ');
                console.log(checked2);
            } else {
                // Array.prototype.remove = function(el) {
                //     return this.splice(this.indexOf(el), 1);
                // }
                console.log($(this).attr('title'));
                let index = checked2.indexOf('<span class="tags-plase-prew">' + $(this).attr('title') + '</span> ');
                console.log(index);
                checked2.splice(index, 1);
                console.log(checked2);
            }

            $('#checked-tags').append(checked2)
        })
    }

    
</script>