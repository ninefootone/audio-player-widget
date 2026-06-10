/**
 * Audio Player Widget — Plyr initialisation.
 *
 * Runs after DOM is ready. Targets all .apw-audio elements on the page
 * so multiple players on one page work independently.
 */
document.addEventListener( 'DOMContentLoaded', function () {
	const elements = document.querySelectorAll( '.apw-audio' );

	if ( ! elements.length || typeof Plyr === 'undefined' ) {
		return;
	}

	elements.forEach( function ( el ) {
		new Plyr( el );
	} );
} );
