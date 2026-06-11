<?php get_header(); ?>

<main id="primary" class="site-main py-5">
<div class="container">
	<?php
	$title = __('Latest Posts', 'clairs-art');

	if (is_category() || is_tag() || is_archive()) {
		$title = get_the_archive_title();
	}
	?>

	<?php if (have_posts()) : ?>

	<h1 class="entry-title mb-5"><?php echo esc_html($title); ?></h1>

	<div class="row g-4">
		<?php while (have_posts()) : the_post(); ?>
		<div class="col-md-6 col-lg-4">
			<article id="post-<?php the_ID(); ?>" <?php post_class('card h-100 border-0 shadow-sm'); ?>>
				<?php if (has_post_thumbnail()) : ?>
				<a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail('medium', ['class' => 'card-img-top product-card-img', 'loading' => 'lazy']); ?>
				</a>
				<?php endif; ?>
				<div class="card-body py-3">
					<h2 class="card-title h6 mb-1">
						<a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark"><?php the_title(); ?></a>
					</h2>
					<p class="entry-meta mb-2"><?php echo esc_html(get_the_date()); ?></p>
					<div class="entry-content"><?php the_excerpt(); ?></div>
					<a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline-brand"><?php esc_html_e('Read more', 'clairs-art'); ?></a>
				</div>
			</article>
		</div>
		<?php endwhile; ?>
	</div>

	<div class="mt-5"><?php the_posts_pagination(['mid_size' => 2]); ?></div>

	<?php else : ?>

	<p class="text-muted"><?php esc_html_e('Nothing found.', 'clairs-art'); ?></p>

	<?php endif; ?>

</div>
</main>

<?php get_footer(); ?>

