<?php
/**
 *
 * usage example:
 * $o = Deux_Dashboard_Api::verifyPurchase( $purchase_code ); <- call data purchase_id using get_option 
 *
 * if ( is_object($o) ) {
 *    valid...
 *  $o contains the purchase data
 * }
 * 
 */

class Deux_Dashboard_Api {

  // Bearer, no need for OAUTH token, change this to your bearer string
  // https://build.envato.com/api/#token
  private static $token = ''; 

  static function requestData( $url ) {
    
    //setting the header for the rest of the api
    $request_headers = array(
      'user-agent' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13',
      'timeout'    => 20,
      'headers' => array(
          'Authorization' => 'Bearer ' . self::$token,
        )
    );

    // Make an API request.
    $response = wp_remote_get( esc_url_raw( $url ), $request_headers );
    $body = wp_remote_retrieve_body( $response );

    // Check the response code.
    $response_code    = wp_remote_retrieve_response_code( $response );
    $response_message = wp_remote_retrieve_response_message( $response );
    
    if ( 200 !== $response_code && ! empty( $response_message ) ) {
      return new WP_Error( $response_code, $response_message );
    } elseif ( 200 !== $response_code ) {
      return new WP_Error( $response_code, __( 'An unknown API error occurred.', 'deux' ) );
    } else {
      $return = json_decode( $body, true );
      if ( null === $return ) {
        return new WP_Error( 'api_error', __( 'An unknown API error occurred.', 'deux' ) );
      }
      return $return;
    }
      
  }
  
  static function verifyPurchase( $code ) {

    $verify_url = sprintf( 'https://api.envato.com/v3/market/author/sale?code=%s', $code );
    $response = self::requestData( $verify_url ); 

    if ( isset( $response['error'] ) && $response['error'] == '404' ) {
  		return false;
  	} 

  	$date = new DateTime( $response['supported_until'] );
  	$result = $date->format('Y-m-d H:i:s');

  	if ( isset( $response['item']['name'] ) ) {   
  	    return " - {$response['buyer']} is VERIFIED ( {$response['item']['name']} ) - ( License: {$response['license']} | Supported: {$result} )";
  	} 
    
  }
}