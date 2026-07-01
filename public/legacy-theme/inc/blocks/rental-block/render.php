<?php
$classes = isset($block['className']) ? $block['className'] : '';
$align   = (isset($block['align']) && !empty($block['align'])) ? 'align'.$block['align'] : '';



?>
<div class="<?=$classes;?> <?=$align;?> textpic_block site_block">
	<div class="container">
		<?php
		$img = wp_get_attachment_image_url(get_field('img'), 'large');
		if($img) { ?>
			<div class="img_side side">
				<div class="img_wrap">
					<img src="<?=$img?>" alt="">
				</div>
			</div>
		<?php } ?>

		<?php
		$title = get_field('title');
		$text = get_field('text');
		if($text) { ?>
			<div class="text_side side">
				<h2 class="block-title"><?=$title?></h2>
				<?php echo $text; ?>
			</div>
		<?php } ?>
	</div>
</div>