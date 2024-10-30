<?php
/**
 * Plugin Name: Cookie Connector for Themer
 * Description: Cookie Connector & Conditional Logic for Beaver Themer. Use Site Cookie for Queries and set Conditional Logic rules using Site Cookies.
 * Version: 1.3.2
 * Author: Didou Schol
 * Text Domain: cookie-connector
 * Domain Path: /languages
 * Author URI: https://www.badabing.nl
 */

 
 use CookieConnectorThemer\Autoloader;
 use CookieConnectorThemer\Init;
 
 if ( defined( 'ABSPATH' ) && ! defined( 'COOKIECONNECTORTHEMER_VERION' ) ) {
  register_activation_hook( __FILE__, 'COOKIECONNECTORTHEMER_check_php_version' );
 
  /**
   * Display notice for old PHP version.
   */
  function COOKIECONNECTORTHEMER_check_php_version() {
	  if ( version_compare( phpversion(), '7.4', '<=' ) ) {
		 die( esc_html__( 'Cookie Connector for Themer requires PHP version 7.4+. Please contact your host to upgrade.', 'mortgagebroker-calculator' ) );
	 }
  }
 
   define( 'COOKIECONNECTORTHEMER_VERSION'   , '1.3.2' );
   define( 'COOKIECONNECTORTHEMER_DIR'     , plugin_dir_path( __FILE__ ) );
   define( 'COOKIECONNECTORTHEMER_FILE'    , __FILE__ );
   define( 'COOKIECONNECTORTHEMER_URL'     , plugins_url( '/', __FILE__ ) );
 
   define( 'CHECK_COOKIECONNECTORTHEMER_PLUGIN_FILE', __FILE__ );
 
 }
 
 if ( ! class_exists( 'CookieConnectorThemer\Init' ) ) {
 
  /**
   * The file where the Autoloader class is defined.
   */
   require_once 'inc/Autoloader.php';
   spl_autoload_register( array( new Autoloader(), 'autoload' ) );
 
  $cookieconnector = new Init();
  // looking for the init hooks? Find them in the Check_Plugin_Dependencies.php->run() callback
 
 }
