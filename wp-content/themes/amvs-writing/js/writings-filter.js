import Isotope from 'isotope-layout';

const grid = document.querySelector( '.portfolio-list-grid' );
const filters = document.querySelectorAll( '[data-filter]' );

if ( grid ) {
	const items = Array.from( grid.querySelectorAll( '.grid-item' ) );
	const isotope = new Isotope( grid, {
		itemSelector: '.grid-item',
		layoutMode: 'fitRows',
	} );

	const equalizeGridItemHeights = function() {
		let tallestItemHeight = 0;

		items.forEach( function( item ) {
			item.style.height = 'auto';
		} );

		items.forEach( function( item ) {
			if ( item.offsetParent === null ) {
				return;
			}

			tallestItemHeight = Math.max(
				tallestItemHeight,
				Math.ceil( item.getBoundingClientRect().height )
			);
		} );

		if ( tallestItemHeight ) {
			items.forEach( function( item ) {
				if ( item.offsetParent !== null ) {
					item.style.height = `${ tallestItemHeight }px`;
				}
			} );
		}
	};

	const layoutEqualizedGrid = function() {
		equalizeGridItemHeights();
		isotope.layout();
	};

	layoutEqualizedGrid();
	window.addEventListener( 'resize', layoutEqualizedGrid );

	filters.forEach( function( filter ) {
		filter.addEventListener( 'click', function( event ) {
			event.preventDefault();

			filters.forEach( function( filterLink ) {
				filterLink.removeAttribute( 'aria-current' );
			} );

			filter.setAttribute( 'aria-current', 'page' );
			isotope.once( 'arrangeComplete', layoutEqualizedGrid );
			isotope.arrange( {
				filter: filter.getAttribute( 'data-filter' ),
			} );
		} );
	} );
}
