<?php
namespace Extremis\WooCommerce\Checkout;

class ShippingCustomizer {
    public function __construct() {
        add_filter('woocommerce_package_rates', [$this, 'maybeRemovePaidShipping']);
    }

    public function maybeRemovePaidShipping($rates) {
        $cart_total = (float)WC()->cart->get_cart_contents_total();

        if ($cart_total < 5000) {
            return $rates;
        }

        foreach ($rates as $rate_id => $rate) {
            if ($rate->method_id === 'flat_rate') {
                unset($rates[$rate_id]);
            }
        }

        return $rates;
    }
}
