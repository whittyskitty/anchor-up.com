<?php
global $theme_options;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?>>

	<?php if (is_home()) { ?>
		<header class="entry-header mb-4">
			<?php the_title(sprintf('<h1 class="entry-title text-2xl lg:text-5xl font-extrabold leading-tight mb-1"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h1>'); ?>
			<time datetime="<?php echo get_the_date('c'); ?>" itemprop="datePublished" class="text-sm text-gray-700"><?php echo get_the_date(); ?></time>
		</header>
	<?php } ?>

	<?php if (is_search() || is_archive()) : ?>

		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div>

	<?php else : ?>

		<div class="entry-content">
			<?php
			/* translators: %s: Name of current post */
			the_content(
				sprintf(
					__('Continue reading %s', 'tailpress'),
					the_title('<span class="screen-reader-text">"', '"</span>', false)
				)
			);

			wp_link_pages(
				array(
					'before'      => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'tailpress') . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
					'pagelink'    => '<span class="screen-reader-text">' . __('Page', 'tailpress') . ' </span>%',
					'separator'   => '<span class="screen-reader-text">, </span>',
				)
			);


			/* TEMPLATE BLOCKS */
			?>
			<!-- LEARN MORE BLOCK-->

			<!-- Statistics Hero Block -->

			<!-- What We Do -->

			<!-- Quote With Stories -->

			<!-- Why Company Details-->

			<!-- Values & Foudndations -->

			<!-- How You Can Help? -->

			<!-- Nashville Food Ministry -->

			<!-- Photo Gallery  -- NEED TO DO
				<div class="container grid grid-cols-3 mx-auto">
					<div class="w-full">
						<img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=989&q=80"
							alt="image">
					</div>
					<div class="w-full rounded">
						<img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=989&q=80"
							alt="image">
					</div>
					<div class="w-full rounded">
						<img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=989&q=80"
							alt="image">
					</div>
				</div>
			-->

			<!-- Global Education Trips -->

			<!-- Nashville Education Support -->

			<!-- Job Skills Training -->

	<?php endif; ?>

</article>

<style>
	/* Position text in the middle of the page/image */
	.bg-text {
		/* background-color: rgb(0,0,0); /* Fallback color */
		/* background-color: rgba(0,0,0, 0.4); Black w/opacity/see-through */
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		z-index: 2;
		width: 100%;
	}

	.action-header,
	.action-header-white {
		max-width: 120px;
		padding: 5px 8px;
		text-align: center;
	}

	.action-header {
		z-index: 10;
		color: white;
		background-color: <?= $theme_options['secondary_theme_color']; ?>;
	}

	.action-header-white {
		color: <?= $theme_options['secondary_theme_color']; ?>;
		background-color: white;
	}
</style>