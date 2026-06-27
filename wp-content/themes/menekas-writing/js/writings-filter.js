import Isotope from 'isotope-layout';

const grid = document.querySelector( '.grid' );
const filters = document.querySelectorAll( '[data-filter]' );

if ( grid ) {
	const isotope = new Isotope( grid, {
		itemSelector: '.grid-item',
		layoutMode: 'fitRows',
	} );

	filters.forEach( function( filter ) {
		filter.addEventListener( 'click', function( event ) {
			event.preventDefault();

			filters.forEach( function( filterLink ) {
				filterLink.removeAttribute( 'aria-current' );
			} );

			filter.setAttribute( 'aria-current', 'page' );
			isotope.arrange( {
				filter: filter.getAttribute( 'data-filter' ),
			} );
		} );
	} );
}
