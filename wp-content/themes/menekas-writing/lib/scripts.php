<?php
	/**
	 * Enqueue scripts and styles.
	 */
	
	function menekas_writing_scripts() {
		$theme_ver = wp_get_theme()->get( 'Version' );
		
		wp_enqueue_style( 'menekas-writing-style', get_stylesheet_uri(), array(), $theme_ver );

		wp_enqueue_script( 
			'mw-main-scripts', get_template_directory_uri() . '/dist/main.js', array(), $theme_ver, true 
		);
		wp_localize_script(
			'mw-main-scripts',
			'menekasContactForm',
			array(
				'ajaxUrl'            => admin_url( 'admin-ajax.php' ),
				'action'             => 'menekas_contact_form',
				'recaptchaEnabled'   => function_exists( 'menekas_writing_contact_recaptcha_enabled' ) && menekas_writing_contact_recaptcha_enabled(),
				'submittingMessage'  => esc_html__( 'Sending...', 'menekas-writing' ),
				'genericErrorMessage' => esc_html__( 'The message could not be sent. Please try again later.', 'menekas-writing' ),
			)
		);

		if( is_page_template( 'template-home.php' ) ) {
			wp_enqueue_script( 
				'mw-home-scripts', get_template_directory_uri() . '/dist/home.js', array(), $theme_ver, true 
			);
		}

		if( is_page_template( 'template-about.php' ) ) {
			wp_enqueue_script( 
				'mw-about-scripts', get_template_directory_uri() . '/dist/about.js', array(), $theme_ver, true 
			);
		}	

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
	add_action( 'wp_enqueue_scripts', 'menekas_writing_scripts' );
