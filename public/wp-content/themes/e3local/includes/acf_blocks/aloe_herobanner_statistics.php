<?php 


// https://www.advancedcustomfields.com/resources/blocks/
add_action('acf/init', function () {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'herobanner-statistics',
            'title'             => __('Banner with Statistics'),
            'description'       => __('A custom aloe block.'),
            'render_template'   => 'template-parts/blocks/aloe/banner-statistics.php',
            'category'          => 'aloe-blocks',
            'icon'              => 'columns',
            'keywords'          => array( 'aloe', 'banner','statistics','banner statistics' ),
        ));
    }
});