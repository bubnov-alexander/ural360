<?php
$classes = isset($block['className']) ? $block['className'] : '';
$align   = (isset($block['align']) && !empty($block['align'])) ? 'align'.$block['align'] : '';

$title = get_field('title');
$desc = get_field('desc');
$list = get_field('list');
$params = get_field('params');
$image_bg = get_field('image_bg');
$image = get_field('image');
$btn_show = get_field('btn_show');
$btn_name = get_field('btn_name');
$btn_link = get_field('link');

?>
<div id="hero-block" class="<?=$classes;?> <?=$align;?>">
    <div class="hero-image-bg">
        <?php if($image_bg) { echo get_image($image_bg, 'full'); }?>
    </div>
    <div class="container">
        <div class="hero">
            <div class="hero__content">
                <?php if($title)
                { ?>
                    <h1 class="hero__title"><?=$title?></h1>
                    <?php
                } ?>


                
                <?php if($desc)
                { ?>
                    <p class="hero__desc"><?=$desc ?></p>
                    <?php
                } ?>
                <!-- <?php if($list)
                { ?>
                    <ul class="hero__list">
                    <?php foreach($list as $attr){?>
                        <li><?=$attr['text']?></li>
                    <?php } ?>
                    </ul>
                    <?php
                } ?> -->
            <?php if($params){ ?>
                <div class="paramms params_mobile">
                    <?php foreach($params as $key => $param){?>
                        <div class="paramm <?php if($key == 0){ ?>first_paramm<?php } ?>">
                            <?=$param['text']?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
                <?php if($btn_show)
                { ?>
                    <a href="<?=$btn_link ?>" class="btn"><?=$btn_name?></a>
                    <?php
                } ?>
            </div>      
            <?php if($params){ ?>
                <div class="paramms">
                    <?php foreach($params as $key => $param){?>
                        <div class="paramm <?php if($key == 0){ ?>first_paramm<?php } ?>">
                            <?=$param['text']?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
            <div class="hero__image">
                <?php if($image) { echo get_image($image, 'full'); } ?>
            </div>
        </div>
    </div>
</div>