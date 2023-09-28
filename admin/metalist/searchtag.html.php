<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';?>

<fieldset>
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