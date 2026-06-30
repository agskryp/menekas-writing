<?php
	/**
	 * The template for displaying all portfolio posts
	 */

	get_header();
?>

<main id="primary" class="main-container">
	<div class="container" style="text-align: justify; max-width: 768px;">
		<?php
			while ( have_posts() ) {
				the_post();

				echo '<h1 class="text-center">' . get_the_title() . '</h1>';

				the_content();
			}
		?>
	</div>
</main>

<?php
	get_footer();
