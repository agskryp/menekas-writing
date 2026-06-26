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

				<nav
					aria-label="Portfolio Categories"
					style="--pico-nav-breadcrumb-divider: '|';"
				>
					<ul>
						<li><a href="#">All</a></li>
						<li><a href="#">Articles</a></li>
						<li><a href="#">Blogs</a></li>
						<li><a href="#">Interviews</a></li>
					</ul>
				</nav>
			</div>
		<?php 
				} 
			}
		?>
	</main>
<?php
	get_footer();
