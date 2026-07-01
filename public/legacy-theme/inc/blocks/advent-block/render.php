<?php
$classes = isset($block['className']) ? $block['className'] : '';
$align   = (isset($block['align']) && !empty($block['align'])) ? 'align'.$block['align'] : '';

$advant = get_field('advantages');

?>
<div id="advant-block" class="<?=$classes;?> <?=$align;?>">
    <?php if(!empty($advant))
    { ?>                    
        <div class="advant">
            <?php foreach( $advant as $item )
            { ?>
                <div class="item">
                    <div class="item__count"><?=$item['item_count']?></div>
                    <p class="item__text"><?=$item['item_desc']?></p>
                </div>
                <?php
            } ?>
        </div>
        <?php
    } ?>
</div>