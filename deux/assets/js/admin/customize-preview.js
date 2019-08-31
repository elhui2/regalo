/**
 * customize-preview.js
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	var api = wp.customize;

	// Site title and description.
	api( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.logo-text' ).text( to );
		} );
	} );

	// Topbar content
	api( 'topbar_enable', function( value ) {
		value.bind( function( newval ) {
			if( true === newval ){
				$('body')
					.removeClass( 'topbar-disabled' )
					.addClass( 'topbar-enabled' );				
			} else {
				$('body')
					.removeClass( 'topbar-enabled' )
					.addClass( 'topbar-disabled' );
			}
		} );
	} );

	api( 'topbar_content', function( value ) {
		value.bind( function( to ) {
			$( '.topbar-content' ).text( to );
		} );
	} );

	api( 'logo_width', function( value ) {
		value.bind( function( to ) {
			$( '.site-branding .logo img' ).css( 'width', to );
		} );
	} );

	api( 'logo_height', function( value ) {
		value.bind( function( to ) {
			$( '.site-branding .logo img' ).css( 'height', to );
		} );
	} );

	// Header
	api( 'header_layout' , function( value ) {
		value.bind( function( newval ) {
			$('body')
				.removeClass( 'header-v1 header-v2 header-v3 header-v4 header-v5 header-v6' )
				.addClass( 'header-' + newval );
		} );
	});

	api( 'header_wrapper' , function( value ) {
		value.bind( function( newval ) {
			if( 'full-width' === newval ){
				$('.site-header .container')
					.removeClass( 'container' )
					.addClass( 'deux-container' );				
			} else {
				$('.site-header .deux-container')
					.removeClass( 'deux-container' )
					.addClass( 'container' );
			}
		} );
	});	

	api( 'shop_cart_icon' , function( value ) {
		value.bind( function( newval ) {
			$('.menu-item-cart svg use, .menu-item-mobile-cart svg use, .mobile-menu-bottom .item-cart svg use').attr('xlink:href', '#' + newval );
		} );
	});

})( jQuery );