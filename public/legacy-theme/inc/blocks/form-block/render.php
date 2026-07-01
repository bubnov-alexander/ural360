<?php
$classes = isset($block['className']) ? $block['className'] : '';
$align   = (isset($block['align']) && !empty($block['align'])) ? 'align'.$block['align'] : '';

$title = get_field('title');
$desc = get_field('desc');
$image = get_field('image');

?>
<div id="form-block" class="<?=$classes;?> <?=$align;?>">
    <div class="container">
        <div class="wrap">
            <?php if(!empty($image)) { ?>
                <div class="image">
                    <?=get_image($image, 'full')?>
                </div>
            <?php } ?>
            <div class="form">
                <div class="form__wrap">
                    <?php if(!empty($title)) { ?>
                        <h2 class="block-title form__title"><?=$title?></h2>
                    <?php } ?>
                    <?php if(!empty($desc)) { ?>
                        <p class="form__desc"><?=$desc?></p>
                    <?php } ?>
                    <?=do_shortcode('[contact-form-7 id="769" title="Остались вопросы?"]')?>
                </div>
            </div>
        </div>
    </div>
</div>