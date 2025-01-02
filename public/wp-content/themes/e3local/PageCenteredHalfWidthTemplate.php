<?php /* Template Name: Centered Half Width Template */ ?>

<?php get_header(); ?>

<div style="max-width:767px;" class="mx-auto p-2">

	<?php if ( have_posts() ) : ?>
		<?php
		while ( have_posts() ) :
			the_post();
			?>

			<?php get_template_part( 'template-parts/content', get_post_format() ); ?>

		<?php endwhile; ?>

	<?php endif; ?>

</div>


<?php
get_footer();