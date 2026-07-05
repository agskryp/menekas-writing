<?php
	/**
	 * The template for displaying all portfolio posts
	 */

	$notes_on_article = get_post_meta( get_the_ID(), 'amvs_portfolio_notes_on_article_content', true );

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
			}
		?>
	</div>
</main>

<?php
	get_footer();
