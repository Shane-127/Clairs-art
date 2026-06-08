<?php
defined('ABSPATH') || exit;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('card h-100 border-0 shadow-sm'); ?>>
	<?php if (has_post_thumbnail()) : ?>
	<a href="<?php the_permalink(); ?>">
		<?php the_post_thumbnail('medium', [
			'class'   => 'card-img-top product-card-img',
			'loading' => 'lazy',
			'alt'     => get_the_title(),
		]); ?>
	</a>
	<?php endif; ?>
	<div class="card-body py-3">
		<h2 class="card-title h6 mb-1">
			<a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark"><?php the_title(); ?></a>
		</h2>
		<p class="entry-meta mb-2"><?php echo esc_html(get_the_date()); ?></p>
		<div class="entry-content"><?php the_excerpt(); ?></div>
		<a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline-autumn"><?php esc_html_e('Read more', 'clairs-art'); ?></a>
	</div>
</article>
