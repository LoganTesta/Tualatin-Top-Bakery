<?php
/**
 * Plugin Name: Tualatin Top Bakery: General Testimonials
 * Plugin URI: https://www.tualatintopbakery.com/general-testimonials
 * Version: 1.0
 * Author: Tualatin Top Bakery
 * Description: Add customer testimonials to your site.  Use the shortcode [general_testimonials] where you want to output testimonials, for example in a WordPress generated admin page or a custom PHP page with WordPress enabled.
 * Author URI: https://www.tualatintopbakery.com
 */


?>
<style>
    
.testimonials-container__heading { text-align: center; }
.testimonials-container__inner-wrapper { padding-top: 15px; }

.testimonial { padding-bottom: 40px; }
.testimonial__image { display: block; margin-bottom: 15px; margin-left: auto; margin-right: auto; border-radius: <?php echo get_option( 'general-testimonials-border-radius' ); ?>; }
.testimonial__title { }
.testimonial__content { padding-bottom: 5px; }
.testimonial__provided-name { font-size: 17px; font-weight: bold; }
.testimonial__label { font-size: 17px; font-style: italic; }

.testimonial:last-of-type { padding-bottom: 0; }
.testimonials-container__inner-wrapper::after { content: ""; display: block; clear: both; }
.testimonial__link { font-size: 17px; font-weight: bold; }



@media only screen and (min-width: 700px){
    .testimonial { float: left; width: 50%; padding: 0 15px 0 15px; }
    
    .testimonial__image { float: left; margin-left: 0; margin-right: 15px; }
    
    .testimonial:first-of-type { padding-left: 0; }
    .testimonial:last-of-type { padding-right: 0; }
}



@media only screen and (min-width: 1200px){ 
     
}
</style>
<?php

add_action( 'admin_enqueue_scripts', function(){ 
    wp_enqueue_style( 'general-testimonials-admin-styling', plugin_dir_url(__FILE__) . '/assets/css/general-testimonials-admin-styles.css' ); 
});

add_action( 'wp_enqueue_scripts', function(){ 
  //wp_enqueue_style( 'general-testimonials-styling', plugin_dir_url(__FILE__) . '/assets/css/general-testimonials-styles.css' ); 
});

