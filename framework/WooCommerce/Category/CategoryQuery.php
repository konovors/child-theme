<?php

namespace Extremis\WooCommerce\Category;

use WP_Query;

class CategoryQuery {
    public function __construct() {
        add_action('init', [$this, 'addActions']);
    }

    public function addActions(): void {
        if (is_product_category()) {
            return;
        }

        add_action('woocommerce_product_query', [$this, 'overrideCategoryQuery'], 99, 1);
    }

    public function overrideCategoryQuery(WP_Query $q): void {
        // $term = get_term_by('slug', get_query_var('product_cat'), 'product_cat');

        // $tax_query = $q->get('tax_query');
        // $tax_query[] = [
        //     'taxonomy'         => 'product_cat',
        //     'field'            => 'term_id',
        //     'terms'            => $term->term_id,
        //     'include_children' => false,
        //     'operator'         => 'IN'
        // ];

        // $q->set('tax_query', $tax_query);

        $meta_query = $q->get('meta_query');
        $meta_query[] = [
            'key' => '_stock_status',
            'compare' => '=',
            'value' => 'instock'
        ];
        $q->set('meta_query', $meta_query);
    }
}
