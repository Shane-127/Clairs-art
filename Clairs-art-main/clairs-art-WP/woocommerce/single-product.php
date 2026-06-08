<?php
defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main py-5">
<div class="container">

	<?php while (have_posts()) : the_post(); ?>
	<?php
	global $product;
	$product = wc_get_product(get_the_ID());
	if (!$product) continue;
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);

	$img_id  = $product->get_image_id();
	$img_url = $img_id
		? wp_get_attachment_image_url($img_id, 'large')
		: wc_placeholder_img_src();
	$img_alt = $img_id
		? (get_post_meta($img_id, '_wp_attachment_image_alt', true) ?: $product->get_name())
		: $product->get_name();

	$contact_page = get_page_by_path('contact');
	$enquire_url  = $contact_page
		? add_query_arg('art', get_post_field('post_name', get_the_ID()), get_permalink($contact_page))
		: '';
	?>

	<div class="row gy-5 align-items-start">

		<div class="col-md-6">
			<img src="<?php echo esc_url($img_url); ?>"
				 alt="<?php echo esc_attr($img_alt); ?>"
				 class="img-fluid rounded-4 shadow-sm w-100"
				 style="object-fit:cover; max-height:560px;">
		</div>

		<div class="col-md-6">
			<?php do_action('woocommerce_single_product_summary'); ?>

			<div class="d-flex flex-wrap align-items-start gap-3 mt-3">
				<?php woocommerce_template_single_add_to_cart(); ?>

				<?php if ($enquire_url) : ?>
				<a href="<?php echo esc_url($enquire_url); ?>" class="btn btn-outline-autumn">
					<?php esc_html_e('Enquire About This Piece', 'clairs-art'); ?>
				</a>
				<?php endif; ?>
			</div>
		</div>

	</div>

	<div class="row mt-5">
		<div class="col-lg-8">
			<?php do_action('woocommerce_after_single_product_summary'); ?>
		</div>
	</div>

	<?php endwhile; ?>

</div>
</main>

<?php get_footer(); ?>