function gt_create_testimonial_post_type() {
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
add_action('init', 'gt_create_testimonial_post_type');


/*Add a settings page for the plugin*/


/*Set up the settings page inputs*/
function gt_register_settings() {
    add_option( 'general-testimonials-leading-text', 'Some text' );
    add_option( 'general-testimonials-border-radius', '45px' );
    register_setting( 'general-testimonials-settings-group', 'general-testimonials-leading-text', 'gt_validatetextfield' );
    register_setting( 'general-testimonials-settings-group', 'general-testimonials-border-radius', 'gt_validatetextfield' );
}
add_action( 'admin_init', 'gt_register_settings');


/*Set up the settings page*/
function gt_add_options_page() {
    add_options_page( 'Page Title', 'General Testimonials Settings', 'manage_options', 'general-testimonials', 'gt_generate_settings_page' );
}
add_action( 'admin_menu', 'gt_add_options_page');


function gt_validatetextfield( $input ) {
    $updatedField = sanitize_text_field( $input );
    return $updatedField;
}

function gt_generate_settings_page() {
    ?>
    <h2>General Testimonials Settings</h2>
    <?php screen_icon(); ?>
        <form class="testimonials-settings-form" method="post" action="options.php">
        <?php settings_fields('general-testimonials-settings-group'); ?>
            <label for="general-testimonials-leading-text">Testimonials Leading Text</label>
            <input id="generalTestimonialsLeadingText" class="general-testimonials-leading-text" name="general-testimonials-leading-text" type="text" value="<?php echo get_option('general-testimonials-leading-text'); ?>" />
            <label for="general-testimonials-border-radius">Border Radius</label>
            <input id="generalTestimonialsBorderRadius" class="general-testimonials-border-radius" name="general-testimonials-border-radius" type="text" value="<?php echo get_option('general-testimonials-border-radius'); ?>" />
        <?php submit_button(); ?>
        </form>
    <?php
}


function gt_add_custom_metabox_info() {
    add_meta_box('custom-metabox', __('Testimonial Information'), 'gt_url_custom_metabox', 'general-testimonials', 'side', 'low');
}
add_action( 'admin_init', 'gt_add_custom_metabox_info' );


//Admin area HTML and logic 
function gt_url_custom_metabox() {
    global $post;
    
    /*Gather the input data, sanitize it, and update the database.*/
    $testimonialprovidedname = sanitize_text_field( get_post_meta( $post->ID, 'testimonialprovidedname', true ) );
    update_post_meta( $post->ID, 'testimonialprovidedname', $testimonialprovidedname );
    $testimoniallabel = sanitize_text_field( get_post_meta( $post->ID, 'testimoniallabel', true ) );
    update_post_meta( $post->ID, 'testimoniallabel', $testimoniallabel );
    $testimonialurl = sanitize_text_field( get_post_meta( $post->ID, 'testimonialurl', true ) );
    update_post_meta( $post->ID, 'testimonialurl', $testimonialurl );


    $errorsprovidedname = "";
    if( isset($errorsprovidedname) ){
        echo $errorsprovidedname;
    }
   
    $errorslink = "";
    if (!preg_match("/http(s?):\/\//", $testimonialurl) && $testimonialurl != "") {
        $errorslink = "This URL is not valid";
        $testimonialurl = "http://";
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
            <input id="testimonialurl" size="37" name="testimonialurl" value="<?php if( isset($testimonialurl) ) { echo $testimonialurl; } ?>" />
        </label>
    </p>
 <?php 
}


//Save user provided field data.
function gt_save_custom_testimonialprovidedname($post_id) {
    global $post;
    
    if( isset($_POST['testimonialprovidedname']) ) {
        update_post_meta( $post->ID, 'testimonialprovidedname', $_POST['testimonialprovidedname'] );
    }
}
add_action( 'save_post', 'gt_save_custom_testimonialprovidedname' );

function gt_get_testimonialprovidedname($post) {
    $testimonialname = get_post_meta( $post->ID, 'testimonialprovidedname', true );
    return $testimonialname;
}


function gt_save_custom_testimoniallabel($post_id) {
    global $post;
    
    if( isset($_POST['testimoniallabel']) ) {
        update_post_meta( $post->ID, 'testimoniallabel', $_POST['testimoniallabel'] );
    }
}
add_action( 'save_post', 'gt_save_custom_testimoniallabel' );

function gt_get_testimoniallabel($post) {
    $testimoniallabel = get_post_meta( $post->ID, 'testimoniallabel', true );
    return $testimoniallabel;
}


function gt_save_custom_url($post_id) {
    global $post;
    
    if( isset($_POST['testimonialurl']) ) {
        update_post_meta( $post->ID, 'testimonialurl', $_POST['testimonialurl'] );
    }
}
add_action( 'save_post', 'gt_save_custom_url' );

function gt_get_url($post) {
    $testimonialurl = get_post_meta( $post->ID, 'testimonialurl', true );
    return $testimonialurl;
}


//Register the shortcode so we can show testimonials.
function gt_load_testimonials($a) {

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
    echo '<h3 class="testimonials-container__heading">' . get_option( 'general-testimonials-leading-text' ) . '</h3>';
    echo '<div class="testimonials-container__inner-wrapper">';
    foreach ($posts as $post) {
        $url_thumb = wp_get_attachment_thumb_url(get_post_thumbnail_id($post->ID));
        $url_altText = get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true);
        $providedName = gt_get_testimonialprovidedname($post);
        $label = gt_get_testimoniallabel($post);
        $link = gt_get_url($post);
        echo '<div class="testimonial">';
        if ( !empty($url_thumb) ) {
            echo '<img class="testimonial__image" src="' . $url_thumb . '" alt="' . $url_altText . '" />';
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
add_shortcode( "general_testimonials", "gt_load_testimonials" );
add_filter( 'widget_text', 'do_shortcode' );
