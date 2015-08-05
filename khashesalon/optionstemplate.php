<?php
/**
 * Template Name:Options Template
 *
 * @package WordPress
 * @subpackage khashesalon
 */
 
 get_header(); ?>
 
 <div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		
		<html> 
		<title> Background Colors </title> 
		<body> 
		<h1> <b> www.infolet.org </b> </h1>
		<form name="myform"> 
			<input type="text" name="colorname"> 
			<input type = "button" value = "Change color" onclick = "changecolor()"> 
		</form> 
		</body> 
		
		<script type = "text/javascript"> 
		function changecolor() 
		{ 
		var clr = document.myform.colorname.value; 
		document.bgColor = clr; } 
		</script> 
		</html>

		
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

