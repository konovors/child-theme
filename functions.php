<?php // phpcs:disable PSR1.Files.SideEffects.FoundWithSymbols

use Extremis\Container;
use Extremis\Config;

require_once(__DIR__.'/vendor/autoload.php');

define('EXTREMIS_VERSION', '1.0.0');

Container::getInstance()->bindIf('config', function () {
    return new Config([
        'modules' => require locate_template('/config/modules.php'),
        'assets'  => require locate_template('/config/assets.php'),
    ]);
});
