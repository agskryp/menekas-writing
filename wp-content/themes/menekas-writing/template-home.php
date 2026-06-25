<?php
	/**
	 * Template Name: Home template
	 */

	get_header();

	$home_template_background = get_the_post_thumbnail_url( get_the_ID(), 'full' );
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
				<?php if ( $home_template_background ) { ?>
					style="background-image: url('<?php echo esc_url( $home_template_background ); ?>');"
				<?php } ?>
			>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</div>
		<?php 
				} 
			}
		?>
	</main>
<?php
	get_footer();
