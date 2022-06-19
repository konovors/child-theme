<?php

namespace Extremis\WooCommerce\Product;

use WC_Product;

class PriceHtml {
    /**
     * Undocumented variable
     *
     * @var int[]
     */
    private array $tags;

    public function __construct() {
        $tag_option = get_option( 'price_tags', '' );
        $this->tags = explode( ',', $tag_option );

        add_filter( 'woocommerce_get_price_html', [$this, 'priceDisplayOverride'], 99, 2 );
    }

    public function priceDisplayOverride( string $price_html, WC_Product $product ): string {
        if ( is_admin() && ! wp_doing_ajax() ) {
            return $price_html;
        }

        $price_html = ( ! $product->is_on_sale() )
            ? $this->overrideRegularPrice( $product )
            : $this->overrideSalePrice( $product );

        return $price_html;
    }

    public function overrideRegularPrice( WC_Product $product ): string {
        $addon_class = $this->hasTagDisplay( $product ) ? 'with-discount' : 'knv-price-no-discount';
        return sprintf(
            '<div class="knv-regular-price">&nbsp;</div>
            <div class="knv-price-wrap">
                <div class="knv-price %s">%s</div>
                %s
            </div>',
            $addon_class,
            wc_price( $product->get_regular_price() ),
            $this->maybeDisplayPriceAddon( $product ),
        );
    }

    public function overrideSalePrice( WC_Product $product ): string {
        return sprintf(
            '<div class="knv-regular-price">%s: <del>%s</del></div>
            <div class="knv-price-wrap">
                <div class="knv-price with-discount">%s</div>
                %s
            </div>',
            // phpcs:disable WordPress.WP.I18n.TextDomainMismatch
            __( 'Regular price', 'woocommerce' ),
            wc_price( $product->get_regular_price() ),
            wc_price( $product->get_sale_price() ),
            $this->maybeDisplayPriceAddon( $product ),
        );
    }

    /**
     * Displays price addon in the right box
     *
     * @param  WC_Product $product
     * @return string     Price addon html
     *
     * @todo Add the support for price tag display!
     */
    private function maybeDisplayPriceAddon( WC_Product $product ): string {
        if ( $product->is_on_sale() ) {
            return $this->getPriceDifference( $product );
        }

        if ( $this->hasTagDisplay( $product ) ) {
            return $this->getPriceTag( $product );
        }

        return '';
    }

    private function getPriceDifference( $product ): string {
        $price_difference = $product->get_regular_price() - $product->get_sale_price();

        return sprintf(
            '<div class="knv-price-addon knv-sale-price">
                <div class="knv-addon-inner">
                    <span class="text">%s</span>
                    <ins>%s</ins>
                </div>
            </div>',
            __( 'You save', 'knv' ),
            wc_price( $price_difference ),
        );
    }

    private function getPriceTag( WC_Product $product ): string {
        $tag = get_term( $product->get_tag_ids()[0], 'product_tag' );

        return sprintf(
            '<div class="knv-price-addon knv-sale-price">
                <div class="knv-addon-inner tag tag-%s">
                    <span class="text">%s</span>
                </div>
            </div>',
            $tag->slug,
            $tag->name,
        );
    }

    private function hasTagDisplay( WC_Product $product ): bool {
        return ! empty( array_intersect( $product->get_tag_ids(), $this->tags ) );
    }
}
