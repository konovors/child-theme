<?php
namespace Extremis\WooCommerce\Settings;

class ProductBadges {

    private string $id;

    public function __construct() {

        $this->id = 'products';

        add_filter( 'woocommerce_get_sections_' . $this->id, [$this, 'addBadgeTagSection'] );
        add_filter( 'woocommerce_get_settings_products', [$this, 'addBadgeTagSettings'], 99, 2 );

    }

    public function addBadgeTagSection( array $sections ) : array {

        $sections['badges'] = __( 'Badges and Tags', 'knv' );

        return $sections;

    }

    public function addBadgeTagSettings( array $settings, string $section ) : array {

        if ( 'badges' !== $section ) {
            return $settings;
        }

        return [
            [
                'title' => __( 'Tag options', 'knv' ),
                'type'  => 'title',
                'desc'  => __( 'Tag options for price label', 'knv' ),
                'id'    => 'product_tag_options',
            ],
            [
                'title'             => __( 'Price tags', 'knv' ),
                'id'                => 'price_tags',
                'type'              => 'select',
                'options'           => $this->getProductTags(),
                'default'           => 0,
                'class'             => 'wc-enhanced-select',
                'custom_attributes' => [
                    'data-placeholder' => __( 'Select a tag', 'knv' ),
                    'multiple'         => 'multiple',
                ],
            ],
            [
                'type' => 'sectionend',
                'id'   => 'product_tag_options',
            ],
        ];

    }

    private function getProductTags() : array {

        $all_tags = get_terms([
            'taxonomy'   => 'product_tag',
            'hide_empty' => false,
        ]);
        $tags     = [
            '' => '',
        ];

        foreach ( $all_tags as $tag ) {
            $tags[ $tag->term_id ] = $tag->name;
        }

        return $tags;

    }



}
