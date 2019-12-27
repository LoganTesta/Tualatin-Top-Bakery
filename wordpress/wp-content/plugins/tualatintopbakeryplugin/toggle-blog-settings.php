<?php
/**
 * Plugin Name: Tualatin Top Bakery: Toggle Blog Settings
 * Plugin URI: https://www.tualatintopbakery.com/toggle-blog-settings
 * Version: 1.0
 * Author: Tualatin Top Bakery
 * Description: This plugin adds the ability for the user to show or hide blog text to quickly scroll down a long list of blogs without having to skim over the blog content.  This plugin is for developers of custom non-WordPress PHP sites that want to add this feature to their site.  Notes: in your PHP file, add two lines of code, each surrounded by php tags: in the header just before the closing head tag: php wp_head();, and in the body just before the closing body tag: wp_footer();.  The page you are using the plugin with must have an outer blog posts container div with ID of 'blogPostsContainer', and an inner container div with ID of 'blogPosts'.  Each individual blog must have content with a class name of 'blog__content' and 'blog__image' where you put the blogs content and image in inside php tags using the_date(); and the_post_thumbnail();.  Enjoy!
 * Author URI: https://www.tualatintopbakery.com
 */


add_action('wp_enqueue_scripts', function(){ 
    wp_register_script('toggle-blog-settings-javascript', plugin_dir_url(__FILE__) . 'toggle-blog-settings-javascript.js');
    wp_enqueue_script('toggle-blog-settings-javascript', plugin_dir_url(__FILE__) . 'toggle-blog-settings-javascript.js');  
    wp_enqueue_style('toggle-blog-settings-styling', plugin_dir_url(__FILE__) . 'toggle-blog-settings.css');  
});


