jQuery(document).ready( function($) {
	var api = wp.customize;

 	$.each( ['blogname', 'blogdescription'], function( i, controlId ) {
        api.control( controlId, function( control ) {
            var setting = api( 'logo_type' );
            control.active.set( 'text' === setting.get() );
            setting.bind( function( value ) {
               control.active.set( 'text' === value );
            } );
        });
    } );

});