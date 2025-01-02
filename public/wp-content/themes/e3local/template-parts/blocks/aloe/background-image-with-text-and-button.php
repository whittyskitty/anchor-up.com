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

$background_color = get_field('background_color') ?: $theme_options['primary_theme_color'];

$image = get_field('background_image') ?: 32;

?>

<!-- What We Do -->
<div id="<?=$id;?>" class="background-image flex justify-center" style="min-height:520px; background-image:url('<?= wp_get_attachment_image_url($image, 'full'); ?>')">
    <div style="color:white;" class="container m-auto p-4 py-12">
        <h2 class="pb-4 lg:pb-8 cursive_header header-md text-center"><?= get_field('header'); ?></h2>
        <div class="why-the-name-text text-lg lg:text-3xl text-center">
            <?= get_field('text'); ?>
        </div>
        <?php if (get_field('show_button')) { ?>
            <div class="flex text-center text-xl justify-center mt-4 lg:mt-8">						
                <a target="_blank" class="primary-button text-white" href="<?= get_field('button_link'); ?>"><?= get_field('button_text'); ?></a>
            </div>
        <?php } ?>
    </div>
</div>