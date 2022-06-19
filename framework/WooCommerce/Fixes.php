<?php

namespace Extremis\WooCommerce;

use function Extremis\asset_uri;

class Fixes {
    public function __construct() {
        add_filter('woocommerce_placeholder_img_src', [$this, 'overridePlaceholderImageSrc'], 99, 1);
    }

    public function overridePlaceholderImageSrc(string $src): string {
        $our_sizes  = [100, 150, 300, 450, 600, 768, 800, 960, 1024, 1200];
        $image_base = 'images/woocommerce-placeholder-%dx%d.jpg';
        $closest    = null;

        preg_match("/(\d+)x(\d+)/", $src, $dimensions);

        $width = is_int($dimensions[1] ?? '') ? $dimensions[1] : 1200;

        foreach ($our_sizes as $our_size) {
            if ($closest === null || abs($width - $closest) > abs($our_size - $width)) {
                $closest = $our_size;
            }
        }

        return asset_uri(sprintf(
            $image_base,
            $closest,
            $closest
        ));
    }
}
