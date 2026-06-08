<?php
defined('ABSPATH') || exit;

get_header();
$contact_page = get_page_by_path('contact');
$contact_url  = $contact_page ? get_permalink($contact_page) : home_url('/contact');
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

			$img_id  = $product->get_image_id();
			$img_url = $img_id
				? wp_get_attachment_image_url($img_id, 'large')
				: wc_placeholder_img_src();
			$img_alt = $img_id
				? (get_post_meta($img_id, '_wp_attachment_image_alt', true) ?: $product->get_name())
				: $product->get_name();

			$medium   = get_post_meta(get_the_ID(), '_artwork_medium', true);
			$size     = get_post_meta(get_the_ID(), '_artwork_size',   true);
			$desc     = $product->get_short_description() ?: '';
			$price    = $product->get_price();
			$status   = $product->is_in_stock() ? 'available' : 'sold';
			$slug     = get_post_field('post_name', get_the_ID());
			$add_to_cart_url = ($product->is_purchasable() && $product->is_in_stock())
				? $product->add_to_cart_url()
				: '';

			$img_full = $img_id
				? wp_get_attachment_image_url($img_id, 'large')
				: $img_url;
		?>
		<div class="col-12 col-sm-6 col-md-4 col-lg-3 product-card">
			<div class="card border-0 shadow-sm artwork-card"
				 role="button"
				 tabindex="0"
				 aria-haspopup="dialog"
				 data-bs-toggle="modal"
				 data-bs-target="#artworkModal"
				 data-title="<?php echo esc_attr($product->get_name()); ?>"
				 data-medium="<?php echo esc_attr($medium); ?>"
				 data-size="<?php echo esc_attr($size); ?>"
				 data-desc="<?php echo esc_attr(wp_strip_all_tags($desc)); ?>"
				 data-price="<?php echo esc_attr($price); ?>"
				 data-status="<?php echo esc_attr($status); ?>"
				 data-image="<?php echo esc_attr($img_full); ?>"
				 data-slug="<?php echo esc_attr($slug); ?>"
				 data-add-to-cart-url="<?php echo esc_url($add_to_cart_url); ?>">

				<img src="<?php echo esc_url($img_url); ?>"
					 alt="<?php echo esc_attr($img_alt); ?>"
					 class="card-img-top product-card-img"
					 loading="lazy">

				<div class="card-body text-center py-3">
					<p class="card-title h6 mb-1 fw-semibold"><?php echo esc_html($product->get_name()); ?></p>
					<?php if ($medium) : ?>
					<p class="mb-1 small text-muted"><?php echo esc_html($medium); ?></p>
					<?php endif; ?>
					<?php if ($status === 'sold') : ?>
						<span class="badge rounded-pill bg-secondary"><?php esc_html_e('Sold', 'clairs-art'); ?></span>
					<?php else : ?>
						<p class="mb-0 small text-terracotta"><?php echo wp_kses_post($product->get_price_html()); ?></p>
					<?php endif; ?>
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

<div class="modal fade" id="artworkModal" tabindex="-1" role="dialog" aria-labelledby="artworkModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content border-0 rounded-4 overflow-hidden">
			<button type="button" class="btn-close artwork-modal-close" data-bs-dismiss="modal" aria-label="<?php esc_attr_e('Close', 'clairs-art'); ?>"></button>
			<div class="row g-0">
				<div class="col-md-6">
					<img id="modal-image" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" alt="" class="artwork-modal-img">
				</div>
				<div class="col-md-6 p-4 p-lg-5 d-flex flex-column justify-content-center">
					<h2 id="artworkModalLabel" class="h4 mb-1">Artwork Detail</h2>
					<p id="modal-medium" class="text-muted small mb-1"></p>
					<p class="small mb-3"><span class="text-muted"><?php esc_html_e('Size:', 'clairs-art'); ?></span> <span id="modal-size"></span></p>
					<p id="modal-desc" class="mb-4"></p>
					<div id="modal-available">
						<p class="h5 text-terracotta mb-3" id="modal-price"></p>
						<div class="d-flex flex-wrap gap-2">
							<a id="modal-add-to-cart" href="#" class="btn btn-autumn flex-grow-1"><?php esc_html_e('Add to Cart', 'clairs-art'); ?></a>
							<a id="modal-enquire" href="#" class="btn btn-outline-autumn flex-grow-1"><?php esc_html_e('Enquire About This Piece', 'clairs-art'); ?></a>
						</div>
					</div>
					<div id="modal-sold" class="d-none">
						<span class="badge rounded-pill bg-secondary px-3 py-2"><?php esc_html_e('This piece has been sold', 'clairs-art'); ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
(function () {
	var contactUrl = <?php echo wp_json_encode(esc_url($contact_url)); ?>;
	var modal      = document.getElementById('artworkModal');

	modal.addEventListener('show.bs.modal', function (e) {
		var card = e.relatedTarget;

		document.getElementById('modal-image').src              = card.dataset.image;
		document.getElementById('modal-image').alt              = card.dataset.title + ' by Clair';
		document.getElementById('artworkModalLabel').textContent = card.dataset.title;
		document.getElementById('modal-medium').textContent     = card.dataset.medium;
		document.getElementById('modal-size').textContent       = card.dataset.size;
		document.getElementById('modal-desc').textContent       = card.dataset.desc;

		var avail = document.getElementById('modal-available');
		var sold  = document.getElementById('modal-sold');
		var addToCartButton = document.getElementById('modal-add-to-cart');

		if (card.dataset.status === 'available') {
			var addToCartUrl = card.dataset.addToCartUrl || '';
			document.getElementById('modal-price').textContent = '$' + card.dataset.price;
			addToCartButton.href = addToCartUrl || '#';
			addToCartButton.classList.toggle('d-none', !addToCartUrl);
			document.getElementById('modal-enquire').href      = contactUrl + '?art=' + encodeURIComponent(card.dataset.slug);
			avail.classList.remove('d-none');
			sold.classList.add('d-none');
		} else {
			addToCartButton.classList.add('d-none');
			avail.classList.add('d-none');
			sold.classList.remove('d-none');
		}
	});

	document.querySelectorAll('.artwork-card[data-bs-toggle="modal"]').forEach(function (card) {
		card.addEventListener('keydown', function (e) {
			if (e.key === 'Enter' || e.key === ' ') {
				e.preventDefault();
				card.click();
			}
		});
	});
}());
</script>

<?php get_footer(); ?>

