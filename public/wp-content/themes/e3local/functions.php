<?php

/**
 * Theme setup.
 */

// $auto_include_dirs = ['classes'];
// foreach ($auto_include_dirs as $dir){
// 	$dirpath = __DIR__.'/'.$dir;
// 	$files = preg_grep('/^([^.])/', scandir($dirpath));
// 	foreach ($files as $f){
// 		require_once $dirpath.'/'.$f;
// 	}
// }

function tailpress_setup()
{
    add_theme_support('title-tag');

    register_nav_menus(
        array(
            'primary' => __('Primary Menu', 'tailpress'),
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

    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails');

    add_theme_support('align-wide');
    add_theme_support('wp-block-styles');

    add_theme_support('editor-styles');
    add_editor_style('css/editor-style.css');
}

add_action('after_setup_theme', 'tailpress_setup');

/**
 * Enqueue theme assets.
 */
function tailpress_enqueue_scripts()
{
    $theme = wp_get_theme();

    // wp_enqueue_style( 'tailpress', tailpress_asset( 'css/app.css' ), array(), $theme->get( 'Version' ) );
    wp_enqueue_style('tailpress', tailpress_asset('css/output.css'), array(), $theme->get('Version'));
    wp_enqueue_script('tailpress', tailpress_asset('js/app.js'), array(), $theme->get('Version'));

    // Register the stylesheet
    wp_register_style('elementor-post-aloe', get_template_directory_uri() . '/css/elementor-post-411.css');

    // Enqueue the stylesheet
    wp_enqueue_style('elementor-post-aloe');
}

add_action('wp_enqueue_scripts', 'tailpress_enqueue_scripts');

/**
 * Get asset path.
 *
 * @param string  $path Path to asset.
 *
 * @return string
 */
function tailpress_asset($path)
{
    if (wp_get_environment_type() === 'production') {
        return get_stylesheet_directory_uri() . '/' . $path;
    }

    return add_query_arg('time', time(),  get_stylesheet_directory_uri() . '/' . $path);
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
function tailpress_nav_menu_add_li_class($classes, $item, $args, $depth)
{
    if (isset($args->li_class)) {
        $classes[] = $args->li_class;
    }

    if (isset($args->{"li_class_$depth"})) {
        $classes[] = $args->{"li_class_$depth"};
    }

    return $classes;
}

add_filter('nav_menu_css_class', 'tailpress_nav_menu_add_li_class', 10, 4);

/**
 * Adds option 'submenu_class' to 'wp_nav_menu'.
 *
 * @param string  $classes String of classes.
 * @param mixed   $item The curren item.
 * @param WP_Term $args Holds the nav menu arguments.
 *
 * @return array
 */
function tailpress_nav_menu_add_submenu_class($classes, $args, $depth)
{
    if (isset($args->submenu_class)) {
        $classes[] = $args->submenu_class;
    }

    if (isset($args->{"submenu_class_$depth"})) {
        $classes[] = $args->{"submenu_class_$depth"};
    }

    return $classes;
}

add_filter('nav_menu_submenu_css_class', 'tailpress_nav_menu_add_submenu_class', 10, 3);

// Adds Options Page for Theme Management
if (function_exists('acf_add_options_page')) {
    acf_add_options_page();
}

// Jquery
// include custom jQuery
function shapeSpace_include_custom_jquery()
{
    // wp_deregister_script('jquery');
    wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'shapeSpace_include_custom_jquery');

//require classes

require_once(__DIR__ . '/includes/template_functions/!utilities.php');

$auto_include_dirs = ['acf_blocks', 'classes', 'template_functions'];
// $auto_include_dirs = ['classes','template_functions'];
foreach ($auto_include_dirs as $dir) {
    $dirpath = __DIR__ . '/includes/' . $dir;
    $files = preg_grep('/^([^.])/', scandir($dirpath));
    foreach ($files as $f) {
        require_once $dirpath . '/' . $f;
    }
}

//https://stackoverflow.com/questions/26180688/how-to-add-class-to-link-in-wp-nav-menu
add_filter('nav_menu_link_attributes', 'add_menu_link_class', 1, 3);
function add_menu_link_class($atts, $item, $args)
{
    if (property_exists($args, 'link_class')) {
        $atts['class'] = $args->link_class;
    }
    return $atts;
}

// Custom Theme Block Category
// https://wholesomecode.ltd/create-a-custom-block-category-in-the-wordpress-block-inserter-gutenberg
add_action('block_categories', function ($categories) {
    return array_merge(
        $categories,
        [
            [
                'slug'  => 'aloe-blocks',
                'title' => __('Aloe Blocks', 'aloe-theme'),
            ],
        ]
    );
}, 10, 1);

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

function enqueue_digital_stylesheet()
{
    wp_enqueue_style(
        'digital-styles', // Handle for the stylesheet
        get_template_directory_uri() . '/css/digital.css', // Path to your stylesheet
        array(), // Dependencies, if any
        filemtime(get_template_directory() . '/css/digital.css'), // Versioning for cache-busting
        'all' // Media type
    );
}
add_action('wp_enqueue_scripts', 'enqueue_digital_stylesheet');


add_action('wp_enqueue_scripts', 'enqueue_google_maps_api');
function enqueue_google_maps_api()
{
    if (!is_admin()) {
        wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyD-YOe4j4bcSPO53h71D_NXDZwXYa8-kc8', array(), null, true);
    }
}


add_action('init', 'locations_post_type');
function locations_post_type()
{
    $labels = array(
        'name' => 'Locations',
        'singular_name' => 'Location',

    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => 'locations', // Set the archive slug to 'locations'
        'supports' => array('title', 'editor', 'thumbnail'), //'editor'
        'menu_icon' => 'dashicons-location', // Set the Dashicon class for the menu icon

    );

    register_post_type('location', $args);
}

add_shortcode('google_maps_locations', 'google_maps_shortcode');
function google_maps_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'api_key' => 'AIzaSyD-YOe4j4bcSPO53h71D_NXDZwXYa8-kc8'
    ), $atts);

    ob_start();
?>
    <div id="map-locations" style="height:500px"></div>
    <script>
        function initMapLocations() {
            var mapLocations = new google.maps.Map(document.getElementById('map-locations'), {
                zoom: 4,
                center: {
                    lat: 39.8283,
                    lng: -98.5795
                }
            });

            var locations = [
                <?php
                $args = array(
                    'post_type' => 'location',
                    'posts_per_page' => -1
                );
                $query = new WP_Query($args);

                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        $location_name = get_the_title();
                        $location_address = get_field('location_address');
                        $location_permalink = get_permalink();

                        if ($location_address) {
                            echo "{ name: '" . esc_js($location_name) . "', address: '" . esc_js($location_address) . "', permalink: '" . esc_js($location_permalink) . "'},";
                        }
                    }
                }
                wp_reset_postdata();
                ?>
            ];

            var geocoder = new google.maps.Geocoder();
            var infoWindow = new google.maps.InfoWindow();

            locations.forEach(function(location) {
                geocoder.geocode({
                    address: location.address
                }, function(results, status) {
                    if (status === 'OK') {
                        var marker = new google.maps.Marker({
                            map: mapLocations,
                            position: results[0].geometry.location,
                            title: location.name
                        });

                        marker.addListener('click', function() {
                            infoWindow.setContent('<h3>' + location.name + '</h3><p>' + location.address + '</p>');
                            infoWindow.open(mapLocations, marker);
                        });
                    }
                });
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            initMapLocations();
        });
    </script>
