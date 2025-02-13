<?php 

get_header("parent");

global $theme_options;
?>

<header>
	<?php 

		// if (isset($theme_options['header_style_select'])) {
		// 	$header_style = strtolower($theme_options['header_style_select']);
		// 	require(theme_dir() . '/template-parts/header/'.$header_style.'.php'); 
		// } else {
		// 	echo AloeHelpers::front_end_error("Header Style Not Selected in /wp-admin/admin.php?page=acf-options");
		// }
	?>
</header>

<div id="content" class="site-content flex-grow">

	<?php if ( is_front_page() ) { ?>
	
	<?php } ?>

	<?php do_action( 'tailpress_content_start' ); ?>

	<main>
