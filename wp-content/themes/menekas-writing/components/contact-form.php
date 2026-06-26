
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
