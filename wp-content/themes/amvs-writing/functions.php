<?php

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function amvs_writing_setup() {

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'amvs-writing' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);



	// Add theme support for selective refresh for widgets.
	// add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'amvs_writing_setup' );

include_once get_template_directory() . '/lib/scripts.php';
include_once get_template_directory() . '/lib/contact-form.php';
include_once get_template_directory() . '/lib/post-type.php';

function amvs_writing_typed_categories_shortcode() {
	$portfolio_posts = get_posts(	array(
		'post_type'      => 'portfolio',
		'posts_per_page' => -1,
		'post_status'    => 'publish',
		'fields'         => 'ids',
	) );

	if ( empty( $portfolio_posts ) ) {
		return '';
	}

	$portfolio_categories = get_terms( array(
		'taxonomy'   => 'category',
		'hide_empty' => true,
		'object_ids' => $portfolio_posts,
		'orderby'    => 'name',
		'order'      => 'ASC',
	) );

	if ( empty( $portfolio_categories ) || is_wp_error( $portfolio_categories ) ) {
		return '';
	}

	$output = '<span id="typed-strings">';

	foreach ( $portfolio_categories as $portfolio_category ) {
		$output .= '<span>' . esc_html( $portfolio_category->name ) . '</span>';
	}

	$output .= '</span>';
	$output .= '<span class="element"></span>';

	return $output;
}
add_shortcode( 'typed_categories', 'amvs_writing_typed_categories_shortcode' );
