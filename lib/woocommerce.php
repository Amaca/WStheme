<?php

namespace Roots\WStheme\Woocommerce;


/*---------------------------------------------------
Woocommerce support
--------------------------------------------------*/
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\\woocommerce_support' );


/*---------------------------------------------------
Woocommerce - Button Add To Cart
--------------------------------------------------*/
function woo_custom_cart_button_text() {

    return __( 'Aggiungi al carrello', 'woocommerce' );

}
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_cart_button_text' );    // 2.1 +


/*---------------------------------------------------
Woocommerce - Get Product Category thumbnail
--------------------------------------------------*/
function woocommerce_category_image() {

    global $wp_query;
    $cat = $wp_query->get_queried_object();
    $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
    $image = wp_get_attachment_url( $thumbnail_id );
    if ( $image ) {
        echo '<img src="' . $image . '" alt="" />';
    }

}
add_action( 'woocommerce_archive_description', 'woocommerce_category_image', 2 );


/*---------------------------------------------------
Woocommerce - Subcategory
--------------------------------------------------*/
function bulk_upsell_add_to_cart_action() {
	if ( ! empty( $_GET['add-upsells-to-cart'] ) ) {
		$product_id = absint( $_GET['add-upsells-to-cart'] );
		$product    = wc_get_product( $product_id );

		if ( $product ) {
			$upsell_ids = $product->get_upsells();

			if ( $upsell_ids ) {
				$count = 0;

				foreach ( $upsell_ids as $upsell_id ) {
					if ( WC()->cart->add_to_cart( $upsell_id ) ) {
						$count ++;
					}
				}

				wc_add_notice( sprintf( _n( 'Added %d item to the cart', 'Added %d items to the cart', $count ), $count ) );
			}
		}
	}
}
add_action( 'wp_loaded', 'bulk_upsell_add_to_cart_action', 20 );


/*---------------------------------------------------
Woocommerce - Cart Breadcrubms
--------------------------------------------------*/
function cart_breadcrumbs() {

    global $woocommerce;
    $cart_url = $woocommerce->cart->get_cart_url();
    $checkout_url = $woocommerce->cart->get_checkout_url();
    //$payment_page = get_checkout_payment_url(woocommerce_get_page_id( 'pay' ));

    $bread = '<ul class="bread-cart">';
    if (is_cart()) {
        $bread .= '<li><a href="'. $cart_url .'">' . lang('Carrello') . '</a></li>';
    } else if (is_checkout()) {
        $bread .= '<li><a href="'. $cart_url .'">' . lang('Carrello') . '</a></li>';
        $bread .= '<li>' . lang('Checkout') . '</li>';
    } else if (is_checkout()) {
        $bread .= '<li><a href="'. $cart_url .'">' . lang('Carrello') . '</a></li>';
        $bread .= '<li><a href="'. $checkout_url .'">' . lang('Checkout') . '</a></li>';
        $bread .= '<li>' . lang('Riepilogo') . '</li>';
    }
    $bread .= '</ul>';

    return $bread;
}


/*---------------------------------------------------
Woocommerce - Disable downloadable products
--------------------------------------------------*/
function cheapmaal_woocommerce_account_menu_items_callback($items) {
    unset( $items['downloads'] );
    return $items;
}
add_filter('woocommerce_account_menu_items', 'cheapmaal_woocommerce_account_menu_items_callback', 10, 1);


?>