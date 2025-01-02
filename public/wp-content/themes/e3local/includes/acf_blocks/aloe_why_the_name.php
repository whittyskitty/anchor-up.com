<?php 


// https://www.advancedcustomfields.com/resources/blocks/
add_action('acf/init', function () {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'background-image-with-text-and-button',
            'title'             => __('Background Image with Text and Button'),
            'description'       => __('A custom aloe block.'),
            'render_template'   => 'template-parts/blocks/aloe/background-image-with-text-and-button.php',
            'category'          => 'aloe-blocks',
            'icon'              => 'format-image',
            'keywords'          => array( 'aloe', 'why the name','why','about', 'about us', 'Image', 'Text', 'Button', 'Background Image'),
        ));
    }
});