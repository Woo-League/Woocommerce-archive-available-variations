<?php
/*
Plugin Name: WooCommerce Archive Available Variations
Plugin URI:
Description: Show avaiable variatios in archive page
Version: 1.0
Author: Mithu A Quayium
Author URI:
License: GPL2
Text Domain: WAAV
Domain Path: /languages
*/

if ( ! function_exists( 'pri' ) ) {
	function pri( $data ) {
		echo '<pre>';
		print_r( $data );
		echo '</pre>';
	}
}

define( 'WAAV_PLUGIN_DIR', dirname( __FILE__ ) );
define( 'WAAV_ASSET_URL', plugins_url( 'assets', __FILE__ ) );

class WAAV_Init{

    /**
     * Instance
     *
     * @since 1.0.0
     *
     * @access private
     * @static
     */
    private static $_instance = null;

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 1.0.0
     *
     * @access public
     * @static
     *
     * @return ${ClassName} An instance of the class.
     */
    public static function instance() {

        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;

    }

    public function __construct() {
	    add_action('woocommerce_after_shop_loop_item', [ $this, 'display_variation_options' ], 20);
	    add_action( 'wp_enqueue_scripts', [ $this, 'wp_enqueue_scripts' ] );
    }

	function display_variation_options() {
		global $product;

		if ($product->is_type('variable')) {
			$available_variations = $product->get_available_variations();
			$attributes = $product->get_variation_attributes();

			echo '<div class="variation-options">';

			foreach ($attributes as $attribute_name => $options) {
				echo '<div class="variation">';
//			echo '<span>' . wc_attribute_label($attribute_name) . '</span>: ';
				foreach ($options as $option) {
					echo '<span>' . ucfirst( $option ) . '</span> ';
				}
				echo '</div>';
			}

			echo '</div>';
		}
	}

	public function wp_enqueue_scripts() {
		wp_enqueue_style( 'waav-public-css', WAAV_ASSET_URL . '/css/public.css' );
	}
}

WAAV_Init::instance();
//
/*function display_available_sizes_on_shop_page() {
	global $product;

	if ( $product->is_type('variable') ) {
		$available_variations = $product->get_available_variations();
		$sizes = array();

		foreach ( $available_variations as $variation ) {
			$sizes[] = $variation['attributes']['attribute_pa_size'];
		}

		$sizes = array_unique($sizes);
		echo '<p class="available-sizes">Sizes: ' . implode(', ', $sizes) . '</p>';
	}
}
add_action( 'woocommerce_after_shop_loop_item', 'display_available_sizes_on_shop_page', 20 );*/
