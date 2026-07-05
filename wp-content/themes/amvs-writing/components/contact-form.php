<?php
	$contact_form_recaptcha = 
		function_exists( 'amvs_writing_contact_recaptcha_enabled' ) && amvs_writing_contact_recaptcha_enabled();
	
	$contact_form_site_key = 
		function_exists( 'amvs_writing_contact_recaptcha_site_key' ) 
			? amvs_writing_contact_recaptcha_site_key() 
			: '';

	if ( $contact_form_recaptcha ) { 
?>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php } ?>

<dialog id="contact-modal">
	<article class="contact-form-container">
		<header>
			<button
				type="button"
				aria-label="<?php esc_attr_e( 'Close contact form', 'amvs-writing' ); ?>"
				rel="prev"
				data-close-modal
			></button>
		
			<h2><?php esc_html_e( 'Let\'s Connect!', 'amvs-writing' ); ?></h2>
	</header>

		<form id="contact-form" method="post" data-contact-form>
			<?php wp_nonce_field( 'amvs_contact_form', 'amvs_contact_nonce' ); ?>
			
			<input type="hidden" name="action" value="amvs_contact_form">

			<div class="grid">
				<label for="contact-name">
					<?php esc_html_e( 'Name', 'amvs-writing' ); ?>
					<input
						type="text"
						id="contact-name"
						name="contact_name"
						autocomplete="name"
						required
					>
				</label>

				<label for="contact-email">
					<?php esc_html_e( 'Email', 'amvs-writing' ); ?>
					<input
						type="email"
						id="contact-email"
						name="contact_email"
						autocomplete="email"
						required
					>
				</label>
			</div>

			<label for="contact-message">
				<?php esc_html_e( 'Message', 'amvs-writing' ); ?>
				<textarea
					id="contact-message"
					name="contact_message"
					rows="5"
					required
				></textarea>
			</label>

			<footer>
				<button
					type="submit"
					<?php if ( $contact_form_recaptcha ) { ?>
						class="g-recaptcha"
						data-sitekey="<?php echo esc_attr( $contact_form_site_key ); ?>"
						data-callback="amvsWritingSubmitContactForm"
						data-size="invisible"
					<?php } ?>
				>
					<?php esc_html_e( 'Send', 'amvs-writing' ); ?>
				</button>
			</footer>
		</form>

		<p role="alert" data-contact-form-status hidden></p>
	</article>
</dialog>
