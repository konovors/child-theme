<?php

namespace Extremis;

use Extremis\Bootloader;
use Oblak\Asset\Loader;

if ( ! defined( 'ABSPATH' ) ) {
    return;
}

add_action('after_setup_theme', function () {
    $status = load_child_theme_textdomain( 'knv', get_stylesheet_directory() . '/languages' );

    extremis()->singleton('extremis.assets', function () {
        return Loader::getInstance();
    });

    extremis()->singleton('extremis.bootstrap', function () {
        return new Bootloader( config( 'modules' ) );
    });

    extremis( 'bootstrap' )->run();
    extremis( 'assets' )->registerNamespace( 'extremis', config( 'assets' ) );
});

add_filter('body_class', function ( array $classes ): array {

    if ( is_single() || is_page() && ! is_front_page() ) {
        if ( ! in_array( basename( get_permalink() ), $classes ) ) {
            $classes[] = basename( get_permalink() );
        }
    }

    return array_filter( $classes );
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script( 'fontawesome', 'https://kit.fontawesome.com/dc361d9591.js', [], '5.13.0', true );
});

// add_action('wp_head', function () {
// <script src="" crossorigin="anonymous"></script>
// });
