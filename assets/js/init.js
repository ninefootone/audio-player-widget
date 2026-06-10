/**
 * Church Sermons Player — Plyr initialisation.
 *
 * Runs after DOM is ready. Targets all .csp-sermon-audio elements on the page
 * so multiple players on one page (e.g. archive) work independently.
 */
document.addEventListener( 'DOMContentLoaded', function () {
	const elements = document.querySelectorAll( '.csp-sermon-audio' );

	if ( ! elements.length || typeof Plyr === 'undefined' ) {
		return;
	}

	elements.forEach( function ( el ) {
		new Plyr( el );
	} );
} );
