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
<div id="<?=$id;?>" class="flex" style="background-color: <?= $background_color; ?>">
    <div class="container m-auto flex flex-col py-12 px-4">
        <h2 style="color:<?=get_field('text_color');?>" class="pb-4 lg:pb-8 cursive_header header-md text-center"><?= get_field('header'); ?></h2>
        <p style="color:<?=get_field('text_color');?>" class="text-4xl text-white px-8 text-center"><?=get_field('values_text');?></p>
        <div class="flex flex-row flex-wrap mt-12 justify-center">
            <?php foreach (get_field('values') as $value) { ?>
            <div class="flex w-full justify-center w-full md:w-1/2 lg:w-1/4 px-8 pb-4">
                <div class="flex-row flex-wrap">
                    <div style="max-width: 330px; background-color:<?=get_field('value_background_color');?> "class="p-4 m-auto">
                        <img class="m-auto" src="<?= wp_get_attachment_image_url($value['image'],'medium');?>">
                        <h3 class="text-lg font-bold pt-2"><?=$value['header'];?></h3>
                        <p><?=$value['text'];?></p>
                        <?php if ($value['show_button']) { ?>
                            <div class="flex mt-2">
                                <a class="primary-button" href="<?=$value['button_link'];?>"><?=$value['button_text'];?></a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php 
            } ?>
        </div>
    </div>
</div>