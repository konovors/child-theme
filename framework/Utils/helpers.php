<?php declare(strict_types=1);

namespace Extremis;

use Extremis\Container;
use Extremis\WooCommerce\Matis\ProductSimple;

/**
 * Get the Extremis container.
 *
 * @param string    $abstract
 * @param array     $parameters
 * @param Container $container
 * @return Container|mixed
 */
function extremis( $abstract = null, $parameters = [], Container $container = null ) {
    $container = $container ? $container : Container::getInstance();
    if ( ! $abstract ) {
        return $container;
    }
    return $container->bound( $abstract )
        ? $container->makeWith( $abstract, $parameters )
        : $container->makeWith( "extremis.{$abstract}", $parameters );
}

/**
 * Get / set the specified configuration value.
 * If an array is passed as the key, we will assume you want to set an array of values.
 *
 * @param  array|string $key
 * @param  mixed        $default
 * @return mixed|\Extremis\Config
 *
 * @copyright Taylor Otwell
 * @link https://github.com/laravel/framework/blob/c0970285/src/Illuminate/Foundation/helpers.php#L254-L265
 */
function config( $key = null, $default = null ) {
    if ( is_null( $key ) ) {
        return extremis( 'config' );
    }
    if ( is_array( $key ) ) {
        return extremis( 'config' )->set( $key );
    }
    return extremis( 'config' )->get( $key, $default );
}

/**
 * @param  string $asset
 * @return string
 */
function asset_uri( $asset ) {
    return extremis( 'assets' )->getUri( 'extremis', $asset );
}

function asset_path( $asset ) {
    return extremis( 'assets' )->getPath( 'extremis', $asset );
}
