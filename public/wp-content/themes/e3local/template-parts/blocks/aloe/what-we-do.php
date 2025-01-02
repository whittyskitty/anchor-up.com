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
        <!-- <h3 class="action-header-white"><?=get_field('header');?></h3> -->
        <p class="header-sm text-white px-8"><?=get_field('our_mission_text');?></p>
        <div class="flex flex-row flex-wrap mt-12 justify-center">
            <?php foreach (get_field('missions') as $mission) { ?>
            <div class="flex w-full justify-center md:w-1/2 lg:w-1/3 pb-4 mb-4 px-8">
                <div class="flex-row flex-wrap bg-white">
                    <div style="max-width: 330px;"class=" p-4 m-auto">
                        <img class="m-auto" src="<?= wp_get_attachment_image_url($mission['image'],'medium');?>">
                        <h3 class="text-lg font-bold pt-2"><?=$mission['header'];?></h3>
                        <p><?=$mission['text'];?></p>
                        <?php if ($mission['show_button']) { ?>
                            <div class="flex mt-2">
                                <a class="primary-button" href="<?=$mission['button_link'];?>"><?=$mission['button_text'];?></a>
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