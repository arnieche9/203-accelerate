<?php
/**

 * The template for 404 page
 * @package WordPress
 * @subpackage Accelerate Marketing
 * @since Accelerate Marketing 2.0
 */

get_header(); ?>





<section class="error-container">
    <div class="page-404-error">
      <h1>404 error! Uh oh, You got lost buddy! This page doesn't exist or has been deleted! </h1>
    </div>
    <div class="page-404-image"></div>
  
    <div class="page-404-header">
      <h2>Need help finding your way home? </h2><a class="button" href="<?php echo site_url('/homepage') ?>">Search</a>
       
    </div>
     
    
</section>

<?php get_footer(); ?>






