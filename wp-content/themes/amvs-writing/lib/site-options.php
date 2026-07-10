<?php
/**
 * Register site options.
 */

function amvs_writings_register_site_options() {
	$site_options = new_cmb2_box( array(
		'id'           => 'amvs_writings_site_options_metabox',
		'title'        => esc_html__( 'Site Options', 'amvs-writing' ),
		'object_types' => array( 'options-page' ),
		'option_key'   => 'amvs_writings_site_options',
	) );

	$site_options -> add_field( array(
		'name'       => esc_html__( 'Resume PDF', 'amvs-writing' ),
		'id'         => 'resume_pdf',
		'type'       => 'file',
		'query_args' => array(
			'type' => 'application/pdf',
		),
		'options'    => array(
			'url' => false,
		),
	) );

	$site_options -> add_field( array(
		'name' => esc_html__( 'LinkedIn Profile URL', 'amvs-writing' ),
		'id'   => 'linkedin_url',
		'type' => 'text_url',
	) );

	$site_options -> add_field( array(
		'name'       => esc_html__( 'Typed Categories', 'amvs-writing' ),
		'desc'       => esc_html__( 'Add each word or phrase to display in the typed categories shortcode.', 'amvs-writing' ),
		'id'         => 'typed_categories',
		'type'       => 'text',
		'repeatable' => true,
	) );
}
add_action( 'cmb2_admin_init', 'amvs_writings_register_site_options' );

/**
 * Wrapper function around cmb2_get_option.
 *
 * @since  0.1.0
 * @param  string $key     Options array key.
 * @param  mixed  $default Optional default value.
 * @return mixed           Option value.
 */
function amvs_writings_site_options( $key = '', $default = false ) {
	if ( function_exists( 'cmb2_get_option' ) ) {
		return cmb2_get_option( 'amvs_writings_site_options', $key, $default );
	}

	$opts = get_option( 'amvs_writings_site_options', $default );
	$val  = $default;

	if ( 'all' === $key ) {
		$val = $opts;
	} elseif ( is_array( $opts ) && array_key_exists( $key, $opts ) && false !== $opts[ $key ] ) {
		$val = $opts[ $key ];
	}

	return $val;
}
