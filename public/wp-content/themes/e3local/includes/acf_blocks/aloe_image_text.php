<?php 


// https://www.advancedcustomfields.com/resources/blocks/
add_action('acf/init', function () {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'image-text',
            'title'             => __('Aloe Image Text'),
            'description'       => __('A custom aloe block.'),
            'render_template'   => 'template-parts/blocks/aloe/image-text.php',
            'category'          => 'aloe-blocks',
            'icon'              => 'align-pull-left',
            'keywords'          => array( 'aloe', 'image and text','text','image'),
        ));
    }
});