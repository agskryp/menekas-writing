<?php

function amvs_writing_typed_categories_shortcode() {
	$typed_categories = amvs_writings_site_options( 'typed_categories', array() );

	if ( empty( $typed_categories ) || ! is_array( $typed_categories ) ) {
		return '';
	}

	$typed_categories = array_filter( array_map( 'trim', $typed_categories ) );

	if ( empty( $typed_categories ) ) {
		return '';
	}

	$output = '<span id="typed-strings">';

	foreach ( $typed_categories as $typed_category ) {
		$output .= '<span>' . esc_html( $typed_category ) . '</span>';
	}

	$output .= '</span>';
	$output .= '<span class="element"></span>';

	return $output;
}
add_shortcode( 'typed_categories', 'amvs_writing_typed_categories_shortcode' );
