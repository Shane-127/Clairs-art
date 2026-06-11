<?php
defined('ABSPATH') || exit;

function clairs_art_setup() {
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support('custom-logo', [
		'height'      => 82,
		'width'       => 300,
		'flex-height' => true,
		'flex-width'  => true,
	]);
	add_theme_support('html5', [
		'comment-form', 'comment-list',
		'gallery', 'caption', 'navigation-widgets',
	]);

	add_theme_support('woocommerce', [
		'thumbnail_image_width'         => 400,
		'gallery_thumbnail_image_width' => 100,
		'single_image_width'            => 800,
	]);
	add_theme_support('wc-product-gallery-zoom');
	add_theme_support('wc-product-gallery-lightbox');
	add_theme_support('wc-product-gallery-slider');

	register_nav_menus(['primary' => __('Primary Menu', 'clairs-art')]);
}
add_action('after_setup_theme', 'clairs_art_setup');

function clairs_art_scripts() {
	$theme_uri = get_template_directory_uri();
	wp_enqueue_style('bootstrap', $theme_uri . '/assets/css/bootstrap.min.css', [], '5.3.8');
	wp_enqueue_style('clairs-art-style', get_stylesheet_uri(), ['bootstrap'], '1.0.0');
	wp_enqueue_script('bootstrap', $theme_uri . '/assets/js/bootstrap.bundle.min.js', [], '5.3.8', true);
}
add_action('wp_enqueue_scripts', 'clairs_art_scripts');

function clairs_art_quick_view_label() {
	$label = get_option('yith-wcqv-button-label') ?: 'Quick View';
	$label = __($label, 'yith-woocommerce-quick-view');
	return apply_filters('yith_wcqv_button_label', esc_html($label));
}

function clairs_art_logo_url() {
	$logo_url = wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full');
	if ($logo_url) {
		return $logo_url;
	}

	return get_template_directory_uri() . '/assets/images/clairs-art-logo.png';
}

function clairs_art_artwork_card_data($product) {
	$product_id = $product->get_id();
	$product_name = $product->get_name();
	$image_id = $product->get_image_id();
	$image_url = $image_id ? wp_get_attachment_image_url($image_id, 'large') : wc_placeholder_img_src();
	$image_alt = $image_id ? (get_post_meta($image_id, '_wp_attachment_image_alt', true) ?: $product_name) : $product_name;

	return [
		'title'           => $product_name,
		'medium'          => get_post_meta($product_id, '_artwork_medium', true),
		'price_html'      => $product->get_price_html(),
		'status'          => $product->is_in_stock() ? 'available' : 'sold',
		'image'           => $image_url,
		'image_alt'       => $image_alt,
	];
}
