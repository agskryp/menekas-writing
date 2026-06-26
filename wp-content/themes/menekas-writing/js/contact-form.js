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
	