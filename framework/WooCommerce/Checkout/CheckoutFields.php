<?php

namespace Extremis\WooCommerce\Checkout;

class CheckoutFields {
    /**
     * Allowed customer types
     *
     * @var string[]
     */
    private static array $types = ['person', 'company'];

    public function __construct() {
        add_action( 'wp_ajax_set_billing_type', [$this, 'setBillingType'] );
        add_action( 'woocommerce_checkout_update_order_review', [$this, 'setBillingType'], 99, 1 );

        add_action( 'woocommerce_init', [$this, 'setDefaultBillingType'], 99 );
    }

    public function setBillingType( string $post_data ) {
        parse_str( $post_data, $data );
        $type = $data['billing_type'] ?? 'person';

        if ( ! in_array( $type, self::$types, true ) ) {
            $type = 'person';
        }

        WC()->session->set( 'billing_type', $type );
    }

    public function setDefaultBillingType() {
        if ( ( is_admin() && ! wp_doing_ajax() ) || WC()->is_rest_api_request() || is_null( WC()->session ) ) {
            return;
        }

        if ( false !== WC()->session->get( 'billing_type', false ) ) {
            return;
        }

        $type = 'person';

        if ( is_user_logged_in() ) {
            $meta_type = get_user_meta( get_current_user_id(), 'billing_type', true );
            $type      = '' !== $meta_type ? $meta_type : $type;
        }

        WC()->session->set( 'billing_type', $type );
    }
}
