<?php
/**
 * Template Name: WooCommerce Page
*/

get_header();

do_action('skeleton_content_wrap');

echo '<div class="innerpad">';
woocommerce_content();
echo '</div>';

do_action('skeleton_content_wrap_close');

get_sidebar('shop');

get_footer();

?>