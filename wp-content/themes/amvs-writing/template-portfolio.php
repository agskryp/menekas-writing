<?php
	/**
	 * Template Name: Portfolio template
	 */

	$portfolio_posts = new WP_Query( array(
		'post_type'      => 'portfolio',
		'posts_per_page' => -1,
		'post_status'    => 'publish',
		'orderby'        => 'title',
		'order'          => 'ASC',
	) );

	$portfolio_post_ids 	= wp_list_pluck( $portfolio_posts -> posts, 'ID' );
	$portfolio_categories = array();

	if ( $portfolio_post_ids ) {
		$portfolio_categories = get_terms( array(
			'taxonomy'   => 'category',
			'hide_empty' => true,
			'object_ids' => $portfolio_post_ids,
			'orderby'    => 'name',
			'order'      => 'ASC',
		) );
	}

	get_header();
?>	
	<main id="primary" class="main-container amvs-portfolio-container">
		<?php
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
		?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="entry-content text-center">
					<?php 
						echo '<h1>' . get_the_title() . '</h1>'; 
						
						the_content(); 
					?>
				</div>
		<?php 
				} 
			}
		?>

		<div class="portfolio-list-filter">
			<nav
				class="container container-center"
				aria-label="<?php esc_attr_e( 'Portfolio Categories', 'amvs-writing' ); ?>"
			>
				<ul>
					<li>
						<span><?php esc_html_e( 'Filter by:', 'amvs-writing' ); ?></span>
					</li>
					<li>
						<a href="<?php echo esc_url( home_url( '/portfolio/' ) ); ?>" data-filter="*">
							<?php esc_html_e( 'All', 'amvs-writing' ); ?>
						</a>
					</li>
								
					<?php 
						if( !empty( $portfolio_categories ) && !is_wp_error( $portfolio_categories ) ) { 
							foreach( $portfolio_categories as $portfolio_category ) { 
					?>
						<li>
							<a
								href="<?= esc_url( home_url( '/portfolio/' . $portfolio_category -> slug . '/' ) ); ?>"
								data-filter=".portfolio-category-<?php echo esc_attr( sanitize_html_class( $portfolio_category -> slug ) ); ?>"
							>
								<?php echo esc_html( $portfolio_category->name ); ?>
							</a>
						</li>
					<?php 
							} 
						}
					?>
				</ul>
			</nav>
		</div>

			<div class="container portfolio-list-grid">
				<?php 
					if( $portfolio_posts -> have_posts() ) {
					while( $portfolio_posts -> have_posts() ) { 
						$portfolio_posts -> the_post();

						$post_id = get_the_ID();
							
						$portfolio_item_categories = get_the_terms( $post_id, 'category' );
						$portfolio_item_names 		 = array();
						$portfolio_item_classes 	 = array( 'grid-item' );
						$published_url 				 		 = get_post_meta( $post_id, 'amvs_published_url', true );
						$live_page 						 		 = get_post_meta( $post_id, 'amvs_live_page', true );
						$portfolio_item_url 		 	 = get_permalink();
						$portfolio_item_target 	 	 = '';
						$portfolio_item_rel 		 	 = '';

						if( !empty( $published_url ) && 'yes' === $live_page ) {
							$portfolio_item_url 	 = $published_url;
							$portfolio_item_target = '_blank';
							$portfolio_item_rel 	 = 'noopener';
						}

						if( !empty( $portfolio_item_categories ) && !is_wp_error( $portfolio_item_categories ) ) {
							foreach ( $portfolio_item_categories as $portfolio_item_category ) {
								$portfolio_item_classes[] = 'portfolio-category-' . sanitize_html_class( 
									$portfolio_item_category -> slug 
								);

								$portfolio_item_names[] = esc_html( $portfolio_item_category -> name );
							}
						}
			?>
				<article class="<?php echo esc_attr( implode( ' ', $portfolio_item_classes ) ); ?>">
					<a
						href="<?php echo esc_url( $portfolio_item_url ); ?>"
						<?php 
							echo !empty( $portfolio_item_target ) 
								? 'target="' . esc_attr( $portfolio_item_target ) . '"' 
								: ''; 
								
							echo !empty( $portfolio_item_rel ) 
								? 'rel="' . esc_attr( $portfolio_item_rel ) . '"' 
								: ''; ?>
					>
						<header><?php the_title(); ?></header>
						
						<?php 
							if( has_post_thumbnail() ) {
								the_post_thumbnail( array( 280, 50 ) );
							}
						?>
						
						<small><?php echo esc_html( implode( ' | ', $portfolio_item_names ) ); ?></small>
					</a>
				</article>
			<?php 
					}
							
					wp_reset_postdata(); 
				}
			?>
		</div>
	</div>
</main>

<?php
	get_footer();
