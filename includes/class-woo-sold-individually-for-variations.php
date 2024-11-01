<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Our main class
 *
 */
final class Woo_Sold_Individually_for_Variations {
	
	/* ID and Version */
	public $id = 'woo-sold-individually-for-variations';

	/* Single instance */
	protected static $_instance = null;

	/* Constructor */
	public function __construct() {
		// Hooks
		$this->init_hooks();
	}

	/* Ensures only one instance of our plugin is loaded or can be loaded */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/* Hooks */
	private function init_hooks() {
		add_action( 'woocommerce_product_options_sold_individually', array( $this, 'add_field_to_product' ) );
		add_action( 'woocommerce_process_product_meta', array( $this, 'save_field_to_product' ) );
		add_action( 'woocommerce_product_after_variable_attributes', array( $this, 'add_field_to_variation' ), 10, 3 );
		add_action( 'woocommerce_save_product_variation', array( $this, 'save_field_to_variation' ), 10, 2 );
		add_action( 'woocommerce_add_to_cart_sold_individually_found_in_cart', array( $this, 'intercerpt_add_to_cart_sold_individually_found_in_cart' ), 99, 5 );
		add_filter( 'woocommerce_is_sold_individually', array( $this, 'variation_is_sold_individually' ), 10, 2 );
	}

	/* Add field to product */
	public function add_field_to_product() {
		global $product_object;
		?>
		<div class="options_group show_if_variable" id="_sold_individually_apply_variations_outter">
			<?php
			woocommerce_wp_checkbox(
				array(
					'id'            => '_sold_individually_apply_variations',
					'wrapper_class' => 'show_if_variable',
					'label'         => __( 'Apply “Sold individually” to variations', 'woo-sold-individually-for-variations' ),
					'description'   => __( 'Enable this to only allow one of this product, even if it\'s a different variation, to be bought in a single order', 'woo-sold-individually-for-variations' ),
				)
			);
			?>
		</div>
		<style type="text/css">
			.inventory_sold_individually.sold_individually_shown {
				display: block !important;
			}
		</style>
		<script type="text/javascript">
			jQuery( document ).ready( function() {
				function sold_individually_apply_variations_show_hide() {
					if ( jQuery( '#_sold_individually' ).is(' :checked ' ) ) {
						jQuery( '#_sold_individually_apply_variations_outter .form-field' ).show();
						jQuery( '.inventory_sold_individually' ).addClass( 'sold_individually_shown' );
					} else {
						jQuery( '#_sold_individually_apply_variations_outter .form-field' ).hide();
						jQuery( '.inventory_sold_individually' ).removeClass( 'sold_individually_shown' );
					}
				}
				setTimeout( function() {
					sold_individually_apply_variations_show_hide();
				}, 100);
				jQuery( '#_sold_individually' ).change( function() {
					sold_individually_apply_variations_show_hide();
				} );
			});
		</script>
		<?php
	}

	/* Save field to product */
	public function save_field_to_product( $post_id ) {
		$sold_individually_apply_variations = ! empty( $_POST['_sold_individually_apply_variations'] ) && ! empty( $_POST['_sold_individually'] ) ? 'yes' : 'no';
		$product = wc_get_product( $post_id );
		$product->update_meta_data( '_sold_individually_apply_variations', $sold_individually_apply_variations );
		$product->save();
	}

	/* Add field to variation */
	public function add_field_to_variation( $loop, $variation_data, $variation ) {
		$variation_object = wc_get_product( $variation->ID );
		?>
		<div>
			<?php
			woocommerce_wp_checkbox(
				array(
					'id'            => "sold_variation_individually{$loop}",
					'name'          => "sold_variation_individually[$loop]",
					'label'         => '&nbsp;'.__( 'Sold individually', 'woo-sold-individually-for-variations' ),
					'description'   => __( 'Enable this to only allow one of this variation to be bought in a single order', 'woo-sold-individually-for-variations' ),
					'desc_tip'      => true,
					'wrapper_class' => 'form-row form-row-full',
					'value'         => $variation_object->get_meta( '_sold_variation_individually' ),
					'cb_value'      => 'yes',
				)
			);
			?>
		</div>
		<?php
	}

	/* Save field to variation */
	public function save_field_to_variation( $variation, $i ) {
		$sold_variation_individually = ! empty( $_POST['sold_variation_individually'][$i] ) ? 'yes' : 'no';
		$variation = wc_get_product( $variation );
		$variation->update_meta_data( '_sold_variation_individually', $sold_variation_individually );
		$variation->save();
	}

	/* Intercept add to cart */
	public function intercerpt_add_to_cart_sold_individually_found_in_cart( $found_in_cart, $product_id, $variation_id, $cart_item_data, $cart_id ) {
		// It's a variation and not found in cart? Let's check for other variations
		if ( intval( $variation_id ) > 0 && !$found_in_cart ) {
			// Get parent (variable) product
			if ( $__product = wc_get_product( $product_id ) ) {
				if ( $__product->is_type( 'variable' ) && $__product->get_meta( '_sold_individually_apply_variations' ) === 'yes' ) {
					// Get variations
					if ( $variations = $__product->get_available_variations() ) {
						// Check if each variation is already in cart
						foreach ( $variations as $temp ) {
							// We do not bother to check for the current variation
							if ( intval( $temp['variation_id'] ) != intval( $variation_id ) ) {
								$__product_variation = wc_get_product( $temp['variation_id'] );
								$__cart_id = WC()->cart->generate_cart_id( $product_id, $__product_variation->get_id(), $temp['attributes'], $cart_item_data );
								$cart_item_key = WC()->cart->find_product_in_cart( $__cart_id );
								if ( $cart_item_key ) {
									if ( WC()->cart->cart_contents[ $cart_item_key ]['quantity'] > 0 ) {
										// Found a variation already in cart
										add_filter( 'woocommerce_cart_product_cannot_add_another_message', array( $this, 'cannot_add_another_message' ), 10, 2 );
										return true;
									}
								}
								// Also search ignoring meta?
								if ( apply_filters( 'woo_sold_individually_for_variations_ignore_cart_meta', false ) ) {
									if ( isset( WC()->cart->cart_contents ) && is_array( WC()->cart->cart_contents ) && count( WC()->cart->cart_contents ) > 0 ) {
										foreach( WC()->cart->cart_contents as $key => $cart_item ) {
											if ( $cart_item['product_id'] == $product_id ) {
												// Found a variation already in cart
												add_filter( 'woocommerce_cart_product_cannot_add_another_message', array( $this, 'cannot_add_another_message' ), 10, 2 );
												return true;
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
		return $found_in_cart;
	}

	/* Replace the variation name with the product name */
	public function cannot_add_another_message( $message, $product_data ) {
		if ( $product_data->get_type() === 'variation' ) {
			if ( $parent_product = wc_get_product( $product_data->get_parent_id() ) ) {
				// A bit hacky...
				$message = str_replace( '"'.$product_data->get_name().'"', '"'.$parent_product->get_name().'"', $message );
			}
		}
		return $message;
	}

	/* Check if variation is sold individually */
	public function variation_is_sold_individually( $bool, $product ) {
		if ( $product->is_type( 'variation' ) && ! $bool ) {
			return $product->get_meta( '_sold_variation_individually' ) === 'yes';
		}
		return $bool;
	}

}

/* If you're reading this you must know what you're doing ;-) Greetings from sunny Portugal! */
