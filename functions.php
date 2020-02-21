<?php

namespace Aconcagua_Theme;

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
	set_post_thumbnail_size( 1200, 9999 );

	add_theme_support( 'title-tag' );

	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' )
	);

	add_theme_support( 'align-wide' );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\theme_support' );

/**
 * Register and enqueue styles.
 */
function register_styles() {
	$version = filemtime( __DIR__ . '/style.css' );
	wp_enqueue_style( 'aconcagua-style', get_stylesheet_uri(), array(), $version );
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\register_styles' );


/**
 * Block editor settings.
 * Add custom colors to the block editor.
 */
function block_editor_settings() {
	// add_theme_support( 'editor-color-palette', array() );
	// add_theme_support( '__experimental-editor-gradient-presets', array() );
	// Update ^ colors when we have them.
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\block_editor_settings' );
