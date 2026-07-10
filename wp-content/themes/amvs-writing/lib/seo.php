<?php
/**
 * Search engine visibility controls.
 */

function amvs_writing_is_blocked_sitemap_request() {
	$request_path = isset( $_SERVER['REQUEST_URI'] )
		? wp_parse_url( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ), PHP_URL_PATH )
		: '';

	return 1 === preg_match( '/^(author|category|post)-sitemap[0-9]*\.xml$/', ltrim( (string) $request_path, '/' ) );
}

function amvs_writing_block_unwanted_sitemaps() {
	if ( ! amvs_writing_is_blocked_sitemap_request() ) {
		return;
	}

	status_header( 404 );
	nocache_headers();
	exit;
}
add_action( 'template_redirect', 'amvs_writing_block_unwanted_sitemaps', -1 );

function amvs_writing_exclude_yoast_author_sitemap( $users ) {
	return array();
}
add_filter( 'wpseo_sitemap_exclude_author', 'amvs_writing_exclude_yoast_author_sitemap' );

function amvs_writing_exclude_yoast_post_sitemap( $exclude, $post_type ) {
	if ( 'post' === $post_type ) {
		return true;
	}

	return $exclude;
}
add_filter( 'wpseo_sitemap_exclude_post_type', 'amvs_writing_exclude_yoast_post_sitemap', 10, 2 );

function amvs_writing_exclude_yoast_category_sitemap( $exclude, $taxonomy ) {
	if ( 'category' === $taxonomy ) {
		return true;
	}

	return $exclude;
}
add_filter( 'wpseo_sitemap_exclude_taxonomy', 'amvs_writing_exclude_yoast_category_sitemap', 10, 2 );

function amvs_writing_remove_unwanted_yoast_sitemap_index_links( $links ) {
	return array_values(
		array_filter(
			$links,
			function( $link ) {
				if ( empty( $link['loc'] ) ) {
					return true;
				}

				$path = wp_parse_url( $link['loc'], PHP_URL_PATH );

				return ! preg_match( '/\/(author|category|post)-sitemap[0-9]*\.xml$/', (string) $path );
			}
		)
	);
}
add_filter( 'wpseo_sitemap_index_links', 'amvs_writing_remove_unwanted_yoast_sitemap_index_links' );

function amvs_writing_is_portfolio_category_archive_request() {
	return 'portfolio' === get_query_var( 'post_type' ) && '' !== get_query_var( 'category_name' );
}

function amvs_writing_block_unwanted_archives() {
	if ( ! is_author() && ! is_category() && ! amvs_writing_is_portfolio_category_archive_request() ) {
		return;
	}

	global $wp_query;

	$wp_query->set_404();
	status_header( 404 );
	nocache_headers();
}
add_action( 'template_redirect', 'amvs_writing_block_unwanted_archives', 1 );

function amvs_writing_noindex_unwanted_archives( $robots ) {
	if ( ! is_author() && ! is_category() && ! amvs_writing_is_portfolio_category_archive_request() ) {
		return $robots;
	}

	$robots['index'] = 'noindex';
	$robots['follow'] = 'nofollow';

	return $robots;
}
add_filter( 'wpseo_robots_array', 'amvs_writing_noindex_unwanted_archives' );
