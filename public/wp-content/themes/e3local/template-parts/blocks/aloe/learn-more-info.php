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

$box_text = get_field('box_text') ?: 'Your Issue Goes Here...';

?>

<!-- LEARN MORE BLOCK-->
<div id="<?=$id;?>" style="background-color: <?=$background_color;?>;" class="flex flex-wrap pb-8 relative">
    <div class="w-full">
        <h3 class="action-header text-center" style="margin: -17px auto 1rem;"><?= get_field('section_header') ?: 'Take Action';?></h3>
    </div>
    <div class="flex flex-wrap justify-around w-full">
        <?php 
        foreach (get_field('details') as $detail) {
            $link = $detail['header_link']; ?>
            <div style="max-width:240px; color:<?=$theme_options['secondary_theme_color'];?>" class="m-auto flex flex-col pb-4">
                <?php 
                    if ($link) { 
                        echo "<a href='".$link."'>";
                    }
                ?>
                <h4 class="text-2xl font-bold"><?=$detail['header'];?></h4>
                <?php 
                    if ($link) { 
                        echo "</a>";
                    }
                ?>
                <p class="font-bold"><?=$detail['text'];?></p>
            </div>
        <?php
        } ?>
    </div>
</div>