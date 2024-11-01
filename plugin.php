<?php 

/*
Plugin Name: Woocommerce Free Shipping Remaining Cost
Plugin URI: http://www.borbis.pl
Description: Shows how much money user should spend in our Woocommerce based shop to gain free shipping (if available).
Version: 1.0.1
Author: Borbis Media
Author URI: http://www.borbis.com
Requires at least: 3.8
Tested up to: 3.9.1
*/



function woocommerce_free_shipping_remaining_cost() {
	global $wpdb, $woocommerce;
	
	load_textdomain( 'shipping_remaining_cost', dirname( __FILE__ )."/".get_locale().".mo" );

     $mydbselect = $wpdb->get_var( "SELECT option_value FROM  ".$wpdb->prefix."options WHERE option_name = 'woocommerce_free_shipping_settings'" );
				$array_temp = unserialize ($mydbselect);
				$cart_total_sum = $woocommerce->cart->total;
				$free_shipping_remaining_cost = $array_temp['min_amount']-$cart_total_sum; 
				$free_shipping_remaining_cost_text = (($free_shipping_remaining_cost>0)? ' <div style=\"text-align: left; margin-bottom: 10px;\"><strong>'.__('Free shipping remaining cost:', 'shipping_remaining_cost').' '.$free_shipping_remaining_cost.' '. __('USD', 'shipping_remaining_cost').'</strong></div>' : '');

	if(is_cart()) echo '<script>jQuery( document ).ready(function() {var htmlString = jQuery(".actions").html();jQuery(".actions").html("'.$free_shipping_remaining_cost_text.'"+htmlString) });</script>'; 

}

add_action('wp_footer', 'woocommerce_free_shipping_remaining_cost');


?>