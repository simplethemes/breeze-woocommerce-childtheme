<?php

$sidebar = 'sidebar-shop';
// check for custom field sidebars => false to force wide page
$wide = get_post_meta($post->ID, "sidebars", $single = true) ==  "false";

if ( is_active_sidebar( $sidebar ) && !$wide) :

	do_action('skeleton_before_sidebar');
	dynamic_sidebar($sidebar);
	do_action('skeleton_after_sidebar');

endif;