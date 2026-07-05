<?php
	$resume_pdf = wp_get_attachment_url( absint( amvs_writings_site_options( 'resume_pdf_id' ) ) );
?>

<footer class="site-footer">
	<nav class="footer-nav container">
		<ul>
			<?php if ( $resume_pdf ) { ?>
				<li>
					<a href="<?php echo esc_url( $resume_pdf ); ?>" target="_blank" rel="noopener" download>
						<?php esc_html_e( 'View Resume', 'amvs-writing' ); ?>
					</a>
				</li>
			<?php } ?>
			
			<li>
				<a href="#" data-open-modal="contact-modal" aria-haspopup="dialog">Contact Me</a>
			</li>
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
