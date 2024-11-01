===  WooCommerce Sold Individually for Variations ===
Contributors: webdados, ptwooplugins
Tags: woocommerce, ecommerce, e-commerce, variations, webdados
Requires at least: 5.4
Tested up to: 6.4
Requires PHP: 7.0
Stable tag: 1.2

This plugin allows you to apply the “Sold individually” WooCommerce product setting to the whole variable product (including its variations), thus not allowing the customer to buy more than one unit of the variable product, even if it’s a different variation. You can also set that a specific variation is “Sold individually”.

== Description ==

= Option 1: Sell the whole variable product individually =

This plugin allows you to apply the “Sold individually” WooCommerce product setting to the whole variable product (including its variations), thus not allowing the customer to buy more than one unit of the variable product, even if it’s a different variation.

Example: Your WooCommerce store has a wine that you sell in 2-pack or 6-pack boxes, and, let’s say, for logistical reasons you don’t want the customer to buy both in a single order. With this WooCommerce extension, the client can only pick one unit of one of the variations.

Inspired by [this GitHub thread](https://github.com/woocommerce/woocommerce/issues/19443).

= Option 2: Sell a variation individually =

You can also set that a specific variation is “Sold individually”. In that scenario, the variable product should NOT be set as “Sold individually”.

Example: Your WooCommerce store sells music, both as physical CDs and digital downloads. Each album is a product with variations, allowing the customer to either buy the physical CD (as many as he wants) or the audio download (sold individually).

= Other (premium) plugins =

Already know our other WooCommerce (premium) plugins?

* [Simple Custom Fields for WooCommerce Blocks Checkout](https://ptwooplugins.com/product/simple-custom-fields-for-woocommerce-blocks-checkout/) - Add custom fields to the new WooCommerce Block-based Checkout
* [Simple WooCommerce Order Approval](https://ptwooplugins.com/product/simple-woocommerce-order-approval/) - The hassle-free solution for WooCommerce order approval before payment
* [Shop as Client for WooCommerce](https://ptwooplugins.com/product/shop-as-client-for-woocommerce-pro-add-on/) - Quickly create orders on behalf of your customers
* [Taxonomy/Term and Role based Discounts for WooCommerce](https://ptwooplugins.com/product/taxonomy-term-and-role-based-discounts-for-woocommerce-pro-add-on/) - Easily create bulk discount rules for products based on any taxonomy terms (built-in or custom)
* [DPD / SEUR / Geopost Pickup and Lockers network for WooCommerce](https://ptwooplugins.com/product/dpd-seur-geopost-pickup-and-lockers-network-for-woocommerce/) - Deliver your WooCommerce orders on the DPD and SEUR Pickup network of Parcelshops and Lockers in 21 European countries

== Installation ==

* Use the included automatic install feature on your WordPress admin panel and search for “WooCommerce Sold Individually for Variations”.
* Option 1: Go to your variable product inventory settings and activate the “Sold individually” and “Apply Sold individually to variations” options.
* Option 2: Go to your variation settings and activate the “Sold individually” option.

== Frequently Asked Questions ==

= This plugin allows adding another variation to the cart if it has meta. Is it possible to block this? =

The way we’re checking for the existence of another variation in the cart is the same WooCommerce uses to find a product, which does not consider the same product with a different meta to be the same product.

If you want to override this behavior and want to avoid another variation, with a different meta, to be allowed on the cart, return true to the `woo_sold_individually_for_variations_ignore_cart_meta` filter.

= Can I contribute with a translation? =

Sure. Go to [GlotPress](https://translate.wordpress.org/projects/wp-plugins/woo-sold-individually-for-variations) and help us out.

= Is this plugin compatible with the new WooCommerce High-Performance Order Storage? =

Yes.

= Is this plugin compatible with the new WooCommerce block-based Cart and Checkout? =

Yes.

= I need help, can I get technical support? =

This is a free plugin. It’s our way of giving back to the wonderful WordPress community.

There’s a support tab on the top of this page, where you can ask the community for help. We’ll try to keep an eye on the forums but we cannot promise to answer support tickets.

If you reach us by email or any other direct contact means, we’ll assume you need, premium, and of course, paid-for support.

= Where do I report security vulnerabilities found in this plugin? =  
 
You can report any security bugs found in the source code of this plugin through the [Patchstack Vulnerability Disclosure Program](https://patchstack.com/database/vdp/woo-sold-individually-for-variations). The Patchstack team will assist you with verification, CVE assignment and take care of notifying the developers of this plugin.

== Screenshots ==
 
1. Variable product settings
2. Error message when adding second variation to the cart
3. Variation specific “Sold individually” field

== Changelog ==

= 1.2 - 2024-03-27 =
* [NEW] New filter `woo_sold_individually_for_variations_ignore_cart_meta` (see FAQ)
* [DEV] Set `Requires Plugins` tag to `woocommerce`
* [DEV] Tested with WordPress 6.5-RC3-57875 and WooCommerce 8.8.0-beta.1

= 1.1 - 2023-12-13 =
* Declare WooCommerce block-based Cart and Checkout compatibility
* Requires WordPress 5.4
* Tested with WordPress 6.5-alpha-57159 and WooCommerce 8.4.0

= 1.0 - 2022-07-03 =
* High-Performance Order Storage compatible (in beta and only on WooCommerce 7.1 and above)
* CSS fix
* Requires WooCommerce 5.0
* Tested with WordPress 6.3-beta2-56100 and WooCommerce 7.9.0-beta.2

= 0.7 - 2022-06-29 =
* New brand: PT Woo Plugins 🥳
* Requires WordPress 5.0, WooCommerce 3.0 and PHP 7.0
* Tested with WordPress 6.1-alpha-53556 and WooCommerce 6.7.0-beta.2

= 0.6 - 2021-03-10 =
* Change the “You cannot add another...” message to use the main product name instead of the variation name
* Tested with WordPress 5.8-alpha-50516 and WooCommerce 5.1.0

= 0.5 =
* Tested with WordPress 5.5-alpha-47783 and WooCommerce 4.2.0-beta.1

= 0.4 =
* Fix jQuery error

= 0.3 =
* Tested with WordPress 5.2.5-alpha and WooCommerce 3.8.0

= 0.2 =
* “Sold individually” option at the product variation level, so you can sell a variation individually but not all of them
* Tested with WordPress 5.1 and WooCommerce 3.5.5

= 0.1.2 =
* WooCommerce CRUD functions to save product meta

= 0.1.1 =
* readme.txt and plugin description improvements
* Check for WooCommerce 3.0 (or above)

= 0.1 =
* Initial release