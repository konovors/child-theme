<?php
namespace Extremis\WooCommerce\Category;

use WP_Term;

/**
 * This class adds the attributes to the category taxonomy
 *
 * These attributes will be shown to below the product price.
 */
class CategoryAtts {
    public function __construct() {
        add_action('product_cat_edit_form_fields', [$this, 'termEditAtts'], 11);
        add_action('edit_product_cat', [$this, 'saveAttributeData']);
    }

    public function termEditAtts(WP_Term $term): void {
        ?>
        <tr class="form-field term-wysiwyg-description-wrap">
            <th scope="row"><label for="product_cat_atts"><?= __('Category Attributes', 'knv'); ?></label></th>
            <td>
                <?php $this->outputSelectField($term->term_id); ?>
                <!-- <p class="description">
                    <?= __('The description is not prominent by default; however, some themes may show it.'); ?>
                </p> -->
            </td>

        </tr>
        <?php
    }

    public function outputSelectField(int $term_id): void {
        $term_atts = get_term_meta($term_id, '_product_cat_atts', true);
        if ($term_atts == '') {
            $term_atts = [];
        }

        echo '<select name="_category_atts[]" id="product_cat_atts" multiple="multiple" class="wc-enhanced-select" style="width: 100%">';
        foreach (wc_get_attribute_taxonomies() as $attribute) {
            printf(
                '<option value="%s" %s>%s</option>',
                esc_attr($attribute->attribute_name),
                in_array($attribute->attribute_name, $term_atts) ? 'selected' : '',
                esc_html($attribute->attribute_label)
            );
        }
        echo '</select>';
    }

    public function saveAttributeData(int $term_id): void {
        $term_atts = $_POST['_category_atts'] ?? [];
        update_term_meta($term_id, '_product_cat_atts', $term_atts);
    }
}
