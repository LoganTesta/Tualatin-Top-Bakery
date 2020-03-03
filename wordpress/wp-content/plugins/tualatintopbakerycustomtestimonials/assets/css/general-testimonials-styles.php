
<?php

header("Content-type: text/css; charset: UTF-8");

require('../../../../../wp-load.php');
include( plugin_dir_path(__FILE__) . "/general-testimonials.php");

$numberOfTestimonialsPerRow = (int)( get_option( 'general-testimonials-testimonials-per-row' ) );
if( $numberOfTestimonialsPerRow <= 0 ) {
    $numberOfTestimonialsPerRow = 2;
}
$testimonialWidth = 100/$numberOfTestimonialsPerRow;

$testimonialImageWidthHeight = (int)( get_option( 'general-testimonials-image-width-height' ) );
if( $testimonialImageWidthHeight <= 0 ) {
    $testimonialImageWidthHeight = 150;
} else if( 0 < $testimonialImageWidthHeight && $testimonialImageWidthHeight < 60 ) {
    $testimonialImageWidthHeight = 60;
} else if ( $testimonialImageWidthHeight > 150 ) {
    $testimonialImageWidthHeight = 150;
}

?>

.testimonials-container__heading { padding-bottom: 0; text-align: center; }
.testimonials-container__inner-wrapper { padding-top: 30px; }

.testimonial { padding-bottom: 40px; }
.testimonial__image { display: block; width: <?php echo $testimonialImageWidthHeight; ?>px; height: <?php echo $testimonialImageWidthHeight; ?>px; margin-bottom: 15px; margin-left: auto; margin-right: auto; border-radius: <?php echo get_option( 'general-testimonials-border-radius' ); ?>px; }
.testimonial__title { }
.testimonial__content { padding-bottom: 5px; }
.testimonial__provided-name { font-size: 17px; font-weight: bold; }
.testimonial__label { font-size: 17px; font-style: italic; }

.testimonial:last-of-type { padding-bottom: 0; }
.testimonials-container__inner-wrapper::after { content: ""; display: block; clear: both; }
.testimonial__link { font-size: 17px; font-weight: bold; }



@media only screen and (min-width: 700px){
    .testimonial { float: left; width: <?php echo $testimonialWidth; ?>%; padding: 0 15px 15px 15px; }
    
    .testimonial__image { float: left; margin-left: 0; margin-right: 15px; }
    
    .testimonial:nth-of-type(<?php echo $numberOfTestimonialsPerRow; ?>n+1) { padding-left: 0; }
    .testimonial:nth-of-type(<?php echo $numberOfTestimonialsPerRow; ?>n+<?php echo $numberOfTestimonialsPerRow; ?>) { padding-right: 0; }
    .testimonial:last-of-type { padding-bottom: 15px; }
}



@media only screen and (min-width: 1200px){ 
     
}
