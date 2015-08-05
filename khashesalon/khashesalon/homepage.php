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
		<img src="http://s1.postimg.org/3nivnnc3j/image.jpg" width="250" height="250"> 
		<img src="http://s9.postimg.org/sjaqk2ar3/image.jpg" width="250" height="250"> 
		<img src="http://s12.postimg.org/ha4w4s0gt/image.jpg" width="250" height="190"> 
		<img src="http://s13.postimg.org/n0g9zt4pj/image.jpg" width="250" height="250"> 
		<img src="http://s23.postimg.org/afmtxhpnv/image.jpg" width="250" height="250">
		<img src="http://s21.postimg.org/531fkk06f/image.jpg" width="250" height="250">
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

