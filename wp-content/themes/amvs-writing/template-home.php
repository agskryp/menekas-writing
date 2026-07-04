<?php
	/**
	 * Template Name: Home template
	 */

	$home_template_background = get_the_post_thumbnail_url( get_the_ID(), 'full' );

	get_header();
?>

<main id="primary" class="main-container">
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
				<h1 class="screen-reader-text"><?php bloginfo( 'name' ); ?></h1>
				<?php the_content(); ?>
			</div>
		</div>
	<?php
			}
		}
	?>

	<div style="width: 100%; height: 100vh; position: absolute; top: 0; left: 0;  z-index: -1; overflow: hidden;">
		<div style="background: rgba( 255, 245, 235, .9); width: 100vw; height: 100vh; position: absolute; top: 0; left: 0;">
		<img src="<?php echo $home_template_background; ?>" style="position: absolute; top: 0; left: 0; width: 100vw; height: 100vh; z-index: -2; object-fit: cover;" alt="" />
	</div>
</main>

<?php
	get_footer();
