<?php

namespace CookieConnectorThemer;

use CookieConnectorThemer\Helpers\ScriptStyle;
use CookieConnectorThemer\Integration\BeaverThemer;

class Init {

    public function __construct() {
        new ScriptStyle();
        new BeaverThemer();

        // setup textdomain for future translations
        add_action( 'plugins_loaded', __CLASS__ . '::plugin_textdomain' );


    }

    /**
     * Function to load the textdomain
     * @return void
     * @since  1.1
     */
    public static function plugin_textdomain() {
        //textdomain
        \load_plugin_textdomain( 'cookie-connector', false, COOKIECONNECTORTHEMER_DIR . '/languages' );
    }
}