
<?php

header("Content-type: text/css; charset: UTF-8");

require('../../../../../wp-load.php');
include( plugin_dir_path(__FILE__) . "/general-testimonials.php");

?>

/* */
.testimonials-container__heading { text-align: center; }
.testimonials-container__inner-wrapper { padding-top: 15px; }

.testimonial { padding-bottom: 40px; }
.testimonial__image { display: block; margin-bottom: 15px; margin-left: auto; margin-right: auto; border-radius: <?php echo get_option( 'general-testimonials-border-radius' ); ?>px; }
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
