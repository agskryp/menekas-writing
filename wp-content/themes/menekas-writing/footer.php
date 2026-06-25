<footer id="colophon" class="site-footer">
	<div class="site-info">
		Menaka's Writing &copy; <?php echo get_the_date( 'Y' ); ?> Menaka Skrypnyk.  All rights reserved.
		<span class="sep"> | </span>
		<?php
			printf( 
				esc_html__( 'Site by %1$s', 'menekas-writing' ), 
				'<a href="https://www.agskryp.com">a.g.skryp</a>' 
			);
		?>
	</div>
</footer>

</div>

<?php wp_footer(); ?>

</body>

</html>
