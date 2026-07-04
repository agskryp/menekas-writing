<?php
/**
 * Register page metaboxes.
 */

function amvs_writing_register_about_template_metabox() {
	$about_template_metabox = new_cmb2_box( array(
		'id'           => 'amvs_about_template_metabox',
		'title'        => esc_html__( 'Photos', 'amvs-writing' ),
		'object_types' => array( 'page' ),
		'context'      => 'normal',
		'priority'     => 'default',
		'show_on'      => array( 
			'key'   => 'page-template',
			'value' => 'template-about.php'
		),
	) );

	$photo_group_id = $about_template_metabox->add_field( array(
		'id'          => 'amvs_portfolio_template_items',
		'type'        => 'group',
		'description' => 
			esc_html__( 
				'Add personalized photos to your page.  Recommend a minimum of 3 photos.', 'amvs-writing' 
			),
		'options'     => array(
			'group_title'   => esc_html__( 'Photo {#}', 'amvs-writing' ),
			'add_button'    => esc_html__( 'Add Photo', 'amvs-writing' ),
			'remove_button' => esc_html__( 'Remove Photo', 'amvs-writing' ),
			'sortable'      => true,
			'closed'        => true,
		),
	) );

	$about_template_metabox->add_group_field( $photo_group_id, array(
		'name'         => esc_html__( 'Image', 'amvs-writing' ),
		'id'           => 'image',
		'type'         => 'file',
		'query_args'   => array(
			'type' => 'image',
		),
		'preview_size' => 'medium',
	) );

	$about_template_metabox->add_group_field( $photo_group_id, array(
		'name' => esc_html__( 'Text', 'amvs-writing' ),
		'id'   => 'text',
		'type' => 'text_medium',
	) );
}
add_action( 'cmb2_admin_init', 'amvs_writing_register_about_template_metabox' );
