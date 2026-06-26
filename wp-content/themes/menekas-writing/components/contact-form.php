<?php
$contact_form_recaptcha = function_exists( 'menekas_writing_contact_recaptcha_enabled' ) && menekas_writing_contact_recaptcha_enabled();
$contact_form_site_key  = function_exists( 'menekas_writing_contact_recaptcha_site_key' ) ? menekas_writing_contact_recaptcha_site_key() : '';
?>

<?php if ( $contact_form_recaptcha ) { ?>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php } ?>

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

		<form id="contact-form" method="post" data-contact-form>
			<?php wp_nonce_field( 'menekas_contact_form', 'menekas_contact_nonce' ); ?>
			<input type="hidden" name="action" value="menekas_contact_form">

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
				<button
					type="submit"
					<?php if ( $contact_form_recaptcha ) { ?>
						class="g-recaptcha"
						data-sitekey="<?php echo esc_attr( $contact_form_site_key ); ?>"
						data-callback="menekasWritingSubmitContactForm"
						data-size="invisible"
					<?php } ?>
				>
					<?php esc_html_e( 'Send', 'menekas-writing' ); ?>
				</button>
			</footer>
		</form>

		<p role="alert" data-contact-form-status hidden></p>
	</article>
</dialog>
