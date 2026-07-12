<?php
	/**
	 * The template for displaying all portfolio posts
	 */

	$post_id = get_the_ID();

	$notes_on_article 	= get_post_meta( $post_id, 'amvs_portfolio_notes_on_article_content', true );
	$article_transcript = get_post_meta( $post_id, 'amvs_portfolio_article_transcript_content', true );
	$published_url			= get_post_meta( $post_id, 'amvs_published_url', true );

	if( !empty( $published_url ) ) {
		wp_safe_redirect( home_url( '/portfolio/' ) );
		exit;
	}

	get_header();
?>

<main id="primary" class="main-container portfolio-post-container">
	<div class="container">
		<?php
			while ( have_posts() ) {
				the_post();

				echo '<h1 class="text-center">' . get_the_title() . '</h1>';

				the_content();

				if( !empty( $notes_on_article ) ) {
					echo '<div class="notes-on-article">' . wp_kses_post( wpautop( $notes_on_article ) ) . '</div>';
				}

				if( !empty( $article_transcript ) ) {
					echo '<div class="article-transcript">' . wp_kses_post( wpautop( $article_transcript ) ) . '</div>';
				}
			}
		?>
	</div>
</main>

<?php
	get_footer();
