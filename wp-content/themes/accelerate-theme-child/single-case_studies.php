<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Accelerate Marketing
 * @since Accelerate Marketing 2.0
 */

get_header(); ?>

<div id="primary" class="site-content sidebar">
	<div class="main-content" role="main">

	<?php while ( have_posts() ) : the_post(); 
		$size = "full";
		
		$services = get_field('services');
		$client = get_field('client');
		$link = get_field('site-link');
		$image_1 = get_field('image_1');
		$image_2 = get_field('image_2');
		$image_3 = get_field('image_3'); 
		$custom_field = get_field('custom_field_name');?>


	
	<article class=“case-study”>
		<aside class="case-study-sidebar">
	
			<h2><?php the_title(); ?></h2>
		 	<h4><?php echo $services; ?></h4>
			<h4>Client: <?php echo $client; ?></h4>

			<?php the_content(); ?>

			<p class="read-more-link"><a href="<?php echo $link; ?>">Visit Live Site</a></p>
		</aside>

		<div class="case-study-images">
			<?php if($image_1) { ?>			
				<img src="<?php echo $image_1; ?>" />
			<?php } ?>

			<?php if($image_2) { ?>			
				<img src="<?php echo $image_2; ?>" />
			<?php } ?>

			<?php if($image_2) { ?>			
				<img src="<?php echo $image_2; ?>" />
			<?php } ?>
		</div>
		
			</article>
			<?php endwhile; // end of the loop. ?>
		</div><!-- .main-content -->
	</div><!-- #primary -->

<?php get_footer(); ?>