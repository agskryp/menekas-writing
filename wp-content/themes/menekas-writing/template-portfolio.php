<?php
	/**
	 * Template Name: Portfolio template
	 */

	get_header();
?>	
	<main id="primary" class="site-main">
		<?php
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
		?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
				<div class="entry-content text-center">
					<?php echo '<h1>' . get_the_title() . '</h1>'; ?>
					<?php the_content(); ?>
				</div>

					<?php
						$portfolio_posts = new WP_Query(
							array(
								'post_type'      => 'portfolio',
								'posts_per_page' => -1,
								'post_status'    => 'publish',
								'orderby'        => 'title',
								'order'          => 'ASC',
							)
						);

						$portfolio_post_ids = wp_list_pluck( $portfolio_posts->posts, 'ID' );
						$portfolio_categories = array();

						if ( $portfolio_post_ids ) {
							$portfolio_categories = get_terms(
								array(
									'taxonomy'   => 'category',
									'hide_empty' => true,
									'object_ids' => $portfolio_post_ids,
									'orderby'    => 'name',
									'order'      => 'ASC',
								)
							);
						}
					?>

					<nav
						aria-label="Portfolio Categories"
						style="--pico-nav-breadcrumb-divider: '|';"
					>
						<ul>
							<li>
								<a href="<?php echo esc_url( home_url( '/portfolio/' ) ); ?>" data-filter="*">
									<?php esc_html_e( 'All', 'amvs-writing' ); ?>
								</a>
							</li>
							<?php if ( ! empty( $portfolio_categories ) && ! is_wp_error( $portfolio_categories ) ) { ?>
								<?php foreach ( $portfolio_categories as $portfolio_category ) { ?>
									<li>
										<a
											href="<?php echo esc_url( home_url( '/portfolio/' . $portfolio_category->slug . '/' ) ); ?>"
											data-filter=".portfolio-category-<?php echo esc_attr( sanitize_html_class( $portfolio_category->slug ) ); ?>"
										>
											<?php echo esc_html( $portfolio_category->name ); ?>
										</a>
									</li>
								<?php } ?>
							<?php } ?>
						</ul>
					</nav>

					<div class="grid">
						<?php if ( $portfolio_posts->have_posts() ) { ?>
							<?php while ( $portfolio_posts->have_posts() ) { ?>
								<?php
									$portfolio_posts->the_post();
									$portfolio_item_categories = get_the_terms( get_the_ID(), 'category' );
									$portfolio_item_classes = array( 'grid-item' );

									if ( ! empty( $portfolio_item_categories ) && ! is_wp_error( $portfolio_item_categories ) ) {
										foreach ( $portfolio_item_categories as $portfolio_item_category ) {
											$portfolio_item_classes[] = 'portfolio-category-' . sanitize_html_class( $portfolio_item_category->slug );
										}
									}
								?>
								<article class="<?php echo esc_attr( implode( ' ', $portfolio_item_classes ) ); ?>">
									<a href="<?php the_permalink(); ?>">
										<?php the_title(); ?>
									</a>
								</article>
							<?php } ?>
							<?php wp_reset_postdata(); ?>
						<?php } ?>
					</div>
			</div>
		<?php 
				} 
			}
		?>
	</main>
<?php
	get_footer();
