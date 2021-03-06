<?php

namespace Aconcagua_Theme;
use WP_Block_Type_Registry;

/**
 * Set up theme supports.
 */
function theme_support() {
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Set content-width.
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 926;
	}

	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1282, 9999 );

	add_theme_support( 'title-tag' );

	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' )
	);

	add_theme_support( 'align-wide' );

	add_theme_support( 'editor-styles' );
	add_theme_support( 'wp-block-styles' );
	add_editor_style();
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\theme_support' );

/**
 * Register and enqueue assets.
 */
function register_assets() {
	$version = filemtime( __DIR__ . '/style.css' );

	$font_families[] = 'Arimo:400,400i,700';
	$query_args = array(
		'family' => urlencode( implode( '|', $font_families ) ),
		'subset' => urlencode( 'latin,latin-ext' ),
		'display' => 'swap',
	);
	$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

	wp_enqueue_style( 'aconcagua-font', esc_url_raw( $fonts_url ), array(), 1 );
	wp_enqueue_style( 'aconcagua-style', get_stylesheet_uri(), array( 'aconcagua-font' ), $version );

	wp_enqueue_script(
		'aconcagua-script',
		get_template_directory_uri() . '/js/script.js',
		array(),
		filemtime( __DIR__ . '/js/script.js' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\register_assets' );


/**
 * Block editor settings.
 * Add custom colors to the block editor.
 */
function block_editor_settings() {
	add_theme_support(
		'editor-color-palette',
		array(
			array(
				'name'  => esc_html_x( 'Black', 'block color', 'aconcagua' ),
				'slug'  => 'black',
				'color' => '#2c3642',
			),
			array(
				'name'  => esc_html_x( 'Grey', 'block color', 'aconcagua' ),
				'slug'  => 'grey',
				'color' => '#73859b',
			),
			array(
				'name'  => esc_html_x( 'Light Grey', 'block color', 'aconcagua' ),
				'slug'  => 'light-grey',
				'color' => '#e5e8ed',
			),
		)
	);
	// add_theme_support( '__experimental-editor-gradient-presets', array() );
	// Update gradients when we have more colors.

	// Add theme support for font sizes.
	add_theme_support(
		'editor-font-sizes',
		array(
			array(
				'name' => esc_html_x( 'Small', 'block font size', 'aconcagua' ),
				'size' => 18,
				'slug' => 'small',
			),
			array(
				'name' => esc_html_x( 'Normal', 'block font size', 'aconcagua' ),
				'size' => 22,
				'slug' => 'normal',
			),
			array(
				'name' => esc_html_x( 'Medium', 'block font size', 'aconcagua' ),
				'size' => 28,
				'slug' => 'medium',
			),
			array(
				'name' => esc_html_x( 'Large', 'block font size', 'aconcagua' ),
				'size' => 38,
				'slug' => 'large',
			),
			array(
				'name' => esc_html_x( 'Huge', 'block font size', 'aconcagua' ),
				'size' => 52,
				'slug' => 'huge',
			),
		)
	);
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\block_editor_settings' );

/**
 * Filters the content of a single block.
 *
 * @since 5.0.0
 *
 * @param string $block_content The block content about to be appended.
 * @param array  $block         The full block, including name and attributes.
 */
function render_block_tweaks( $block_content, $block ) {
	if ( 'core/latest-posts' === $block['blockName'] ) {
		$replacements = array(
			'"></div>' => '"></div><div class="wp-block-latest-posts__content">',
			'<li><a' => '<li><div class="wp-block-latest-posts__content"><a',
			'</li>' => '</div></li>',
		);
		$block_content = str_replace(
			array_keys( $replacements ),
			array_values( $replacements ),
			$block_content
		);
	}
	return $block_content;
}
add_filter( 'render_block', __NAMESPACE__ . '\render_block_tweaks', 10, 2 );
