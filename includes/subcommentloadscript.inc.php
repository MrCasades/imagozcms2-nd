<script>
    $(document).ready(function() {
        $('#load_<?php echo $comment['id'];?>').click(function(e) {  
            $('#subcomments_<?php echo $comment['id'];?>').load("../viewwallpost/gessubcomment.inc.php/?id=<?php echo $comment['id'];?>");
            $('#hide_open_pl_<?php echo $comment['id']; ?>').show();
            e.preventDefault();
        })

        $('#subcomment_hide_<?php echo $comment['id'];?>').click(function(e){
            $('#subcomments_<?php echo $comment['id'];?>').empty();
            $('#hide_open_pl_<?php echo $comment['id'];?>').hide();
            e.preventDefault();
        })

        $('#op_form_<?php echo $comment['id'];?>').click(function(e) {  
            console.log("Klick");
            $('#answ_<?php echo $comment['id'];?>').show();
            e.preventDefault();
        })
    })
</script>