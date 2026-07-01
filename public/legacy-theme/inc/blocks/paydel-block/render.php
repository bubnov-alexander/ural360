<?php
$classes = isset($block['className']) ? $block['className'] : '';
$align   = (isset($block['align']) && !empty($block['align'])) ? 'align' . $block['align'] : '';


$collection = get_field("collection");

?>
<div class="paydel-block alignfull">
    <div class="container">
        <div class="paydel-block__wrapper">
            <?php foreach ($collection as $item) { ?>
                <div class="paydel-block__item">
                    <div class="item__img-holder">
                        <img class="item__img" src="<?= $item['img']['sizes']['thumbnail'] ?>" alt="<?= $item['img']['alt'] ?>">
                    </div>
                    <div class="item__info">
                        <h3 class="item__title"><?= $item['title'] ?></h3>
                        <span class="item__desc"><?= $item['desc'] ?></span>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>