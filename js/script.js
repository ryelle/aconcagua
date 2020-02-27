/**
 * Generate a "scale" based on the range between min & max sizes of the element & sizes between
 * the min & max font size.
 * See https://css-tricks.com/snippets/css/fluid-typography/
 *
 * @param {number} width Current width of the element
 * @param {object} element Min & max sizes to use for the element scale.
 * @param {object} fontSize Min & max font sizes used to create the scale
 */
function getTypeScale( width, element, fontSize, unit = 'rem' ) {
	element = Object.assign( { min: 240, max: 600 }, element );
	fontSize = Object.assign( { min: 1, max: 2 }, fontSize );

	// Return 0 to cap at the min.
	if ( width < element.min ) {
		return 0 + unit;
	}

	// Return diff to cap at the max.
	if ( width > element.max ) {
		return ( fontSize.max - fontSize.min ) + unit;
	}

	return ( ( width - element.min ) / ( element.max - element.min ) ) * ( fontSize.max - fontSize.min ) + unit;
}

function initResize() {
	const latestPosts = document.querySelectorAll('.wp-block-latest-posts.is-grid li:first-child');
	if ( ! latestPosts.length ) {
		return;
	}

	const resizeObserver = new ResizeObserver( entries => {
		// Each entry is a tracked object.
		for ( let entry of entries ) {
			const container = entry.target.parentElement;
			if ( entry.contentBoxSize ) {
				container.style.setProperty(
					'--type-scale',
					getTypeScale( entry.contentBoxSize.inlineSize, { min: 240, max: 600 } )
				);
			} else {
				container.style.setProperty(
					'--type-scale',
					getTypeScale( entry.contentRect.width )
				);
			}
		}
	} );

	latestPosts.forEach( block => resizeObserver.observe( block ) );
}

if ( ResizeObserver ) {
	initResize();
}
