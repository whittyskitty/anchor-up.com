<?php 


// https://www.advancedcustomfields.com/resources/blocks/
add_action('acf/init', function () {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // register a testimonial block.
        acf_register_block_type(array(
        'name'              => 'video-donation-block',
            'title'             => __('Video banner Donation Block'),
            'description'       => __('A custom testimonial block.'),
            'render_template'   => 'template-parts/blocks/aloe/video-donation-block.php',
            'category'          => 'aloe-blocks',
            'icon'              => 'cover-image',
            'keywords'          => array( 'testimonial', 'quote' ),
        ));
    }
});