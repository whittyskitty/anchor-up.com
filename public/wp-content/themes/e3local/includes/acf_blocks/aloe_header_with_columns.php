<?php 


// https://www.advancedcustomfields.com/resources/blocks/
add_action('acf/init', function () {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'header-with-columns',
            'title'             => __('Header with Columns'),
            'description'       => __('A custom aloe block.'),
            'render_template'   => 'template-parts/blocks/aloe/header-with-columns.php',
            'category'          => 'aloe-blocks',
            'icon'              => 'columns',
            'keywords'          => array( 'aloe', 'values','foundations','values & foundations', 'header with columns', 'about us', 'we do' ),
        ));
    }
});