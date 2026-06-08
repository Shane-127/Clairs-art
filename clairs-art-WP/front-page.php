<?php get_header(); ?>

<main id="primary" class="site-main">

<div class="site-hero text-center py-5">
	<div class="container">
		<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/clairs-art-logo.png'); ?>"
			 alt="<?php echo esc_attr(get_bloginfo('name')); ?> logo"
			 class="hero-logo mb-3">
		<p class="lead mb-4 text-gold">Original artwork by Clair</p>
		<?php $shop_url = class_exists('WooCommerce') ? wc_get_page_permalink('shop') : home_url('/gallery'); ?>
		<a href="<?php echo esc_url($shop_url); ?>" class="btn btn-autumn btn-lg px-5">Browse the Gallery</a>
	</div>
</div>

<section class="container my-5">
	<h2 class="section-title text-center">Latest Works</h2>

	<?php if (class_exists('WooCommerce')) :
		$products = wc_get_products([
			'limit'   => 8,
			'status'  => 'publish',
			'orderby' => 'date',
			'order'   => 'DESC',
		]);
		$contact_page = get_page_by_path('contact');
		$contact_url  = $contact_page ? get_permalink($contact_page) : home_url('/contact/');
	?>
	<?php if ($products) : ?>
	<div class="row g-4">
		<?php foreach ($products as $product) :
			$img_id   = $product->get_image_id();
			$img_url  = $img_id ? wp_get_attachment_image_url($img_id, 'large') : wc_placeholder_img_src();
			$img_full = $img_id ? wp_get_attachment_image_url($img_id, 'large') : $img_url;
			$img_alt  = $img_id
				? (get_post_meta($img_id, '_wp_attachment_image_alt', true) ?: $product->get_name())
				: $product->get_name();
			$medium = get_post_meta($product->get_id(), '_artwork_medium', true);
			$size   = get_post_meta($product->get_id(), '_artwork_size',   true);
			$desc   = $product->get_short_description() ?: '';
			$price  = $product->get_price();
			$status = $product->is_in_stock() ? 'available' : 'sold';
			$slug   = get_post_field('post_name', $product->get_id());
			$add_to_cart_url = ($product->is_purchasable() && $product->is_in_stock())
				? $product->add_to_cart_url()
				: '';
		?>
		<div class="col-6 col-md-4 col-lg-3 product-card">
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
		<?php endforeach; ?>
	</div>
	<?php else : ?>
	<p class="text-center text-muted"><?php esc_html_e('No artworks yet — check back soon!', 'clairs-art'); ?></p>
	<?php endif; ?>
	<?php endif; ?>

	<div class="text-center mt-5">
		<a href="<?php echo esc_url($shop_url); ?>" class="btn btn-autumn px-5">View All Works</a>
	</div>
</section>

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
	var contactUrl = <?php echo wp_json_encode(isset($contact_url) ? esc_url($contact_url) : home_url('/contact/')); ?>;
	var modal = document.getElementById('artworkModal');

	if (!modal) { return; }

	var fields = {
		image: document.getElementById('modal-image'),
		title: document.getElementById('artworkModalLabel'),
		medium: document.getElementById('modal-medium'),
		size: document.getElementById('modal-size'),
		desc: document.getElementById('modal-desc'),
		price: document.getElementById('modal-price'),
		available: document.getElementById('modal-available'),
		sold: document.getElementById('modal-sold'),
		addToCart: document.getElementById('modal-add-to-cart'),
		enquire: document.getElementById('modal-enquire')
	};

	modal.addEventListener('show.bs.modal', function (e) {
		var card = e.relatedTarget;
		var addToCartUrl = card.dataset.addToCartUrl || '';

		fields.image.src = card.dataset.image;
		fields.image.alt = card.dataset.title + ' by Clair';
		fields.title.textContent = card.dataset.title;
		fields.medium.textContent = card.dataset.medium;
		fields.size.textContent = card.dataset.size;
		fields.desc.textContent = card.dataset.desc;

		if (card.dataset.status === 'available') {
			fields.price.textContent = '$' + card.dataset.price;
			fields.addToCart.href = addToCartUrl || '#';
			fields.addToCart.classList.toggle('d-none', !addToCartUrl);
			fields.enquire.href = contactUrl + '?art=' + encodeURIComponent(card.dataset.slug);
			fields.available.classList.remove('d-none');
			fields.sold.classList.add('d-none');
		} else {
			fields.addToCart.classList.add('d-none');
			fields.available.classList.add('d-none');
			fields.sold.classList.remove('d-none');
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

<hr class="ca-divider">

<div class="bio-section py-5">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<h2 class="section-title">Meet Clair</h2>
				<?php
				$about_page = get_page_by_path('about');
				if ($about_page && $about_page->post_content) {
					$excerpt = $about_page->post_excerpt
						?: wp_trim_words(wp_strip_all_tags($about_page->post_content), 55);
					echo '<p>' . esc_html($excerpt) . '</p>';
				} else {
					echo '<p>Clair is a self-taught artist with Down Syndrome whose creativity is deeply rooted in connection, observation, and joy. From a young age, drawing has been her favourite way to express herself, and today she is developing her own unique interpretation of the people around her.</p>';
				}
				?>
				<?php if ($about_page) : ?>
				<a href="<?php echo esc_url(get_permalink($about_page)); ?>" class="btn btn-outline-autumn">Read More</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

</main>

<?php get_footer(); ?>
