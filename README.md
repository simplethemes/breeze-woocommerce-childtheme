#WooCommerce/Breeze child theme setup


This is an example setup for WooCommerce using the Breeze Child theme.

<a href="http://themes.simplethemes.com/breeze/">Theme Demo</a> | <a href="http://www.simplethemes.com/wordpress-themes/theme/breeze">Purchase Theme</a>

------

__Instructions:__

* Add the following files to your existing child theme as this is not a complete child theme package.
* Create a "Shop" sidebar under Appearance &rarr; Theme Options &rarr; Sidebars with a named value of "sidebar-shop".
* To edit the WooCommerce styles, edit ./woocommerce/woocommerce.css or compile directly from woocommerce.less.


__What it does:__

* Adds support for WooCommerce
* Removes default WooCommerce wrappers
* Adds Breeze theme wrappers
* Adds column support for dynamic "Shop" sidebar
* Disables WooCommerce CSS
* Adds WooCommerce CSS to child theme (to ensure it won't be overwritten on update)