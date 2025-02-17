<?php

/**
 * Theme setup.
 */

$auto_include_dirs = ['classes'];
foreach ($auto_include_dirs as $dir){
	$dirpath = __DIR__.'/'.$dir;
	$files = preg_grep('/^([^.])/', scandir($dirpath));
	foreach ($files as $f){
		require_once $dirpath.'/'.$f;
	}
}

function tailpress_setup() {
	add_theme_support( 'title-tag' );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'tailpress' ),
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);

    add_theme_support( 'custom-logo' );
	add_theme_support( 'post-thumbnails' );

	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );

	add_theme_support( 'editor-styles' );
	add_editor_style( 'css/editor-style.css' );
}

add_action( 'after_setup_theme', 'tailpress_setup' );

/**
 * Enqueue theme assets.
 */
function tailpress_enqueue_scripts() {
	$theme = wp_get_theme();

	// wp_enqueue_style( 'tailpress', tailpress_asset( 'css/app.css' ), array(), $theme->get( 'Version' ) );
	wp_enqueue_style( 'tailpress', tailpress_asset( 'css/output.css' ), array(), $theme->get( 'Version' ) );
	wp_enqueue_script( 'tailpress', tailpress_asset( 'js/app.js' ), array(), $theme->get( 'Version' ) );

	// Register the stylesheet
    wp_register_style('elementor-post-aloe', get_template_directory_uri() . '/css/elementor-post-411.css');

	// Enqueue the stylesheet
    wp_enqueue_style('elementor-post-aloe');
}

add_action( 'wp_enqueue_scripts', 'tailpress_enqueue_scripts' );

/**
 * Get asset path.
 *
 * @param string  $path Path to asset.
 *
 * @return string
 */
function tailpress_asset( $path ) {
	if ( wp_get_environment_type() === 'production' ) {
		return get_stylesheet_directory_uri() . '/' . $path;
	}

	return add_query_arg( 'time', time(),  get_stylesheet_directory_uri() . '/' . $path );
}

/**
 * Adds option 'li_class' to 'wp_nav_menu'.
 *
 * @param string  $classes String of classes.
 * @param mixed   $item The curren item.
 * @param WP_Term $args Holds the nav menu arguments.
 *
 * @return array
 */
function tailpress_nav_menu_add_li_class( $classes, $item, $args, $depth ) {
	if ( isset( $args->li_class ) ) {
		$classes[] = $args->li_class;
	}

	if ( isset( $args->{"li_class_$depth"} ) ) {
		$classes[] = $args->{"li_class_$depth"};
	}

	return $classes;
}

add_filter( 'nav_menu_css_class', 'tailpress_nav_menu_add_li_class', 10, 4 );

/**
 * Adds option 'submenu_class' to 'wp_nav_menu'.
 *
 * @param string  $classes String of classes.
 * @param mixed   $item The curren item.
 * @param WP_Term $args Holds the nav menu arguments.
 *
 * @return array
 */
function tailpress_nav_menu_add_submenu_class( $classes, $args, $depth ) {
	if ( isset( $args->submenu_class ) ) {
		$classes[] = $args->submenu_class;
	}

	if ( isset( $args->{"submenu_class_$depth"} ) ) {
		$classes[] = $args->{"submenu_class_$depth"};
	}

	return $classes;
}

add_filter( 'nav_menu_submenu_css_class', 'tailpress_nav_menu_add_submenu_class', 10, 3 );

// Adds Options Page for Theme Management
if(function_exists('acf_add_options_page')) {
	acf_add_options_page();
}

// Jquery
// include custom jQuery
function shapeSpace_include_custom_jquery() {
	// wp_deregister_script('jquery');
	wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'shapeSpace_include_custom_jquery');

//require classes

require_once(__DIR__.'/includes/template_functions/!utilities.php');

$auto_include_dirs = ['acf_blocks','classes','template_functions'];
// $auto_include_dirs = ['classes','template_functions'];
foreach ($auto_include_dirs as $dir){
	$dirpath = __DIR__.'/includes/'.$dir;
	$files = preg_grep('/^([^.])/', scandir($dirpath));
	foreach ($files as $f){
		require_once $dirpath.'/'.$f;
	}
}

//https://stackoverflow.com/questions/26180688/how-to-add-class-to-link-in-wp-nav-menu
add_filter( 'nav_menu_link_attributes', 'add_menu_link_class', 1, 3 );
function add_menu_link_class( $atts, $item, $args ) {
	if (property_exists($args, 'link_class')) {
		$atts['class'] = $args->link_class;
	}
	return $atts;
}

// Custom Theme Block Category
// https://wholesomecode.ltd/create-a-custom-block-category-in-the-wordpress-block-inserter-gutenberg
add_action( 'block_categories', function( $categories ) {
    return array_merge(
        $categories,
        [
            [
                'slug'  => 'aloe-blocks',
                'title' => __( 'Aloe Blocks', 'aloe-theme' ),
            ],
        ]
    );
}, 10, 1 );

// Add a filter to modify the options page settings
add_filter('acf/validate_options_page', 'rename_options_page');

function rename_options_page($page)
{
    // Modify the page title and menu title
    $page['page_title'] = __('Aloe Family Website Options', 'acf');
    $page['menu_title'] = $page['page_title'];

	// Add the options page to the Customizer
    $page['customizer'] = true;

    return $page;
}

function enqueue_digital_stylesheet() {
    wp_enqueue_style(
        'digital-styles', // Handle for the stylesheet
        get_template_directory_uri() . '/css/digital.css', // Path to your stylesheet
        array(), // Dependencies, if any
        filemtime(get_template_directory() . '/css/digital.css'), // Versioning for cache-busting
        'all' // Media type
    );
}
add_action('wp_enqueue_scripts', 'enqueue_digital_stylesheet');