<?php 


// https://www.advancedcustomfields.com/resources/blocks/
add_action('acf/init', function () {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'what-we-do',
            'title'             => __('What We Do Section'),
            'description'       => __('A custom aloe block.'),
            'render_template'   => 'template-parts/blocks/aloe/what-we-do.php',
            'category'          => 'aloe-blocks',
            'icon'              => 'columns',
            'keywords'          => array( 'aloe', 'what we do','mission','about', 'about us', 'we do' ),
        ));
    }
});