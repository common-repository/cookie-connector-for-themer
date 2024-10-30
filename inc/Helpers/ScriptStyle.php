<?php
namespace CookieConnectorThemer\Helpers;

class ScriptStyle {

    public function __construct() {
        
        add_action( 'wp_enqueue_scripts' , __CLASS__ . '::cookie_connector_secure_ajax', 10, 1 );
    }


    /**
     * Add Cookie Connector with secured access
     * add cookie security nonce that gets checked on call
     * @return [type] [description]
     */
    public static function cookie_connector_secure_ajax() {
        wp_enqueue_script(
            'cookie-connect-security',
            COOKIECONNECTORTHEMER_URL . 'js/cookieconnector.js',
            [ 'jquery' ],
          false,
          true
        );
        
        wp_localize_script(
            'cookie-connect-security',
            'cookie_ajax_object',
            [
                'ajax_url'  => admin_url( 'admin-ajax.php' ),
                'security'  => wp_create_nonce( 'cookie-security-nonce' ),
            ]
        );
            
    }    
}