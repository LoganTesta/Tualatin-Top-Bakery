<?php
/**
 * Plugin Name: Tualatin Top Bakery: Toggle Blog Settings
 * Plugin URI: https://www.tualatintopbakery.com/toggle-blog-settings
 * Version: 1.0
 * Author: Tualatin Top Bakery
 * Description: This plugin adds the ability for the user to show or hide blog text to quickly scroll down a long list of blogs without having to skim over the blog content.  The page you are using the plugin on must have an outer blog posts container div with ID of 'blogPostsContainer', and an inner container div with ID of 'blogPosts'.  Each individual blog must have content with a class name of 'blog__content'.  Enjoy!
 * Author URI: https://www.tualatintopbakery.com
 */



add_action('wp_enqueue_scripts', function(){
   wp_enqueue_script('toggle-blog-settings-javascript', plugin_dir_url(__FILE__) . 'toggle-blog-settings-javascript.js');
    
});
