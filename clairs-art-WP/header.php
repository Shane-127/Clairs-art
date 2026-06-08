<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-to-content" href="#primary"><?php esc_html_e('Skip to content', 'clairs-art'); ?></a>

<header class="site-header">
	<nav class="navbar navbar-expand-md" aria-label="<?php esc_attr_e('Primary navigation', 'clairs-art'); ?>">
		<div class="container">

			<a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
				<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/clairs-art-logo.png'); ?>"
					 alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
					 class="site-logo">
			</a>

			<button class="navbar-toggler" type="button"
				data-bs-toggle="collapse" data-bs-target="#primary-nav"
				aria-controls="primary-nav" aria-expanded="false"
				aria-label="<?php esc_attr_e('Toggle navigation', 'clairs-art'); ?>">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="primary-nav">
				<?php
				wp_nav_menu([
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'navbar-nav ms-auto',
					'fallback_cb'    => 'clairs_art_fallback_menu',
				]);
				?>
				<?php if (class_exists('WooCommerce') && WC()->cart) : ?>
				<a href="<?php echo esc_url(wc_get_cart_url()); ?>"
				   class="nav-link cart-link ms-2"
				   aria-label="<?php esc_attr_e('View cart', 'clairs-art'); ?>">
					<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true"><path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>
					<?php $count = WC()->cart->get_cart_contents_count(); ?>
					<?php if ($count > 0) : ?>
					<span class="badge rounded-pill bg-autumn"><?php echo esc_html($count); ?></span>
					<?php endif; ?>
				</a>
				<?php endif; ?>
			</div>

		</div>
	</nav>
</header>

<div id="page">

