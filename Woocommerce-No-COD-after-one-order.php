<?php

/*
Plugin Name: NO COD
Plugin URI: thehimalayanyogi.buzz
Description: A wordpress plugin to not allow users to use COD after one order.
Version: 1.0
Author: Shivendra Kumar
*/

function check_if_user_eligible_for_cod( $available_gateways ) {
    if ( ! is_checkout() ) {
        return $available_gateways;
    }
    $user = wp_get_current_user();
    if ( ! $user->exists() ) {
        return $available_gateways;
    }
    $orders = wc_get_orders( array(
        'customer_id' => $user->ID,
    ) );
    if ( count( $orders ) > 0 && isset( $available_gateways['cod'] ) ) {
        unset( $available_gateways['cod'] );
        wc_add_notice( 'You are not eligible to use COD for your next order.', 'error' );
    }
    return $available_gateways;
}
add_filter( 'woocommerce_available_payment_gateways', 'check_if_user_eligible_for_cod' );




?>
