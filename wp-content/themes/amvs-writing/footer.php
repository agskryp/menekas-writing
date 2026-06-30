<footer class="site-footer">
	<nav class="container" style="justify-content: center;">
		<ul>
			<li><a href="#">View Resume</a></li>
			<li><a href="#">Contact Me</a></li>
		</ul>
	</nav>

	<div class="site-info container" style="display: flex; justify-content: space-between;">
		<small>Menaka's Writing &copy; <?php echo get_the_date( 'Y' ); ?> Menaka Skrypnyk. <br /> All rights reserved.</small>

		<small>Site by <a href="https://www.agskryp.com" target="_blank" rel="noopener">A.G. Skryp</a></small>
	</div>

	<?php get_template_part( 'components/contact-form' ); ?>
</footer>

</div>

<?php wp_footer(); ?>

</body>

</html>
