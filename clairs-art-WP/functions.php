<?php
defined('ABSPATH') || exit;

function clairs_art_setup() {
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support('html5', [
		'search-form', 'comment-form', 'comment-list',
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
	$dir = get_template_directory_uri();
	// Bootstrap 5.3.8 (local files) for layout and components.
	wp_enqueue_style(
		'bootstrap',
		$dir . '/assets/css/bootstrap.min.css',
		[],
		'5.3.8'
	);
	wp_enqueue_style(
		'clairs-art-style',
		get_stylesheet_uri(),
		['bootstrap'],
		'1.0.0'
	);
	wp_enqueue_script(
		'bootstrap',
		$dir . '/assets/js/bootstrap.bundle.min.js',
		[],
		'5.3.8',
		true
	);
}
add_action('wp_enqueue_scripts', 'clairs_art_scripts');

function clairs_art_menu_item_classes($classes, $item, $args, $depth) {
	if (!isset($args->theme_location) || 'primary' !== $args->theme_location) {
		return $classes;
	}

	$classes[] = 'nav-item';
	return array_unique($classes);
}
add_filter('nav_menu_css_class', 'clairs_art_menu_item_classes', 10, 4);

function clairs_art_menu_link_attributes($atts, $item, $args, $depth) {
	if (!isset($args->theme_location) || 'primary' !== $args->theme_location) {
		return $atts;
	}

	$item_classes = (array) ($item->classes ?? []);
	$is_current   = in_array('current-menu-item', $item_classes, true)
		|| in_array('current_page_item', $item_classes, true);

	$atts['class'] = trim(($atts['class'] ?? '') . ' nav-link' . ($is_current ? ' active' : ''));
	if ($is_current) {
		$atts['aria-current'] = 'page';
	}

	return $atts;
}
add_filter('nav_menu_link_attributes', 'clairs_art_menu_link_attributes', 10, 4);

function clairs_art_get_fallback_menu_links() {
	$shop_url     = class_exists('WooCommerce') ? wc_get_page_permalink('shop') : home_url('/gallery');
	$about_page   = get_page_by_path('about');
	$contact_page = get_page_by_path('contact');
	$links = [
		[
			'label' => __('Home', 'clairs-art'),
			'url'   => home_url('/'),
		],
		[
			'label' => __('Gallery', 'clairs-art'),
			'url'   => $shop_url,
		],
	];

	if ($about_page) {
		$links[] = [
			'label' => __('About', 'clairs-art'),
			'url'   => get_permalink($about_page),
		];
	}

	if ($contact_page) {
		$links[] = [
			'label' => __('Contact', 'clairs-art'),
			'url'   => get_permalink($contact_page),
		];
	}

	return $links;
}

function clairs_art_render_fallback_menu($ul_classes, $first_link_extra_class = '') {
	$links = clairs_art_get_fallback_menu_links();
	echo '<ul class="' . esc_attr($ul_classes) . '">';
	foreach ($links as $index => $link) {
		$link_classes = 'nav-link';
		if (0 === $index && $first_link_extra_class) {
			$link_classes .= ' ' . $first_link_extra_class;
		}
		echo '<li class="nav-item"><a class="' . esc_attr($link_classes) . '" href="' . esc_url($link['url']) . '">' . esc_html($link['label']) . '</a></li>';
	}
	echo '</ul>';
}

function clairs_art_fallback_menu() {
	clairs_art_render_fallback_menu('navbar-nav ms-auto');
}

function clairs_art_footer_fallback_menu() {
	clairs_art_render_fallback_menu('nav justify-content-center justify-content-md-start', 'ps-0');
}
