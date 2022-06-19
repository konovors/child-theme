<?php

namespace Extremis\WooCommerce\Category;

use WP_Term;

/**
 * Adds Secondary description to category pages
 */
class SecondDescription {
    public function __construct() {
        add_action('product_cat_add_form_fields', [$this, 'termAddEditor'], 9);
        add_action('product_cat_edit_form_fields', [$this, 'termEditEditor'], 9);

        add_action('edit_product_cat', [$this, 'saveProductCat']);
        add_action('created_product_cat', [$this, 'saveProductCat']);

        add_action('woocommerce_after_main_content', [$this, 'displaySecondDescription']);

        remove_action('pre_term_description', 'wp_filter_kses');
        remove_action('term_description', 'wp_kses_data');
    }

    /**
     * Adds the description editors to the add category form.
     */
    public function termAddEditor(): void {
        ?>
        <div class="form-field term-wysiwyg-wrap">
            <label for="description"><?= __('Description'); ?></label>
            <?php $this->getEditor('first_description', ''); ?>
            <p class="description">
                <?= __('The description is not prominent by default; however, some themes may show it.'); ?>
            </p>
        </div>

        <div class="form-field term-wysiwyg-description-wrap">
            <label for="additional_content"><?= __('Additional content', 'woocommerce'); ?></label>
            <?php $this->getEditor('additional_content', ''); ?>
        </div>

        <script>
            window.addEventListener('DOMContentLoaded', () => {
                document.querySelector('.term-description-wrap').remove();
            });
        </script>

        <?php
    }

    /**
     * Adds the description editors to the edit category form.
     *
     * @param  WP_Term $term Term being edited
     */
    public function termEditEditor(WP_Term $term): void {
        ?>
        <tr class="form-field term-wysiwyg-description-wrap">
            <th scope="row"><label for="description"><?= __('Description'); ?></label></th>
        <td>
            <?php $this->getEditor('first_description', html_entity_decode($term->description)); ?>
            <p class="description">
                <?= __('The description is not prominent by default; however, some themes may show it.'); ?>
            </p>
        </td>

        </tr>
        <tr class="form-field term-additional-content-wrap">
            <th scope="row"><label for="additional_content"><?= __('Additional content', 'woocommerce'); ?></label></th>
            <td>
                <?php $this->getEditor('additional_content', get_term_meta($term->term_id, '_additional_content', true)); ?>
            </td>

        </tr>
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                document.querySelector('.term-description-wrap').remove();
            });
        </script>
        <?php
    }

    public function saveProductCat(int $term_id): void {
        remove_action('edit_product_cat', [$this, 'saveProductCat']);
        remove_action('created_product_cat', [$this, 'saveProductCat']);

        wp_update_term($term_id, 'product_cat', [
            'description'     => wp_kses_post($_REQUEST['first_description']),
            'parent'          => $_REQUEST['parent'],
        ]);

        update_term_meta($term_id, '_additional_content', wp_kses_post($_REQUEST['additional_content']));
    }

    private function getEditor(string $id, string $content): void {
        wp_editor($content, $id, [
            'media_buttons' => false,
            'quicktags'     => false,
        ]);
    }

    public function displaySecondDescription(): void {
        if (!is_product_category() || get_query_var('paged') > 0) {
            return;
        }
        $term = get_term_by('slug', get_query_var('product_cat'), 'product_cat');

        $additional_content = get_term_meta($term->term_id, '_additional_content', true);

        if (empty($additional_content)) {
            return;
        }

        printf(
            '<div class="term-description">%s</div>',
            wc_format_content($additional_content)
        );
    }
}
