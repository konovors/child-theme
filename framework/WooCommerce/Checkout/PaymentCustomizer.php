<?php
namespace Extremis\WooCommerce\Checkout;

class PaymentCustomizer {
    public function __construct() {
        add_filter( 'woocommerce_available_payment_gateways', [$this, 'filterAvailableGateways'], 99, 1 );
    }

    public function filterAvailableGateways( array $gateways ) {
        if ( is_admin() ) {
            return $gateways;
        }

        $customer = WC()->session->get( 'customer', false );

        $billing_type = WC()->session->get( 'billing_type' );

        // var_dump( $billing_type );

        if ( 'company' === $billing_type ) {
            // unset($gateways['bacs']);
            unset( $gateways['cod'] );

            return $gateways;
        }

        unset( $gateways['cheque'] );

        $chosen_shipping_methods = WC()->session->chosen_shipping_methods;
        $chosen_shipping_methods = reset( $chosen_shipping_methods );

        $shipping_methods = explode( ':', $chosen_shipping_methods );

        if ( is_array( $shipping_methods ) ) {
            $shipping_methods = reset( $shipping_methods );
        }

        if ( in_array( $shipping_methods, ['flat_rate', 'free_shipping'] ) ) {
            unset( $gateways['bacs'] );
        }

        if ( 'local_pickup' === $shipping_methods ) {
            unset( $gateways['cod'] );
        }

        return $gateways;
    }
}
