<?php
	/**
	 * The template for displaying all portfolio posts
	 */

	$notes_on_article = get_post_meta( get_the_ID(), 'amvs_portfolio_notes_on_article_content', true );

	get_header();
?>

<main id="primary" class="main-container">
	<div class="container" style="text-align: justify; max-width: 768px;">
		<?php
			while ( have_posts() ) {
				the_post();

				echo '<h1 class="text-center">' . get_the_title() . '</h1>';

				the_content();

				if( !empty( $notes_on_article ) ) {
					echo '<p class="notes-on-article">' . $notes_on_article . '</p>';
				}
			}
		?>
	</div>
</main>

<?php
	get_footer();
