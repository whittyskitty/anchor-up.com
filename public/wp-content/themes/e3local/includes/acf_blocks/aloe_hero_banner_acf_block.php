<?php 


// https://www.advancedcustomfields.com/resources/blocks/
add_action('acf/init', function () {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // register a testimonial block.
        acf_register_block_type(array(
        'name'              => 'herobanner-quote-issue',
            'title'             => __('Herobanner with Quote and Issue'),
            'description'       => __('A custom testimonial block.'),
            'render_template'   => 'template-parts/blocks/aloe/herobanner-quote-issue.php',
            'category'          => 'aloe-blocks',
            'icon'              => 'cover-image',
            'keywords'          => array( 'testimonial', 'quote' ),
        ));
    }
});