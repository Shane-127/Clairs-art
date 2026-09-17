<?php
defined('ABSPATH') || exit;

get_header();

$quick_view_label = clairs_art_quick_view_label();
?>

<main id="primary" class="site-main py-5">
<div class="container">

	<header class="mb-5">
		<h1 class="entry-title"><?php woocommerce_page_title(); ?></h1>
	</header>

	<?php do_action('woocommerce_before_shop_loop'); ?>

	<?php if (have_posts()) : ?>

	<div class="row g-4">
		<?php while (have_posts()) : the_post();
			$product = wc_get_product(get_the_ID());
			if (!$product) { continue; }
			$artwork = clairs_art_artwork_card_data($product);
			$product_id = $product->get_id();
			$product_url = get_permalink($product_id);
		?>
		<div class="col-12 col-sm-6 col-md-4 col-lg-3 product-card">
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
					<?php if ('sold' === $artwork['status']) : ?>
						<span class="badge rounded-pill bg-secondary"><?php esc_html_e('Sold', 'clairs-art'); ?></span>
					<?php else : ?>
						<p class="mb-0 small text-brand"><?php echo wp_kses_post($artwork['price_html']); ?></p>
					<?php endif; ?>
					<a href="<?php echo esc_url($product_url); ?>" class="btn btn-sm btn-outline-brand mt-2 yith-wcqv-button" data-product_id="<?php echo esc_attr($product_id); ?>"><?php echo $quick_view_label; ?></a>
				</div>

			</div>
		</div>
		<?php endwhile; ?>
	</div>

	<?php else : ?>
	<p class="text-muted text-center"><?php esc_html_e('No artworks found.', 'clairs-art'); ?></p>
	<?php endif; ?>

	<?php do_action('woocommerce_after_shop_loop'); ?>

</div>
</main>

<?php get_footer(); ?>