<?php
    return ob_get_clean();
}

add_action('init', 'this_is_us_locations_post_type');
function this_is_us_locations_post_type()
{
    $labels = array(
        'name' => 'This Is Us Locations',
        'singular_name' => 'This Is Us Location',

    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => 'this-is-us-locations', // Set the archive slug to 'locations'
        'supports' => array('title', 'editor', 'thumbnail'), //'editor'
        'menu_icon' => 'dashicons-location', // Set the Dashicon class for the menu icon

    );

    register_post_type('this-is-us-location', $args);
}


add_shortcode('google_maps_this_is_us', 'google_maps_this_is_us_shortcode');
function google_maps_this_is_us_shortcode()
{
    ob_start();
?>
    <div id="map-this-is-us" style="height:500px"></div>
    <script>
        function initMapThisIsUs() {
            var mapThisIsUs = new google.maps.Map(document.getElementById('map-this-is-us'), {
                zoom: 4,
                center: {
                    lat: 39.8283,
                    lng: -98.5795
                }
            });

            var locations = [
                <?php
                $args = array(
                    'post_type' => 'this-is-us-location',
                    'posts_per_page' => -1
                );
                $query = new WP_Query($args);

                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        $location_name = get_the_title();
                        $location_address = get_field('location_address');
                        $location_permalink = get_permalink();
                        $location_video_url = get_field('location_video_url');

                        if ($location_address) {
                            echo "{ name: '" . esc_js($location_name) . "', address: '" . esc_js($location_address) . "', video_url: '" . esc_js($location_video_url) . "'},";
                        }
                    }
                }
                wp_reset_postdata();
                ?>
            ];

            var geocoder = new google.maps.Geocoder();
            var infoWindow = new google.maps.InfoWindow();

            locations.forEach(function(location) {
                geocoder.geocode({
                    address: location.address
                }, function(results, status) {
                    if (status === 'OK') {
                        var marker = new google.maps.Marker({
                            map: mapThisIsUs,
                            position: results[0].geometry.location,
                            title: location.name
                        });

                        marker.addListener('click', function() {
                            var videoEmbed = location.video_url ?
                                '<iframe width="250" height="140" src="' + location.video_url + '" frameborder="0" allowfullscreen></iframe><br>' :
                                '';

                            infoWindow.setContent(
                                videoEmbed +
                                '<h3>' + location.name + '</h3>' +
                                '<p>' + location.address + '</p>'
                            )
                            infoWindow.open(mapThisIsUs, marker);
                        });
                    }
                });
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            initMapThisIsUs();
        });
    </script>
<?php
    return ob_get_clean();
}
