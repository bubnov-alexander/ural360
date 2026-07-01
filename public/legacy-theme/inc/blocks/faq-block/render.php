<?php
$classes = isset($block['className']) ? ' '.$block['className'] : '';
$align   = (isset($block['align']) && !empty($block['align'])) ? ' align'.$block['align'] : '';

$title = get_field('title');
$questions = get_field('questions');

if (!$questions) return;
?>
<section class="faq<?=$classes;?><?=$align;?>">
    <?php if($title) { ?>
        <h2 class="faq__title block-title"><?=$title;?></h2>
    <?php } ?>
    <div class="faq__row">
        <div class="faq__content">
            <div class="tabs-grid flex">
                <div class="acc__block">
                    <?php foreach( $questions as $key => $id ) { 
                        get_template_part( 'inc/parts/template-question', null, ['item_id' => $id, 'key' => $key]);
                    } ?>
                </div>
            </div>
        </div>
        <div class="faq__form">
            <div class="form">
                <h3 class="form__title">Задать вопрос</h3>
                <button class="btn form__btn open-modal" data-modal="questions">Задать вопрос</button>
            </div>
        </div>
    </div>
</section>