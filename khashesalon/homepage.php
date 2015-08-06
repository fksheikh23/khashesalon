<?php
/**
 * Template Name:Homepage Template
 *
 * @package WordPress
 * @subpackage khashesalon
 */
 
 get_header(); ?>
 
<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', 'page' ); ?>

			<?php endwhile; // End of the loop. ?>

 <class="background">
 <div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<div class="photos"> 
		<img src="http://s1.postimg.org/3nivnnc3j/image.jpg"/> 
		<img src="http://s9.postimg.org/sjaqk2ar3/image.jpg"/> 
		<img src="http://s12.postimg.org/ha4w4s0gt/image.jpg"/> 
		<img src="http://s13.postimg.org/n0g9zt4pj/image.jpg"/> 
		<img src="http://s23.postimg.org/afmtxhpnv/image.jpg"/>
		<img src="http://s21.postimg.org/531fkk06f/image.jpg"/>
		</div>
		</div>
		
		<h1>Featured Posts</h1>
		<center><div class="postlogo">
		<a href="https://phoenix.sheridanc.on.ca/~ccit2728/?p=279" title="ClickMe" id="range-logo">View Our Sale!</a>
		<a href="https://phoenix.sheridanc.on.ca/~ccit2728/?p=276" title="ClickMe" id="range-logo2">Meet Our Stylists!</a>
		<a href="https://phoenix.sheridanc.on.ca/~ccit2728/?p=274" title="ClickMe" id="range-logo3">Stay Tuned!</a>
		</div></center>
		
		<h1>Recent Posts</h1>
		<p>
			<?php $the_query = new WP_Query( 'posts_per_page=2' ); ?>
			
			<?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>

			<p><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>

			<p><?php the_excerpt(__('(more…)')); ?></p>
			
			<?php endwhile; wp_reset_postdata(); ?>
		</p>

		
		
			<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				?>

		</main><!-- #main -->
	</div>
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

