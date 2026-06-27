<?php
/**
 * Register custom post types.
 */

function amvs_writing_register_portfolio_post_type() {
	$labels = array(
		'name'                  => esc_html__( 'Portfolio', 'amvs-writing' ),
		'singular_name'         => esc_html__( 'Portfolio Item', 'amvs-writing' ),
		'menu_name'             => esc_html__( 'Portfolio', 'amvs-writing' ),
		'name_admin_bar'        => esc_html__( 'Portfolio Item', 'amvs-writing' ),
		'add_new'               => esc_html__( 'Add New', 'amvs-writing' ),
		'add_new_item'          => esc_html__( 'Add New Portfolio Item', 'amvs-writing' ),
		'new_item'              => esc_html__( 'New Portfolio Item', 'amvs-writing' ),
		'edit_item'             => esc_html__( 'Edit Portfolio Item', 'amvs-writing' ),
		'view_item'             => esc_html__( 'View Portfolio Item', 'amvs-writing' ),
		'all_items'             => esc_html__( 'All Portfolio Items', 'amvs-writing' ),
		'search_items'          => esc_html__( 'Search Portfolio', 'amvs-writing' ),
		'not_found'             => esc_html__( 'No portfolio items found.', 'amvs-writing' ),
		'not_found_in_trash'    => esc_html__( 'No portfolio items found in Trash.', 'amvs-writing' ),
		'featured_image'        => esc_html__( 'Portfolio Featured Image', 'amvs-writing' ),
		'set_featured_image'    => esc_html__( 'Set portfolio featured image', 'amvs-writing' ),
		'remove_featured_image' => esc_html__( 'Remove portfolio featured image', 'amvs-writing' ),
		'use_featured_image'    => esc_html__( 'Use as portfolio featured image', 'amvs-writing' ),
	);

	$args = array(
		'labels'       => $labels,
		'public'       => true,
		'has_archive'  => true,
		'menu_icon'    => 'dashicons-portfolio',
		'rewrite'      => array(
			'slug' => 'writing',
		),
		'show_in_rest' => true,
		'supports'     => array( 'title', 'editor', 'thumbnail' ),
		'taxonomies'   => array( 'category' ),
	);

	register_post_type( 'portfolio', $args );
}
add_action( 'init', 'amvs_writing_register_portfolio_post_type' );
