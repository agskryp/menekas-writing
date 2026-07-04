<footer class="site-footer">
	<nav class="footer-nav container">
		<ul>
			<li><a href="#">View Resume</a></li>
			<li><a href="#">Contact Me</a></li>
		</ul>
	</nav>

	<div class="copyright-info container" style="">
		<small>Menaka's Writing &copy; <?php echo get_the_date( 'Y' ); ?> Menaka Skrypnyk.  All rights reserved.</small>

		<small>Site by <a href="https://www.agskryp.com" target="_blank" rel="noopener">A.G. Skryp</a></small>
	</div>

	<?php get_template_part( 'components/contact-form' ); ?>
</footer>

</div>

<?php wp_footer(); ?>

</body>

</html>
