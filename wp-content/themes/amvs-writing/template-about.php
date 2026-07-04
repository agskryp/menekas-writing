<?php
	/**
	 * Template Name: About template
	 */

	$photo_items = get_post_meta( get_the_ID(), 'amvs_portfolio_template_items', true );

	get_header();
?>	

<main id="primary" class="main-container">
	<?php
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
	?>
		<div id="post-<?php the_ID(); ?>" <?php post_class( 'container grid' ); ?> >
			<div class="photo-content">
				<div class="polaroid-container" id="carousel">
					<?php
						if( !empty( $photo_items ) && is_array( $photo_items ) ) {
							foreach ( $photo_items as $photo_index => $photo_item ) {
								$photo_caption  = !empty( $photo_item[ 'text' ] ) ? $photo_item[ 'text' ] : '';
								$photo_image_id = 
									!empty( $photo_item[ 'image_id' ] ) ? absint( $photo_item[ 'image_id' ] ) : 0;
					?>
						<div class="polaroid<?php echo 0 === $photo_index ? ' active' : ''; ?>">
							<?php
								if( $photo_image_id ) {
									echo wp_get_attachment_image(
										$photo_image_id, array( 306, 362 ), false, array( 'alt' => $photo_caption )
									);
								} 
							
								if ( $photo_caption ) { 
							?>
								<div class="caption"><?php echo esc_html( $photo_caption ); ?></div>
							<?php } ?>
						</div>
					<?php
							}
						}
					?>
				</div>
			</div>

			<div class="entry-content text-center">
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
