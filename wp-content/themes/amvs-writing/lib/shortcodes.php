<?php

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
