<?php
$classes = isset($block['className']) ? $block['className'] : '';
$align   = (isset($block['align']) && !empty($block['align'])) ? 'align'.$block['align'] : '';

$title = get_field('title');
$cats = get_field('cats');

?>
<div id="shop-block" class="<?=$classes;?> <?=$align;?>">
	<div class="container">
		<?php if($title)
		{ ?>
			<h2 class="block-title"><?=$title ?></h2>
		<?php
		} ?>
        <?php if($cats && !empty($cats)) { ?>
        <div class="cats">
            <?php
            wc_get_template( 'loop/loop-start.php' );
                foreach ( $cats as $category ) {
                    wc_get_template(
                        'content-product-cat.php',
                        array(
                            'category' => $category,
                        )
                    );
                }
            ?>
            <li class="item">
                <a class="item__link" href="/routes/">
                    <span class="item__link-name">Перейти в каталог</span>
                </a>
            </li>
            <?php wc_get_template( 'loop/loop-end.php' ); ?>
        </div>
    <?php } ?>
	</div>
</div>
