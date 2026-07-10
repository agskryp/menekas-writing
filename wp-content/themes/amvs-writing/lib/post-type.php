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

	add_rewrite_rule(
		'^portfolio/([^/]+)/?$',
		'index.php?post_type=portfolio&category_name=$matches[1]',
		'top'
	);
}
add_action( 'init', 'amvs_writing_register_portfolio_post_type' );



function amvs_writing_register_portfolio_metabox() {
	$portfolio_metabox = new_cmb2_box( array(
		'id'               => 'amvs_writing_metabox',
		'title'            => esc_html__( 'Item Details', 'amvs-writing' ),
		'object_types'     => array( 'portfolio' ),
		'context'          => 'normal',
		'priority'         => 'default',
		'mb_callback_args' => array(
			'__block_editor_compatible_meta_box' => true,
			'__back_compat_meta_box'             => false,
		),
	) );

	$portfolio_metabox -> add_field( array(
		'name' => esc_html__( 'Published URL', 'amvs-writing' ),
		'desc' => 
			'Enter the URL this writing is published on to have this item go directly to the source.  <br />Leave this field blank and put the URL in the \'Notes on the article\' field to reference the source, but publish the content of this item.',
		'id'   => 'amvs_published_url',
		'type' => 'text_url',
	) );

	$portfolio_metabox -> add_field( array(
		'id'          => 'amvs_portfolio_notes_on_article_content',
		'type'        => 'wysiwyg',
		'name'         => esc_html__( 'Notes on the article', 'amvs-writing' ),
		'description' => 
			esc_html__( 
				'Add additional information on the article (date of pubication, client who it was for, platform it was posted to, etc.).  This will display at the end of posts on your site.', 'amvs-writing' 
			),
		'options'     => array(
			'media_buttons' => false,
			'quicktags'     => true,
			'textarea_rows' => 5,
			'tinymce'       => array(
				'block_formats' => 'Paragraph=p;',
				'toolbar1'      => 'formatselect,bold,italic,link,unlink',
				'toolbar2'      => '',
				'toolbar3'      => '',
			),
		),
	) );

	$portfolio_metabox -> add_field( array(
		'id'          => 'amvs_portfolio_article_transcript_content',
		'type'        => 'wysiwyg',
		'name'         => esc_html__( 'Article Transcript', 'amvs-writing' ),
		'description' => 
			esc_html__( 
				'Enter the text of the article if the original source is a screenshot or an image.', 'amvs-writing' 
			),
		'options'     => array(
			'media_buttons' => false,
			'quicktags'     => true,
			'textarea_rows' => 10,
			'tinymce'       => array(
				'block_formats' => 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4',
				'toolbar1'      => 'formatselect,bold,italic,link,unlink,alignleft,aligncenter,alignright',
				'toolbar2'      => '',
				'toolbar3'      => '',
			),
		),
	) );
}
add_action( 'cmb2_admin_init', 'amvs_writing_register_portfolio_metabox' );
