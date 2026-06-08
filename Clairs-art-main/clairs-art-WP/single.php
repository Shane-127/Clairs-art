<?php get_header(); ?>

<main id="primary" class="site-main py-5">
<div class="container">
	<div class="row justify-content-center">
		<div class="col-lg-8">

			<?php while (have_posts()) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h1 class="entry-title mb-2"><?php the_title(); ?></h1>
				<p class="entry-meta mb-4">
					<?php echo esc_html(get_the_date()); ?>
					<?php if (get_the_author()) : ?>
					&mdash; <?php the_author(); ?>
					<?php endif; ?>
				</p>
				<?php if (has_post_thumbnail()) : ?>
				<div class="mb-4"><?php the_post_thumbnail('large', ['class' => 'img-fluid rounded-4']); ?></div>
				<?php endif; ?>
				<div class="entry-content"><?php the_content(); ?></div>
			</article>

			<?php endwhile; ?>

		</div>
	</div>
</div>
</main>

<?php get_footer(); ?>
