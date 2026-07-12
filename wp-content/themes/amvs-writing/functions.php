<?php

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function amvs_writing_setup() {	
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array(
		'gallery',
		'caption',
		'style',
		'script',
	) );

	add_theme_support( 'custom-logo', array(
		'height'      => 250,
		'width'       => 250,
		'flex-width'  => true,
		'flex-height' => true,
	) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'amvs-writing' ),
	) );
}
add_action( 'after_setup_theme', 'amvs_writing_setup' );

include_once get_template_directory() . '/lib/contact-form.php';
include_once get_template_directory() . '/lib/metaboxes.php';
include_once get_template_directory() . '/lib/post-type.php';
include_once get_template_directory() . '/lib/seo.php';
include_once get_template_directory() . '/lib/scripts.php';
include_once get_template_directory() . '/lib/shortcodes.php';
include_once get_template_directory() . '/lib/site-options.php';
