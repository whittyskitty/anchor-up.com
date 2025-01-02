<?php

/**
 * Testimonial Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}
/* id="<?=$id;?>" */

// Create class attribute allowing for custom "className" and "align" values.
$className = 'testimonial';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $className .= ' align' . $block['align'];
}

// Load values and assign defaults.
$box_text = get_field('box_text') ?: 'Your Issue Goes Here...';
$hashtag = get_field('hashtag') ?: '#hastag';
$image = get_field('hero_image') ?: 32;

$herobanner_background_color = get_field('herobanner_background_color');
$text_color = get_field('text_color');

// https://source.unsplash.com/random/1200x400 

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';

/* 
?>
<div class="<?=$align_class;?> flex flex-wrap background-image w-full relative z-0" style="min-height:430px; background-image:url('<?=wp_get_attachment_image_url($image, 'full');?>'); background-color:<?=$herobanner_background_color ? $herobanner_background_color : 'white';?>">
    <!-- <span aria-hidden="true" class="wp-block-cover__gradient-background has-background-dim"></span> -->
    <!-- <div class="w-full opacity-50"><?= wp_get_attachment_image($image, 'full' ); ?></div> -->
    
</div>

*/
global $theme_options;

?>
<div id="<?=$id;?>" style="background-color:<?= $herobanner_background_color ? $herobanner_background_color : 'white'; ?>" class="demo-wrap relative">
    <h2 class="hero-hastag cursive_header header-lg"><?= $hashtag; ?></h2>

    <img class="demo-bg" src="<?= wp_get_attachment_image_url($image, 'full'); ?>" alt="">
    <div class="demo-content">
        <h3 class="action-header text-center"><?=get_field('box_header');?></h3>
        <h1 class="text-2xl color:<?= $theme_options['secondary_theme_color']; ?>"><?= $box_text; ?></h1>
    </div>
</div>

<style>
    .hero-hastag {
        color:white;
        position: absolute;
        white-space: nowrap;
        z-index: 10;
        right: 10%;
        top: 10%;
    }
    .demo-wrap {
        min-height:550px;
        overflow: hidden;
        position: relative;
    }

    .demo-content .action-header {
        margin-top: -41px;
        font-size: 13px;
        max-width: 87px;
        margin-bottom: 10px;
    }

    .demo-bg {
        opacity: 0.6;
        position: absolute;
        left: 0;
        top: -20%;
        width: 100%;
        height: auto;
    }

    .demo-content {
        position: absolute;
        background-color: white;
        left: 40px;
        bottom: 40px;
        max-width: 300px;
        padding: 25px;
    }

    @media (max-width:990px) {
        .demo-wrap {
            min-height: 430px;
        }
    }
    @media (max-width:727px) {
        .demo-bg {
            top: 0;
        }

        .demo-content {
            max-width: 100%;
            width: 100%;
            left: auto;
            bottom: 0px;
        }

    }

    @media (max-width:500px) {
        .demo-content {
            padding-bottom: 80px;
        }
    }
</style>