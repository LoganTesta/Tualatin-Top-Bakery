<?php
/**
 * Plugin Name: Tualatin Top Bakery: Toggle Blog Settings
 * Plugin URI: https://www.tualatintopbakery.com/toggle-blog-settings
 * Version: 1.0
 * Author: Tualatin Top Bakery
 * Description: This plugin adds the ability for the user to show or hide blog text to quickly scroll down a long list of blogs without having to skim over the blog content.  The page you are using the plugin on must have an outer blog posts container div with ID of 'blogPostsContainer', and an inner container div with ID of 'blogPosts'.  Each individual blog must have content with a class name of 'blog__content'.  Enjoy!
 * Author URI: https://www.tualatintopbakery.com
 */




//function toggle_settings(){
//   wp_enqueue_script('toggle-blog-settings-javascript', plugin_dir_url(__FILE__) . 'toggle-blog-settings-javascript.js');
//}
//add_action('wp_enqueue_scripts', 'toggle_settings');

?>



<script text="text/javascript">
    
    window.addEventListener("load", function(){
        if(document.getElementsByTagName('body')[0].className === "page-blog"){
            let blogPostsContainer = document.getElementById("blogPostsContainer");
            let blogPostsDiv = document.getElementById("blogPosts");
            let orderBlogsDiv = document.createElement('div');   
            orderBlogsDiv.innerHTML = "Show/hide blogs' body text";
            orderBlogsDiv.className = "order-blogs";
        
        
            blogPostsContainer.insertBefore(orderBlogsDiv, blogPostsDiv);
        
            document.getElementsByClassName("order-blogs")[0].className +=" show";
        
             document.getElementsByClassName("order-blogs")[0].addEventListener("click", function () {
                let blogContentList = document.getElementsByClassName("blog__content");
                for (let i = 0; i < blogContentList.length; i++) {
                    blogContentList[i].classList.toggle("hide");
                }
            }, "false");
        }
    }, "false");

</script>