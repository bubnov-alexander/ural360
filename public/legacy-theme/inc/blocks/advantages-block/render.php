<?php
$classes = isset($block['className']) ? $block['className'] : '';
$align   = (isset($block['align']) && !empty($block['align'])) ? 'align'.$block['align'] : '';

$advantages = get_field('advantages');

?>
<div id="advantages-block" class="<?=$classes;?> <?=$align;?>">
    <div class="container">
        <?php if(!empty($advantages)) { 
            get_template_part( 'inc/parts/template-advantages', null, $advantages);
        } ?>
    </div>
</div>