<?php
/**
 * Plugin Name: Tualatin Top Bakery: General Testimonials
 * Plugin URI: https://www.tualatintopbakery.com/general-testimonials
 * Version: 1.0
 * Author: Tualatin Top Bakery
 * Description: Add customer testimonials to your site.  Use the shortcode [general_testimonials] where you want to output testimonials, for example in a WordPress generated admin page or a custom PHP page with WordPress enabled.
 * Author URI: https://www.tualatintopbakery.com
 */


add_action( 'wp_enqueue_scripts', function(){ 
   wp_enqueue_style( 'general-testimonials-styling', plugin_dir_url(__FILE__) . '/assets/css/general-testimonials-styles.css' ); 
   wp_enqueue_style( 'general-testimonials-styling', plugin_dir_url(__FILE__) . 'style.css' );
});

function create_testimonial_post_type() {
    register_post_type('general-testimonials',
            array(
                'labels' => array(
                    'name' => __('General Testimonials'),
                    'singular_name' => __('General Testimonial')
                ),
                'public' => true,
                'supports' => array('title', 'editor', 'thumbnail', 'custom_fields'),
                'hierarchical' => false
            )
    );
}
add_action('init', 'create_testimonial_post_type');


function add_custom_metabox_info() {
    add_meta_box('custom-metabox', __('Testimonial Information'), 'url_custom_metabox', 'general-testimonials', 'side', 'low');
}
add_action( 'admin_init', 'add_custom_metabox_info' );


//Admin area HTML and logic 
function url_custom_metabox() {
    global $post;
    $testimonialprovidedname = get_post_meta($post->ID, 'testimonialprovidedname', true);
    $testimoniallabel = get_post_meta($post->ID, 'testimoniallabel', true);
    $urllink = get_post_meta($post->ID, 'testimonialurl', true);
    
    $errorsprovidedname = "";
    if( isset($errorsprovidedname) ){
        echo $errorsprovidedname;
    }
   
    $errorslink = "";
    if (!preg_match("/http(s?):\/\//", $urllink) && $urllink != "") {
        $errorslink = "This URL is not valid";
        $urllink = "http://";
    }
    
    if( isset($errorslink) ){
        echo $errorslink;
    }
    ?>
    <p>
        <label for="testimonialprovidedname">Provided Testimonial Name:<br />
            <input id="testimonialprovidedname" name="testimonialprovidedname" size="37" value="<?php if( isset($testimonialprovidedname) ) { echo $testimonialprovidedname; } ?>" />
        </label>
    </p>
    <p>
        <label for="testimoniallabel">Testimonial Label:<br />
            <input id="testimoniallabel" name="testimoniallabel" size="37" value="<?php if( isset($testimoniallabel) ) { echo $testimoniallabel; } ?>" />
        </label>
    </p>
    <p>
        <label for="testimonialurl">Testimonial URL:<br />
            <input id="testimonialurl" size="37" name="testimonialurl" value="<?php if( isset($urllink) ) { echo $urllink; } ?>" />
        </label>
    </p>
 <?php 
}


//Save user provided field data.
function save_custom_testimonialprovidedname($post_id) {
    global $post;
    
    if( isset($_POST['testimonialprovidedname']) ) {
        update_post_meta( $post->ID, 'testimonialprovidedname', $_POST['testimonialprovidedname'] );
    }
}
add_action( 'save_post', 'save_custom_testimonialprovidedname' );

function get_testimonialprovidedname($post) {
    $testimonialname = get_post_meta( $post->ID, 'testimonialprovidedname', true );
    return $testimonialname;
}


function save_custom_testimoniallabel($post_id) {
    global $post;
    
    if( isset($_POST['testimoniallabel']) ) {
        update_post_meta( $post->ID, 'testimoniallabel', $_POST['testimoniallabel'] );
    }
}
add_action( 'save_post', 'save_custom_testimoniallabel' );

function get_testimoniallabel($post) {
    $testimoniallabel = get_post_meta( $post->ID, 'testimoniallabel', true );
    return $testimoniallabel;
}


function save_custom_url($post_id) {
    global $post;
    
    if( isset($_POST['testimonialurl']) ) {
        update_post_meta( $post->ID, 'testimonialurl', $_POST['testimonialurl'] );
    }
}
add_action( 'save_post', 'save_custom_url' );

function get_url($post) {
    $urllink = get_post_meta( $post->ID, 'testimonialurl', true );
    return $urllink;
}


//Register the shortcode so we can show testimonials.
function load_testimonials($a) {

    $args = array(
        "post_type" => "general-testimonials"
    );

    if (isset($a['rand']) && $a['rand'] == true) {
        $args['orderby'] = 'rand';
    }
    if (isset($a['max'])) {
        $args['posts_per_page'] = (int) $a['max'];
    }

    //Get all testimonials.
    $posts = get_posts($args);
   
    echo '<div class="testimonials-container">';
    echo '<h3 class="testimonials-container__heading">Customers Love Us!</h3>';
    echo '<div class="testimonials-container__inner-wrapper">';
    foreach ($posts as $post) {
        $url_thumb = wp_get_attachment_thumb_url(get_post_thumbnail_id($post->ID));
        $providedName = get_testimonialprovidedname($post);
        $label = get_testimoniallabel($post);
        $link = get_url($post);
        echo '<div class="testimonial">';
        if ( !empty($url_thumb) ) {
            echo '<img class="testimonial__image" src="' . $url_thumb . '" />';
        }
        echo '<h4 class="testimonial__title">' . $post->post_title . '</h4>';
        if ( !empty($post->post_content) ) {
            echo '<p class="testimonial__content">' . $post->post_content . '</p>';
        }
        if( !empty($providedName) ) {
            if ( !empty($link)) {
                 echo '<span class="testimonial__provided-name"><a class="testimonial__link" href="' . $link . '" target="__blank">' . $providedName . '</a></span>';
            } else {
                 echo '<span class="testimonial__provided-name">' . $providedName . '</span>';
            }
        }
        if( !empty($label) ) {
            echo '<span class="testimonial__label">, ' . $label . '</span>';
        }
        echo '</div>';
    }
    echo '</div>';
    echo '</div>';

}
add_shortcode( "general_testimonials", "load_testimonials" );
add_filter( 'widget_text', 'do_shortcode' );
