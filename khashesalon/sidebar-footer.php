<?php

/* 
 * Footer Widgets
 */

 if ( ! is_active_sidebar( 'sidebar-2' ) ) {
		return;
 }
 ?>
 
 <div id="supplementary"> 
	<div id="footer-widgets" class="footer-widgets widget-area clear" role="complementary">
		<?php dynami_sidebar( 'sidebar-2' ); //If widgets are added to the footer sidebard, this code will be displayed ?>
	</div>
</div>