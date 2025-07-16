
</main>

<?php do_action( 'tailpress_content_end' ); ?>

</div>

<?php do_action( 'tailpress_content_after' ); ?>

<footer id="colophon" class="site-footer" role="contentinfo">

	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsFI_hZvdKk_VXf6YORSZaG-Oz2Amyy08&callback=initMap" async defer></script>


	<?php do_action( 'tailpress_footer' ); ?>
	<?php 
		// global $theme_options;
		// if ($theme_options['footer_style_select']) {
		// 	$footer_style = strtolower($theme_options['footer_style_select']);
		// 	require(theme_dir() . '/template-parts/footer/'.$footer_style.'.php'); 
		// } else {
		// 	echo AloeHelpers::front_end_error("Footer Style Not Selected in /wp-admin/admin.php?page=acf-options");
		// }
	?>
	<!-- <div class="container mx-auto text-center text-gray-500">
		&copy; <?php echo date_i18n( 'Y' );?> - <?php echo get_bloginfo( 'name' );?>
	</div> -->
	<?php do_action( 'after_tailpress_footer' ); ?>

	<script src="/wp-content/themes/thealoefamily-theme/partials/jquery.cookie.js"></script>

	<script>
		jQuery().ready(function($){
			$(".mobile-menu .menu-item-has-children").each(function(){
				var menu_option = $(this);
				$( menu_option).click(function(){
					$(menu_option).toggleClass("mobile-menu-item-open");
					$(menu_option).find(".sub-menu").toggle();
				});
			});
		});
	</script>

</footer>

</div>

<?php wp_footer(); ?>

</body>
</html>
