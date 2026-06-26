( function() {
	const modal = document.getElementById( 'contact-modal' );

	if ( ! modal ) {
		return;
	}

	const form = modal.querySelector( '[data-contact-form]' );
	const status = modal.querySelector( '[data-contact-form-status]' );
	const submitButton = form ? form.querySelector( '[type="submit"]' ) : null;

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

	if ( ! form ) {
		return;
	}

	function setStatus( message, isError ) {
		if ( ! status ) {
			return;
		}

		status.textContent = message;
		status.hidden = false;
		status.setAttribute( 'aria-invalid', isError ? 'true' : 'false' );
	}

	function resetRecaptcha() {
		const recaptchaResponse = form.querySelector( '[name="g-recaptcha-response"]' );

		if ( recaptchaResponse ) {
			recaptchaResponse.value = '';
		}

		if ( window.grecaptcha ) {
			window.grecaptcha.reset();
		}
	}

	function setSubmitting( isSubmitting ) {
		if ( ! submitButton ) {
			return;
		}

		submitButton.disabled = isSubmitting;
		submitButton.setAttribute( 'aria-busy', isSubmitting ? 'true' : 'false' );
	}

	function getMessageFromResponse( response ) {
		if ( response && response.data && response.data.message ) {
			return response.data.message;
		}

		return window.menekasContactForm && window.menekasContactForm.genericErrorMessage ?
			window.menekasContactForm.genericErrorMessage :
			'The message could not be sent. Please try again later.';
	}

	function submitContactForm() {
		if ( form.reportValidity && ! form.reportValidity() ) {
			resetRecaptcha();
			return;
		}

		if ( window.menekasContactForm && window.menekasContactForm.submittingMessage ) {
			setStatus( window.menekasContactForm.submittingMessage, false );
		}

		setSubmitting( true );

		fetch( window.menekasContactForm.ajaxUrl, {
			method: 'POST',
			credentials: 'same-origin',
			body: new FormData( form ),
		} )
			.then( function( response ) {
				return response.json().then( function( body ) {
					if ( ! response.ok || ! body.success ) {
						throw body;
					}

					return body;
				} );
			} )
			.then( function( body ) {
				setStatus( getMessageFromResponse( body ), false );
				form.reset();
				resetRecaptcha();
			} )
			.catch( function( error ) {
				setStatus( getMessageFromResponse( error ), true );
				resetRecaptcha();
			} )
			.finally( function() {
				setSubmitting( false );
			} );
	}

	window.menekasWritingSubmitContactForm = submitContactForm;

	form.addEventListener( 'submit', function( event ) {
		event.preventDefault();

		const recaptchaResponse = form.querySelector( '[name="g-recaptcha-response"]' );

		if (
			window.menekasContactForm &&
			window.menekasContactForm.recaptchaEnabled &&
			window.grecaptcha &&
			( ! recaptchaResponse || ! recaptchaResponse.value )
		) {
			window.grecaptcha.execute();
			return;
		}

		submitContactForm();
	} );
}() );
