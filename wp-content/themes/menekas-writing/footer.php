<footer id="colophon" class="site-footer">
	<div class="site-info text-center">
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

<dialog id="contact-modal">
	<article>
		<header>
			<button
				type="button"
				aria-label="<?php esc_attr_e( 'Close contact form', 'menekas-writing' ); ?>"
				rel="prev"
				data-close-modal
			></button>
			<h2><?php esc_html_e( 'Contact', 'menekas-writing' ); ?></h2>
		</header>

		<form method="post">
			<div class="grid">
				<label for="contact-name">
					<?php esc_html_e( 'Name', 'menekas-writing' ); ?>
					<input
						type="text"
						id="contact-name"
						name="contact_name"
						autocomplete="name"
						required
					>
				</label>

				<label for="contact-email">
					<?php esc_html_e( 'Email', 'menekas-writing' ); ?>
					<input
						type="email"
						id="contact-email"
						name="contact_email"
						autocomplete="email"
						required
					>
				</label>
			</div>

			<label for="contact-subject">
				<?php esc_html_e( 'Subject', 'menekas-writing' ); ?>
				<input
					type="text"
					id="contact-subject"
					name="contact_subject"
					required
				>
			</label>

			<label for="contact-message">
				<?php esc_html_e( 'Message', 'menekas-writing' ); ?>
				<textarea
					id="contact-message"
					name="contact_message"
					rows="5"
					required
				></textarea>
			</label>

			<footer>
				<button type="submit">
					<?php esc_html_e( 'Send', 'menekas-writing' ); ?>
				</button>
			</footer>
		</form>
	</article>
</dialog>

<script>
	( function() {
		const modal = document.getElementById( 'contact-modal' );

		if ( ! modal ) {
			return;
		}

		document.querySelectorAll( '[data-open-modal="contact-modal"]' ).forEach( function( button ) {
			button.addEventListener( 'click', function() {
				if ( typeof modal.showModal === 'function' ) {
					modal.showModal();
					return;
				}

				modal.setAttribute( 'open', '' );
			} );
		} );

		modal.querySelectorAll( '[data-close-modal]' ).forEach( function( button ) {
			button.addEventListener( 'click', function() {
				modal.close();
			} );
		} );

		modal.addEventListener( 'click', function( event ) {
			if ( event.target === modal ) {
				modal.close();
			}
		} );
	}() );
</script>

</div>

<?php wp_footer(); ?>

</body>

</html>
