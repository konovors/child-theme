<?php
namespace Extremis\WooCommerce\Product;

class DescAttributes {
    private $atts = [];

    private $labels = [];

    public function __construct() {
        add_filter('woocommerce_before_main_content', [$this, 'loadCategoryAtts'], 99);
        add_filter('woocommerce_after_shop_loop_item_title', [$this, 'showProductAtts'], 99);
    }

    public function loadCategoryAtts() {
        if (!is_product_category()) {
            return;
        }

        $this->labels = wc_get_attribute_taxonomy_labels();
        $this->atts   = get_term_meta(
            get_term_by('slug', get_query_var('product_cat'), 'product_cat')->term_id,
            '_product_cat_atts',
            true
        );
    }

    public function showProductAtts() {
        global $product;

        $display_atts = [];

        if (empty($display_atts)) {
            return;
        }

        foreach ($this->atts as $attribute) {
            $att_value = $product->get_attribute($attribute);
            if ($att_value != '') {
                $display_atts[$this->labels[$attribute]] = $att_value;
            }
        }
        ?>
        <table class="woocommerce-product-attributes shop_attributes">
            <tbody>
            <?php foreach ($display_atts as $label => $value) : ?>
                <tr class="woocommerce-product-attributes-item">
                    <th class="woocommerce-product-attributes-item__label"><?= $label; ?></th>
                    <td class="woocommerce-product-attributes-item__value"><?= $value; ?></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
        <?php
    }
}
