<?php
/**
 * Template Name:Homepage Template
 *
 * @package WordPress
 * @subpackage khashesalon
 */
 
 get_header(); ?>
 
 <div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		
		<div class="photos"> 
		<img src='images/01.jpg' /> 
		<img src="images/02.jpg" /> 
		<img src="images/03.jpg" /> 
		<img src="images/04.jpg" /> 
		<img src="images/05.jpg" /> 
		<img src="images/06.jpg" />
		<img src="images/07.jpg" /> 
		<img src="images/08.jpg" />
		<img src="images/10.jpg" /> 
		<img src="images/11.jpg" /> 
		<img src="images/13.jpg" /> 
		<img src="images/14.jpg" /> 
		</div>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', 'page' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

