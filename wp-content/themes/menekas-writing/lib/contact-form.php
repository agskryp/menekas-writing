<?php
/**
 * Contact form handling.
 */

if ( ! function_exists( 'menekas_writing_contact_recaptcha_site_key' ) ) {
	function menekas_writing_contact_recaptcha_site_key() {
		return defined( 'MENEKAS_RECAPTCHA_SITE_KEY' ) ? MENEKAS_RECAPTCHA_SITE_KEY : '';
	}
}

if ( ! function_exists( 'menekas_writing_contact_recaptcha_secret_key' ) ) {
	function menekas_writing_contact_recaptcha_secret_key() {
		return defined( 'MENEKAS_RECAPTCHA_SECRET_KEY' ) ? MENEKAS_RECAPTCHA_SECRET_KEY : '';
	}
}

if ( ! function_exists( 'menekas_writing_contact_recaptcha_enabled' ) ) {
	function menekas_writing_contact_recaptcha_enabled() {
		return menekas_writing_contact_recaptcha_site_key() && menekas_writing_contact_recaptcha_secret_key();
	}
}

if ( ! function_exists( 'menekas_writing_verify_contact_recaptcha' ) ) {
	function menekas_writing_verify_contact_recaptcha( $token ) {
		if ( ! menekas_writing_contact_recaptcha_enabled() ) {
			return true;
		}

		if ( ! $token ) {
			return false;
		}

		$response = wp_remote_post(
			'https://www.google.com/recaptcha/api/siteverify',
			array(
				'timeout' => 10,
				'body'    => array(
					'secret'   => menekas_writing_contact_recaptcha_secret_key(),
					'response' => $token,
					'remoteip' => isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '',
				),
			)
		);

		if ( is_wp_error( $response ) ) {
			return false;
		}

		$body = json_decode( wp_remote_retrieve_body( $response ), true );

		return ! empty( $body['success'] );
	}
}

if ( ! function_exists( 'menekas_writing_handle_contact_form' ) ) {
	function menekas_writing_handle_contact_form() {
		if (
			! isset( $_POST['menekas_contact_nonce'] ) ||
			! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['menekas_contact_nonce'] ) ), 'menekas_contact_form' )
		) {
			return array(
				'success' => false,
				'message' => __( 'The form expired. Please try again.', 'menekas-writing' ),
			);
		}

		$name              = isset( $_POST['contact_name'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_name'] ) ) : '';
		$email             = isset( $_POST['contact_email'] ) ? sanitize_email( wp_unslash( $_POST['contact_email'] ) ) : '';
		$subject           = isset( $_POST['contact_subject'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_subject'] ) ) : '';
		$message           = isset( $_POST['contact_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['contact_message'] ) ) : '';
		$recaptcha_token   = isset( $_POST['g-recaptcha-response'] ) ? sanitize_text_field( wp_unslash( $_POST['g-recaptcha-response'] ) ) : '';
		$validation_errors = array();

		if ( '' === $name ) {
			$validation_errors[] = __( 'Name is required.', 'menekas-writing' );
		}

		if ( '' === $email || ! is_email( $email ) ) {
			$validation_errors[] = __( 'A valid email address is required.', 'menekas-writing' );
		}

		if ( '' === $subject ) {
			$validation_errors[] = __( 'Subject is required.', 'menekas-writing' );
		}

		if ( '' === $message ) {
			$validation_errors[] = __( 'Message is required.', 'menekas-writing' );
		}

		if ( ! menekas_writing_verify_contact_recaptcha( $recaptcha_token ) ) {
			$validation_errors[] = __( 'reCAPTCHA verification failed. Please try again.', 'menekas-writing' );
		}

		if ( $validation_errors ) {
			return array(
				'success' => false,
				'message' => implode( ' ', $validation_errors ),
			);
		}

		$mail_subject = sprintf(
			/* translators: %s: Contact form subject. */
			__( 'Contact form: %s', 'menekas-writing' ),
			$subject
		);
		$mail_body    = sprintf(
			"Name: %s\nEmail: %s\nSubject: %s\n\nMessage:\n%s",
			$name,
			$email,
			$subject,
			$message
		);
		$headers      = array(
			'Content-Type: text/plain; charset=UTF-8',
			sprintf( 'Reply-To: %s <%s>', $name, $email ),
		);

		if ( ! wp_mail( 'replaceme@email.com', $mail_subject, $mail_body, $headers ) ) {
			return array(
				'success' => false,
				'message' => __( 'The message could not be sent. Please try again later.', 'menekas-writing' ),
			);
		}

		return array(
			'success' => true,
			'message' => __( 'Thanks. Your message has been sent.', 'menekas-writing' ),
		);
	}
}

if ( ! function_exists( 'menekas_writing_ajax_contact_form' ) ) {
	function menekas_writing_ajax_contact_form() {
		$result = menekas_writing_handle_contact_form();

		if ( $result['success'] ) {
			wp_send_json_success(
				array(
					'message' => $result['message'],
				)
			);
		}

		wp_send_json_error(
			array(
				'message' => $result['message'],
			),
			400
		);
	}
}
add_action( 'wp_ajax_menekas_contact_form', 'menekas_writing_ajax_contact_form' );
add_action( 'wp_ajax_nopriv_menekas_contact_form', 'menekas_writing_ajax_contact_form' );
