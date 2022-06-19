<?php

namespace Extremis\Core;

class Scripts {
    public function __construct() {
        add_action('wp_default_scripts', [$this, 'removeJQueryMigrate'], 99, 1);
        add_action('extremis/localize/main.js', [$this, 'localizeScript'], 500);
    }

    public function removeJQueryMigrate($scripts) {
        if (is_admin() || empty($scripts->registered['jquery'])) {
            return;
        }

        $scripts->registered['jquery']->deps = array_diff(
            $scripts->registered['jquery']->deps,
            [ 'jquery-migrate' ]
        );
    }

    public function localizeScript(): void {
        $data = [
            'ajaxUrl' => admin_url('admin-ajax.php'),
        ];

        wp_localize_script(
            'extremis/main.js',
            'knv',
            $data
        );
    }
}
