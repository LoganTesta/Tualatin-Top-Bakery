<?php

/*Prevent non-logged in users from accessing the site's user and post data using the WordPress REST API.*/
add_filter( 'rest_authentication_errors', function( $result ) {
   if ( !empty( $result ) ) {
       return $result;
   } 
   if( !is_user_logged_in() ) {
       return new WP_Error( 'rest_not_logged_in', 'You are not currently logged in.', array( 'status' => 401 ) );    
   }
   return $result;
} );


add_theme_support( "post-thumbnails" ); //Allow image thumbnails in pages and posts.
//Allow cropping for medium thumbnail images.

if ( false === get_option( "medium_crop" ) ) {
    add_option( "medium_crop", "1" );
} else {
    update_option( "medium_crop", "1" );
}

add_image_size( "medium_rect_crop", 460, 320, true );


add_action( 'wp_enqueue_scripts', function(){ 
    wp_register_script( 'footer-modal-javascript', get_template_directory_uri() . '/footer-modal-javascript.js' );
    wp_enqueue_script( 'footer-modal-javascript', get_template_directory_uri() . '/footer-modal-javascript.js' );  
} );
