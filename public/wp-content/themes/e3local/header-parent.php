<?php 
	global $theme_options;

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<?php
	/*
	if (isset($theme_options['google_measurement_id'])) {
		$analytics_id = $theme_options['google_measurement_id']; 
	}
	if (isset($analytics_id)) { ?>
		<script async src="https://www.googletagmanager.com/gtag/js?id=<?=$analytics_id;?>"></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());

			gtag('config', '<?=$analytics_id;?>');
		</script>
	<?php } else {
		echo AloeHelpers::front_end_error("Google Analytics Measurement ID Not Set in /wp-admin/admin.php?page=acf-options");
	}
	*/
	wp_head(); 

	?>
</head>

<body <?php body_class( 'bg-white text-gray-900 antialiased' ); ?>>

<?php 
// if( !isset($_COOKIE['giving_tuesday_popup'])) { // && current_user_can('administrator')
// 	require(get_template_directory ().'/partials/giving_tuesday_modal.php'); 
// }

// _dd("test");
?>

<?php do_action( 'tailpress_site_before' ); ?>

<div id="page" class="min-h-screen flex flex-col w-full">

	<?php do_action( 'tailpress_header' ); ?>