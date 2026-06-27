<?php
/**
 * Contact form handling.
 */

if ( ! function_exists( 'amvs_writing_contact_recaptcha_site_key' ) ) {
	function amvs_writing_contact_recaptcha_site_key() {
		return defined( 'AMVS_RECAPTCHA_SITE_KEY' ) ? AMVS_RECAPTCHA_SITE_KEY : '';
	}
}

if ( ! function_exists( 'amvs_writing_contact_recaptcha_secret_key' ) ) {
	function amvs_writing_contact_recaptcha_secret_key() {
		return defined( 'AMVS_RECAPTCHA_SECRET_KEY' ) ? AMVS_RECAPTCHA_SECRET_KEY : '';
	}
}

if ( ! function_exists( 'amvs_writing_contact_recaptcha_enabled' ) ) {
	function amvs_writing_contact_recaptcha_enabled() {
		return amvs_writing_contact_recaptcha_site_key() && amvs_writing_contact_recaptcha_secret_key();
	}
}

if ( ! function_exists( 'amvs_writing_verify_contact_recaptcha' ) ) {
	function amvs_writing_verify_contact_recaptcha( $token ) {
		if ( ! amvs_writing_contact_recaptcha_enabled() ) {
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
					'secret'   => amvs_writing_contact_recaptcha_secret_key(),
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

if ( ! function_exists( 'amvs_writing_handle_contact_form' ) ) {
	function amvs_writing_handle_contact_form() {
		if (
			! isset( $_POST['amvs_contact_nonce'] ) ||
			! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['amvs_contact_nonce'] ) ), 'amvs_contact_form' )
		) {
			return array(
				'success' => false,
				'message' => __( 'The form expired. Please try again.', 'amvs-writing' ),
			);
		}

		$name = 
			isset( $_POST['contact_name'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_name'] ) ) : '';
		
		$email = isset( $_POST['contact_email'] ) ? sanitize_email( wp_unslash( $_POST['contact_email'] ) ) : '';
		
		$message = 
			isset( $_POST['contact_message'] ) 
				? sanitize_textarea_field( wp_unslash( $_POST['contact_message'] ) ) 
				: '';
		
		$recaptcha_token = 
			isset( $_POST['g-recaptcha-response'] ) 
				? sanitize_text_field( wp_unslash( $_POST['g-recaptcha-response'] ) ) 
				: '';
		$validation_errors = array();

		if ( '' === $name ) {
			$validation_errors[] = __( 'Name is required.', 'amvs-writing' );
		}

		if ( '' === $email || ! is_email( $email ) ) {
			$validation_errors[] = __( 'A valid email address is required.', 'amvs-writing' );
		}

		if ( '' === $message ) {
			$validation_errors[] = __( 'Message is required.', 'amvs-writing' );
		}

		if ( ! amvs_writing_verify_contact_recaptcha( $recaptcha_token ) ) {
			$validation_errors[] = __( 'reCAPTCHA verification failed. Please try again.', 'amvs-writing' );
		}

		if ( $validation_errors ) {
			return array(
				'success' => false,
				'message' => implode( ' ', $validation_errors ),
			);
		}

		$mail_subject =  __( 'A new message from ' . get_bloginfo( 'name' ), 'amvs-writing' );

		$mail_body    = sprintf(
			"Name: %s\nEmail: %s\n\nMessage:\n%s",
			$name,
			$email,
			$message
		);

		$headers      = array(
			'Content-Type: text/plain; charset=UTF-8',
			sprintf( 'Reply-To: %s <%s>', $name, $email ),
		);

		if ( !wp_mail( get_option( 'admin_email' ), $mail_subject, $mail_body, $headers ) ) {
			return array(
				'success' => false,
				'message' => __( 'The message could not be sent. Please try again later.', 'amvs-writing' ),
			);
		}

		return array(
			'success' => true,
			'message' => __( 'Thanks. Your message has been sent.', 'amvs-writing' ),
		);
	}
}

if ( ! function_exists( 'amvs_writing_ajax_contact_form' ) ) {
	function amvs_writing_ajax_contact_form() {
		$result = amvs_writing_handle_contact_form();

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
add_action( 'wp_ajax_amvs_contact_form', 'amvs_writing_ajax_contact_form' );
add_action( 'wp_ajax_nopriv_amvs_contact_form', 'amvs_writing_ajax_contact_form' );
