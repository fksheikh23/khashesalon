<?php

/* 
 * Footer Widgets
 */

 // Conditional that if the footer sidebar is not activated, then return to the page
 if ( ! is_active_sidebar( 'sidebar-2' ) ) {
		return;
 }
 ?>

 <div id="supplementary"> 
	<div id="footer-widgets" class="footer-widgets widget-area clear" role="complementary">
		<?php dynamic_sidebar( 'sidebar-2' ); //If widgets are added to the footer sidebard, this code will be displayed ?>
	</div>
</div>