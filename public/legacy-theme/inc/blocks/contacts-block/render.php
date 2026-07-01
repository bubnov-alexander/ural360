<?php
$classes = isset($block['className']) ? $block['className'] : '';
$align   = (isset($block['align']) && !empty($block['align'])) ? 'align'.$block['align'] : '';

$title = get_field('title');
$addresses = @settings('addresses');
$phones = @settings('phones');
$emails = @settings('emails');
$socials = @settings('socials');
?>

<div id="contacts-block" class="<?=$classes?> <?=$align?>">
	<div class="container">
		<div class="contacts">
			<div class="contacts__wrap">
                <?php if (!empty($addresses)) 
                { 
                ?>
                    <div class="item-wrap address">
                        <div class="title">
                            <?=wp_get_attachment_image( $addresses[0]['icon'], 'full'); ?>
                            Адрес
                        </div>
                        <?php foreach($addresses as $address)
                            {
                                if($address['value'])
                                {
                                ?>
                                <div class="item"><?=$address['value']?></div>
                                <?php
                                }
                            }
                        ?>
                    </div>
                <?php 
                } 
                ?>
                <?php if (!empty($phones))
                { 
                    foreach($phones as $phone) 
                    { ?>
                        <div class="item-wrap phone">
                            <div class="title">
                                <?=wp_get_attachment_image( $phone['icon'], 'full'); ?>
                                <?=$phone['name']?>
                            </div>
                            <a href="<?=format('phone', $phone['value'])?>" class="item"><?=$phone['value']?></a>
                        </div>
                        <?php 
                    }
                } 
                ?>
                <?php if (!empty($emails))
                { 
                ?>
				<div class="item-wrap email">
					<div class="title">
                        <?=wp_get_attachment_image( $emails[0]['icon'], 'full'); ?>
                        Эл. почта
                    </div>
					<?php foreach($emails as $email)
						{
							if($email['value'])
							{
							?>
							<a href="<?=format('email', $email['value'])?>" class="item"><?=$email['value']?></a>
							<?php
							}
						}
					?>
				</div>
                <?php 
                } 
                ?>
                <?php if (!empty($socials))
                { 
                ?>
                <div class="soc">
                    <?php foreach ($socials as $item) 
                        { 
                            ?>
                            <a href="<?= $item['value']; ?>" target="_blank" class="soc__item">
                                <?=get_image($item['icon'], [24, 24]); ?>
                            </a>
                            <?php 
                        } 
                    ?>
                    <a href="" class="soc__item"></a>
                </div>
                <?php 
                } 
                ?>
			</div>
			<div class="contacts__map">
				<?php render_map(); ?>
			</div>
		</div>
	</div>
</div>