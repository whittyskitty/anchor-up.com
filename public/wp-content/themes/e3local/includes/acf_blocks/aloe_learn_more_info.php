<?php 


// https://www.advancedcustomfields.com/resources/blocks/
add_action('acf/init', function () {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'learn-more-info',
            'title'             => __('Learn More Info'),
            'description'       => __('A custom aloe block.'),
            'render_template'   => 'template-parts/blocks/aloe/learn-more-info.php',
            'category'          => 'aloe-blocks',
            'icon'              => 'columns',
            'keywords'          => array( 'aloe', 'learn-more','learn','info' ),
        ));
    }
});