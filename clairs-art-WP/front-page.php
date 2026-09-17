<?php get_header(); ?>

<main id="primary" class="site-main">
	<?php
	$tagline = get_bloginfo('description') ?: __('Original artwork by Clair', 'clairs-art');
	$shop_url = class_exists('WooCommerce') ? wc_get_page_permalink('shop') : home_url('/gallery');
	$products = class_exists('WooCommerce') ? wc_get_products([
		'limit'   => 8,
		'status'  => 'publish',
		'orderby' => 'date',
		'order'   => 'DESC',
	]) : [];
	$quick_view_label = clairs_art_quick_view_label();
	?>

<div class="site-hero text-center py-5">
	<div class="container">
		<img src="<?php echo esc_url(clairs_art_logo_url()); ?>"
			 alt="<?php echo esc_attr(get_bloginfo('name')); ?> logo"
			 class="hero-logo mb-3">
		<p class="lead mb-4 text-accent"><?php echo esc_html($tagline); ?></p>
		<a href="<?php echo esc_url($shop_url); ?>" class="btn btn-brand btn-lg px-5">Browse the Gallery</a>
	</div>
</div>

<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>
		<?php if (get_the_content()) : ?>
		<div class="home-content-section py-5">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-10">
						<div class="entry-content">
							<?php the_content(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<hr class="section-divider">
		<?php endif; ?>
	<?php endwhile; ?>
<?php endif; ?>

<section class="container my-5">
	<h2 class="section-title text-center">Latest Works</h2>

	<?php if ($products) : ?>
	<div class="row g-4">
		<?php foreach ($products as $product) :
			$artwork = clairs_art_artwork_card_data($product);
			$product_id = $product->get_id();
			$product_url = get_permalink($product_id);
		?>
		<div class="col-6 col-md-4 col-lg-3 product-card">
			<div class="card border-0 shadow-sm artwork-card">

				<a href="<?php echo esc_url($product_url); ?>" class="yith-wcqv-button d-block" data-product_id="<?php echo esc_attr($product_id); ?>">
				<img src="<?php echo esc_url($artwork['image']); ?>"
					 alt="<?php echo esc_attr($artwork['image_alt']); ?>"
					 class="card-img-top product-card-img"
					 loading="lazy">
				</a>

				<div class="card-body text-center py-3">
					<p class="card-title h6 mb-1 fw-semibold"><a href="<?php echo esc_url($product_url); ?>" class="yith-wcqv-button" data-product_id="<?php echo esc_attr($product_id); ?>"><?php echo esc_html($artwork['title']); ?></a></p>
					<?php if ($artwork['medium']) : ?>
					<p class="mb-1 small text-muted"><?php echo esc_html($artwork['medium']); ?></p>
					<?php endif; ?>
					<?php if ($artwork['status'] === 'sold') : ?>
						<span class="badge rounded-pill bg-secondary"><?php esc_html_e('Sold', 'clairs-art'); ?></span>
					<?php else : ?>
						<p class="mb-0 small text-brand"><?php echo wp_kses_post($artwork['price_html']); ?></p>
					<?php endif; ?>
					<a href="<?php echo esc_url($product_url); ?>" class="btn btn-sm btn-outline-brand mt-2 yith-wcqv-button" data-product_id="<?php echo esc_attr($product_id); ?>"><?php echo $quick_view_label; ?></a>
				</div>

			</div>
		</div>
		<?php endforeach; ?>
	</div>
	<?php else : ?>
	<p class="text-center text-muted"><?php esc_html_e('No artworks yet — check back soon!', 'clairs-art'); ?></p>
	<?php endif; ?>

	<div class="text-center mt-5">
		<a href="<?php echo esc_url($shop_url); ?>" class="btn btn-brand px-5">View All Works</a>
	</div>
</section>

</main>

<?php get_footer(); ?>
