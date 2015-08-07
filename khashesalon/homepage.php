<?php
/**
 * Template Name:Homepage Template
 *
 * @package WordPress
 * @subpackage khashesalon
 */
 
 //Calling for the header to be displayed on the homepage
 get_header(); ?>
 
<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', 'page' ); ?>

			<?php endwhile; // End of the loop. ?>

 <class="background">
 <!-- The code below is for creating an enhanced customization of displayed photos -->		
 <div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<div class="photos"> 
		<img src="http://s1.postimg.org/3nivnnc3j/image.jpg"/> <!--Grabbing the photos externally-->
		<img src="http://s9.postimg.org/sjaqk2ar3/image.jpg"/> 
		<img src="http://s12.postimg.org/ha4w4s0gt/image.jpg"/> 
		<img src="http://s13.postimg.org/n0g9zt4pj/image.jpg"/> 
		<img src="http://s23.postimg.org/afmtxhpnv/image.jpg"/>
		<img src="http://s21.postimg.org/531fkk06f/image.jpg"/>
		</div>
		</div>
		
		
<!-- The code below is for creating an enhanced customization of featured posts-->		
		<h1>Featured Posts</h1>
		<center><div class="postlogo"> <!-- Each link directs the users to different posts on the website-->
		<a href="https://phoenix.sheridanc.on.ca/~ccit2728/?p=279" title="ClickMe" id="range-logo">View Our Sale!</a>
		<a href="https://phoenix.sheridanc.on.ca/~ccit2728/?p=276" title="ClickMe" id="range-logo2">Meet Our Stylists!</a>
		<a href="https://phoenix.sheridanc.on.ca/~ccit2728/?p=274" title="ClickMe" id="range-logo3">Stay Tuned!</a>
		</div></center>
		
		
		<h1> Our Custom Field & MetaBox!  </h1>
		<?php the_meta(); ?>
		
		<h1>Recent Posts</h1>
		<p>
			<?php $the_query = new WP_Query( 'posts_per_page=2' ); ?>
			
			<?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>

			<p><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>

			<p><?php the_excerpt(__('(more…)')); ?></p>
			
			<?php endwhile; wp_reset_postdata(); ?>
		</p>

			
		</main><!-- #main -->
	</div>
	</div><!-- #primary -->

<!--Calling for the sidebar and footer to be displayed-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>

