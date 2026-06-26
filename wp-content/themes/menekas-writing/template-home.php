<?php
/**
 * Template Name: Home template
 */

$home_template_background = get_the_post_thumbnail_url( get_the_ID(), 'full' );

add_filter(
	'body_class',
	function( $classes ) {
		$classes[] = 'home-template-page';

		return $classes;
	}
);

get_header();
?>

<?php if ( $home_template_background ) { ?>
	<style>
		.home-template-page .site {
			background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('<?php echo esc_url( $home_template_background ); ?>');
		}
	</style>
<?php } ?>

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
</main>

<?php
	get_footer();
