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
	$about_page = get_page_by_path('about');
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

<hr class="section-divider">

<div class="bio-section py-5">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<h2 class="section-title"><?php echo esc_html($about_page ? get_the_title($about_page) : __('Meet Clair', 'clairs-art')); ?></h2>
				<?php
				if ($about_page && $about_page->post_content) {
					$excerpt = $about_page->post_excerpt
						?: wp_trim_words(wp_strip_all_tags($about_page->post_content), 55);
					echo '<p>' . esc_html($excerpt) . '</p>';
				} else {
					echo '<p>Clair is a self-taught artist with Down Syndrome whose creativity is deeply rooted in connection, observation, and joy. From a young age, drawing has been her favourite way to express herself, and today she is developing her own unique interpretation of the people around her.</p>';
				}
				?>
				<?php if ($about_page) : ?>
				<a href="<?php echo esc_url(get_permalink($about_page)); ?>" class="btn btn-outline-brand">Read More</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

</main>

<?php get_footer(); ?>
