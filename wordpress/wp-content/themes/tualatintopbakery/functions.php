<?php

add_theme_support( "post-thumbnails" ); //Allow image thumbnails in pages and posts.
//Allow cropping for medium thumbnail images.

if (false === get_option( "medium_crop" )) {
    add_option( "medium_crop", "1" );
} else {
    update_option( "medium_crop", "1" );
}

add_image_size( "medium_rect_crop", 460, 320, true );
