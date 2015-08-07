<?php
/**
 * Template Name:Options Template
 *
 * @package WordPress
 * @subpackage khashesalon
 */
 
 //Calling for the header to be displayed 
 get_header(); ?>
 
<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', 'page' ); ?>

			<?php endwhile; // End of the loop. ?>

 <class="background">
 <div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<?php $options = get_option( 'theme_settings' ); ?> <!--Creating an option for the options page-->
		<h3>Add a Logo<h3><p><?php if($options['custom_logo']) { ?> <!-- Adding the option of a customizable logo -->
	<a href="<?php bloginfo( 'url' ) ?>/" title="<?php bloginfo( 'name' ) ?>" rel="homepage"><img src="<?php echo $options['custom_logo']; ?>" alt="<?php bloginfo( 'name' ) ?>" /></a>
	<?php } else { ?>
	<h2><a href="<?php bloginfo( 'url' ) ?>/" title="<?php bloginfo( 'name' ) ?>" rel="homepage"><?php bloginfo( 'name' ) ?></a>
	<?php } ?></p>
	<?php
	if($options['color_scheme'] != '') { ?>
	<link rel="stylesheet" href="<?php bloginfo("template_url"); ?>/skins/<?php echo $options['color_scheme']; ?>.css" type="text/css" media="screen" />
	<?php } ?>
	<p><?php if ($options['extended_footer'] != true) { ?> <h3>Welcome!</h3> <?php } ?></p>
	<p><?php echo stripslashes($options['tracking']); ?></p>
			
		</main><!-- #main -->
	</div>
	</div><!-- #primary -->

<!-- Callings for the sidebar and the footer-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>