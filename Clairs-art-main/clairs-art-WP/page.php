<?php get_header(); ?>

<main id="primary" class="site-main py-5">
<div class="container">
	<div class="row justify-content-center">
		<div class="col-lg-8">

			<?php while (have_posts()) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h1 class="entry-title mb-4"><?php the_title(); ?></h1>
				<hr>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</article>

			<?php endwhile; ?>

		</div>
	</div>
</div>
</main>

<?php get_footer(); ?>
