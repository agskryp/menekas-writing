<?php
	/**
	 * Template Name: Home template
	 */

	$home_template_background = get_the_post_thumbnail_url( get_the_ID(), 'full' );

	get_header();
?>

<main id="primary" class="site-main">
	<?php
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
	?>
		<div
			id="post-<?php the_ID(); ?>"
			<?php post_class( 'home-template-hero container-fluid grid' ); ?>
		>
			<div class="entry-content">
				<?php the_content(); ?>

				<div>
					<span id="typed-strings">
						<span>Hucky</span>
						<span>Chucky</span>
						<span>Lucky</span>
						<span>Bucky</span>
						</span>
					<span class="element"></span>
				</div>
			</div>
		</div>
	<?php
			}
		}
	?>

	<div style="width: 100vw; height: 100vh; position: absolute; top: 0; left: 0;  z-index: -1;">
		<div style="background: rgba( 0, 0, 0, .6); width: 100vw; height: 100vh; position: absolute; top: 0; left: 0;">
		<img src="<?php echo $home_template_background; ?>" style="position: absolute; top: 0; left: 0; width: 100vw; height: 100vh; z-index: -2; object-fit: cover;" alt="" />
	</div>
</main>

<?php
	get_footer();
