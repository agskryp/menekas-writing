<footer id="colophon" class="site-footer">
	<div class="site-info text-center">
		Menaka's Writing &copy; <?php echo get_the_date( 'Y' ); ?> Menaka Skrypnyk.  All rights reserved.
		<span class="sep"> | </span>
		<?php
			printf( 
				esc_html__( 'Site by %1$s', 'amvs-writing' ), 
				'<a href="https://www.agskryp.com" target="_blank" rel="noopener">A.G. Skryp</a>' 
			);
		?>
	</div>
</footer>

<?php get_template_part( 'components/contact-form' ); ?>

</div>

<?php wp_footer(); ?>

</body>

</html>
