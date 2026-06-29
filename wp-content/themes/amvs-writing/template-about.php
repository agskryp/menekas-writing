<?php
	/**
	 * Template Name: About template
	 */

	get_header();
?>	

<main id="primary" class="site-main">
	<?php
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
	?>
		<div id="post-<?php the_ID(); ?>" <?php post_class( 'container grid' ); ?> >
			<div class="photo-content">
				<div class="polaroid-container" id="carousel">
						<div class="polaroid active">
							<img src="https://images.pdimagearchive.org/collections/colour-analysis-charts-by-emily-noyes-vanderpoel-1902/25786948976_e3653c309f_o.jpg" alt="Card 1">
							<div class="caption">Colour Analysis 1902</div>
						</div>
						<div class="polaroid">
							<img src="https://images.pdimagearchive.org/collections/hartlieb-book-of-herbs/book-of-herbs-51.jpg" alt="Card 2">
							<div class="caption">Book of Herbs '51</div>
						</div>
					
						<div class="polaroid">
							<img src="https://images.pdimagearchive.org/collections/schachtzabel-pigeons/schachtzabel-0045.jpg" alt="Card 3">
							<div class="caption">Schachtzabel Pigeons</div>
						</div>
					
						<div class="polaroid">
							<img src="https://images.pdimagearchive.org/collections/examples-of-chinese-ornament-1867/ExamplesChinese00Jone_0131-edit.jpeg" alt="Card 4">
							<div class="caption">Chinese Ornament 1867</div>
						</div>
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
