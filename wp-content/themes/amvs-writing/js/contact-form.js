( function() {
	const menu = document.getElementById( 'primary-navigation' );
	const openButton = document.querySelector( '[data-mobile-menu-open]' );
	const closeButton = document.querySelector( '[data-mobile-menu-close]' );
	const desktopQuery = window.matchMedia( '(min-width: 768px)' );

	if ( ! menu || ! openButton || ! closeButton ) {
		return;
	}

	function openMenu() {
		menu.classList.add( 'is-open' );
		openButton.setAttribute( 'aria-expanded', 'true' );
		closeButton.focus();
	}

	function closeMenu() {
		menu.classList.remove( 'is-open' );
		openButton.setAttribute( 'aria-expanded', 'false' );
	}

	openButton.addEventListener( 'click', openMenu );
	closeButton.addEventListener( 'click', function() {
		closeMenu();
		openButton.focus();
	} );

	menu.querySelectorAll( 'a, [data-open-modal]' ).forEach( function( item ) {
		item.addEventListener( 'click', function() {
			if ( ! desktopQuery.matches ) {
				closeMenu();
			}
		} );
	} );

	document.addEventListener( 'keyup', function( event ) {
		if ( event.key === 'Escape' ) {
			closeMenu();
		}
	} );

	function handleDesktopChange( event ) {
		if ( event.matches ) {
			closeMenu();
		}
	}

	if ( desktopQuery.addEventListener ) {
		desktopQuery.addEventListener( 'change', handleDesktopChange );
	} else {
		desktopQuery.addListener( handleDesktopChange );
	}
}() );

( function() {
	const modal = document.getElementById( 'contact-modal' );

	if ( ! modal ) {
		return;
	}

	const form = modal.querySelector( '[data-contact-form]' );
	const status = modal.querySelector( '[data-contact-form-status]' );
	const submitButton = form ? form.querySelector( '[type="submit"]' ) : null;

	document.querySelectorAll( '[data-open-modal="contact-modal"]' ).forEach( function( button ) {
		button.addEventListener( 'click', function( event ) {
			event.preventDefault();

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

		return window.amvsContactForm && window.amvsContactForm.genericErrorMessage ?
			window.amvsContactForm.genericErrorMessage :
			'The message could not be sent. Please try again later.';
	}

	function submitContactForm() {
		if ( form.reportValidity && ! form.reportValidity() ) {
			resetRecaptcha();
			return;
		}

		if ( window.amvsContactForm && window.amvsContactForm.submittingMessage ) {
			setStatus( window.amvsContactForm.submittingMessage, false );
		}

		setSubmitting( true );

		const formData = new FormData( form );

		if ( window.amvsContactForm && window.amvsContactForm.action ) {
			formData.set( 'action', window.amvsContactForm.action );
		}

		fetch( window.amvsContactForm.ajaxUrl, {
			method: 'POST',
			credentials: 'same-origin',
			body: formData,
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

	window.amvsWritingSubmitContactForm = submitContactForm;

	form.addEventListener( 'submit', function( event ) {
		event.preventDefault();

		const recaptchaResponse = form.querySelector( '[name="g-recaptcha-response"]' );

		if (
			window.amvsContactForm &&
			window.amvsContactForm.recaptchaEnabled &&
			window.grecaptcha &&
			( ! recaptchaResponse || ! recaptchaResponse.value )
		) {
			window.grecaptcha.execute();
			return;
		}

		submitContactForm();
	} );
}() );
