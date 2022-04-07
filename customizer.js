/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( 'body > header p' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( 'body > header h1' ).text( to );
		} );
	} );
	wp.customize( 'background_color', function( value ) {
		value.bind( function( to ) {
			if ( to ) {
				$( 'body #comments' ).css( 'background-color', to );
			} else {
				$( 'body #comments' ).css( 'background-color', '' );
			}
		} );
	} );
	wp.customize( 'header_backgroundcolor', function( value ) {
		value.bind( function( to ) {
			if ( to ) {
				$( 'body > header' ).css( 'background-color', to );
				$( 'body > header h1' ).css( 'background-color', to );
				$( 'body > footer' ).css( 'background-color', to );
				$( 'body > footer' ).css( 'border-color', to );
				$( 'body > aside h2' ).css( 'background-color', to );
				$( 'body > main > article > ul > li h2' ).css( 'background-color', to );
				$( 'body > aside caption' ).css( 'background-color', to );
				$( 'body > main article h1' ).css( 'border-color', to );
				$( 'body > main article h2' ).css( 'border-color', to );
				$( 'body > main article h3' ).css( 'border-color', to );
				$( 'body > main article h4' ).css( 'border-color', to );
				$( 'body > main article h5' ).css( 'border-color', to );
				$( 'body > main article h6' ).css( 'border-color', to );
			} else {
				$( 'body > header' ).css( 'background-color', '' );
				$( 'body > header h1' ).css( 'background-color', '' );
				$( 'body > footer' ).css( 'background-color', '' );
				$( 'body > footer' ).css( 'border-color', '' );
				$( 'body > aside h2' ).css( 'background-color', '' );
				$( 'body > main > article > ul > li h2' ).css( 'background-color', '' );
				$( 'body > aside caption' ).css( 'background-color', '' );
				$( 'body > main article h1' ).css( 'border-color', '' );
				$( 'body > main article h2' ).css( 'border-color', '' );
				$( 'body > main article h3' ).css( 'border-color', '' );
				$( 'body > main article h4' ).css( 'border-color', '' );
				$( 'body > main article h5' ).css( 'border-color', '' );
				$( 'body > main article h6' ).css( 'border-color', '' );
			}
		} );
	} );
	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( to ) {
				$( 'body > main > article > ul > li h2, body > header, body > header h1, body > footer, body > aside h2, body > aside caption' ).css( {
					'color': to
				} );
			} else {
				$( 'body > header p' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			}
		} );
	} );
	// breadcrumbs
	wp.customize( 'graftee_advanced_settings_breadcrumbs', function( value ) {
		value.bind( function( to ) {
			if ( to ) {
				$( 'body > main' ).before( '<ol itemscope itemtype="http://schema.org/BreadcrumbList"><li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item url" href="#">hello</a></li><li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item url" href="#">breadcrumbs</a></li><li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">example</li></ol>' );
			} else {
				$( 'body > ol' ).remove();
			}
		} );
	} );
	// disabled style.css
	wp.customize( 'graftee_advanced_settings_disabled_stylecss', function( value ) {
		value.bind( function( to ) {
			if ( to ) {
				$( '#graftee-style-css' ).attr( 'disabled', true );
			} else {
				$( '#graftee-style-css' ).removeAttr( 'disabled' );
			}
		} );
	} );
	// add css
	wp.customize( 'graftee_advanced_settings_add_css', function( value ) {
		value.bind( function( to ) {
			if ( $( '#graftee-add-css' ).length == 0 ) {
				$( 'head' ).append( $( '<link/>' ).attr( 'rel', 'stylesheet' ).attr( 'id', 'graftee-add-css' ).attr( 'href', to ) );
			}

			if ( to ) {
				$( '#graftee-add-css' ).removeAttr( 'disabled' );
			} else {
				$( '#graftee-add-css' ).attr( 'disabled', true );
			}
		} );
	} );
	// words
	wp.customize( 'graftee_advanced_settings_article-list', function( value ) {
		value.bind( function( to ) {
			if ( to ) {
				$( 'body > main > article > h1' ).html( to );
			} else {
				$( 'body > main > article > h1' ).html( '' );
			}
		} );
	} );
	// footer credit
	wp.customize( 'graftee_advanced_settings_credit', function( value ) {
		value.bind( function( to ) {
			if ( $( 'body > footer > p > small[role=copyright] + small' ).length == 0 ) {
				$( 'body > footer > p' ).append( $( '<small/>' ).css( { 'display': 'none', 'text-align': 'right' } ) );
			}

			if ( to ) {
				$( 'body > footer > p > small[role=copyright]' ).css( { 'display': 'none', 'text-align': 'right' } );
				$( 'body > footer > p > small[role=copyright] + small' ).html( to );
				$( 'body > footer > p > small[role=copyright] + small' ).css( 'display', 'block' );
			} else {
				$( 'body > footer > p > small[role=copyright] + small' ).html( '' );
				$( 'body > footer > p > small[role=copyright] + small' ).css( 'display', 'none' );
				$( 'body > footer > p > small[role=copyright]' ).css( 'display', 'block' );
			}
		} );
	} );
} )( jQuery );
