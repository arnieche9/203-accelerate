<?php /* Template Name: CustomPageT1 */ 


get_header(); ?>


<div id="primary" class="home-page hero-content">

<div class="about-heading" role="main">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php the_content(); ?>
		<h3>Accelerate is a strategy and marketing agency located in the heart of NYC. Our goal is to build businesses by making our clients visible and making their customers smile.</h3>
	
	<?php endwhile; // end of the loop. ?>
</div><!-- .main-content -->
</div><!-- #primary -->

<section class="about-container">

     <div class="services-header">	 				
		  <h6><?php echo get_field('about_us');?></h6>
		  <p><?php echo get_field('bio');?></p>
 	 </div>

<div class="services-container">
		<?php query_posts('post_type=services_page');?>
			<?php while ( have_posts() ): the_post();
				$image= get_field('image_icon');
				$size= "medium"; ?>_

		<div class="services-content">		
				<figure class="services-icon">
					<?php echo wp_get_attachment_image($image,$size);?>
				</figure>
				<div class="services-text">
					<h2><?php the_title();?></h2>
					<?php the_content();?>
				</div>
		</div>
			<?php endwhile;?>
		<?php wp_reset_query();?>
</div>

	<div id="contact-us"  class="site-footer clearfix" role="contactinfo">
		<h4><?php echo get_field('ask_us');?>&nbsp;<a class="button" href="<?php echo site_url('/contact-us') ?>">Contact Us</a></h4>
	</div>

</section>


<?php get_footer(); ?>
