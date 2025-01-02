<?php

global $theme_options;

// Create id attribute allowing for custom "anchor" value.
$id = $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}
/* id="<?=$id;?>" */

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';

$image = get_field('image') ?: 32;

$image_order = 1;
$text_order = 2;

if (get_field('switch_image_text')) {
    $image_order = 2;
    $text_order = 1;
}
?>

<!-- What We Do -->
<!-- Nashville Food Ministry -->
<div id="<?=$id;?>" class="flex flex-row container m-auto py-12 flex-wrap">
    <div class="flex flex-col w-full lg:w-1/2 p-4 order-<?=$image_order;?> ">
        <img src="<?= wp_get_attachment_image_url($image, 'full'); ?>">
    </div>
    <div class="flex flex-col w-full lg:w-1/2 justify-center order-<?=$text_order;?> lg:w-1/2 p-4">
        <h2 class="header-sm mb-4"><?= get_field('header'); ?></h2>
        <div class="">
            <?= get_field('text'); ?>
        </div>
        <?php if (get_field('show_button')) { ?>
            <div class="flex text-center text-xl justify-center">						
                <a class="primary-button text-white" href="<?= get_field('button_link'); ?>"><?= get_field('button_text'); ?></a>
            </div>
        <?php } ?>
        
    </div>
</div>