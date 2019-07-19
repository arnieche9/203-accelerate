<?php
/**
 * The template for displaying contact pages
 
 */

get_header(); ?>

	<div id="primary" class="site-content sidebar"class="body">
		<div class="main-content" role="main">
            <?php while ( have_posts() ) : the_post(); ?>
            <h2><?php the_title(); ?></h2>
				<?php the_content(); ?>
            <?php endwhile; // end of the loop. ?>
            
		</div><!-- .main-content -->
	</div><!-- #primary -->

<?php get_footer(); ?>
