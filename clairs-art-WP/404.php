<?php get_header(); ?>

<main id="primary" class="site-main py-5">
<div class="container text-center">

	<h1 class="display-1 fw-light text-brand">404</h1>
	<p class="lead mb-4"><?php esc_html_e('Page not found.', 'clairs-art'); ?></p>
	<a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-brand px-5"><?php esc_html_e('Back to Home', 'clairs-art'); ?></a>

</div>
</main>

<?php get_footer(); ?>

