<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

?>

<?php
/**
 * woocommerce_before_single_product hook.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
    echo get_the_password_form();
    return;
}
?>

<!-- Main Info -->
<section class="main-info">
    <div class="container">
        <?php //woocommerce_show_product_sale_flash(); //10 ?>
        <?php woocommerce_show_product_images(); //20 ?>

        <?php woocommerce_template_single_meta(); //40 ?>
        <?php woocommerce_template_single_title(); //5 ?>
        <?php
        $attributes = $product->get_attributes();
        if ( $product->has_weight() ) {
            echo $product->get_weight();
        }
        ?>
        <?php woocommerce_template_single_excerpt(); //20 ?>
        <?php woocommerce_template_single_price(); //10 ?>
        <?php woocommerce_template_single_add_to_cart(); //30 ?>
        <?php woocommerce_template_single_sharing(); //50 ?>
    </div>
</section>
<!-- Main Info -->

<?php do_action( 'woocommerce_after_single_product' ); ?>