<?php
namespace CookieConnectorThemer\Integration;

/**
 * @package cookie connector for themer
 * @since 1.0.0
 */
class BeaverThemer {

    public function __construct() {

        add_action( 'plugins_loaded' , __CLASS__ . '::init' , 0  );

    }
    
    /**
     * init
     *
     * @return void
     */
    public static function init() {
        /**
         * Check if the Theme Builder / Beaver Themer is 1.2 or higher
         */
        if ( 
            defined( 'FL_THEME_BUILDER_VERSION' ) &&
            version_compare( FL_THEME_BUILDER_VERSION, '1.2', '>=' ) 
            ) {
    
            add_action( 'bb_logic_init' , __CLASS__ . '::logic_rules' );
    
            add_action( 'bb_logic_enqueue_scripts' , __CLASS__ . '::bb_logic_script' ); 

            add_action( 'bb_logic_enqueue_scripts' , __CLASS__ . '::cookie_connector_js_translations', 50, 1 );
            
            // add the actual field connector to themer
            add_action( 'fl_page_data_add_properties' ,  __CLASS__ . '::add_cookie_connector' );

        }   
        
        
    }
        
    /**
     * logic_rules
     *
     * @return void
     */
    public static function logic_rules() {
        require_once COOKIECONNECTORTHEMER_DIR . 'rules/cookie_connector/classes/class-bb-logic-rules-cookie-connector.php';
    }
        
    /**
     * bb_logic_script
     *
     * @return void
     */
    public static function bb_logic_script() {
        wp_enqueue_script(
            'bb-logic-rules-cookie-connector',
            COOKIECONNECTORTHEMER_URL . 'rules/cookie_connector/build/index.js',
            array( 'bb-logic-core' ),
            COOKIECONNECTORTHEMER_VERSION,
            true
        );
    }

    /**
     * Add translation for Beavers Conditional Logic Modal
     * @return [type] [description]
     */
    public static function cookie_connector_js_translations() {
        wp_localize_script(
          'bb-logic-rules-cookie-connector',
          'cookie_js_translations',
          [
            '__' => [
                'cookie_value' => __( 'Cookie Value' , 'cookie-connector' ),
                'cookie_connector' => __( 'Cookie Connector' , 'cookie-connector' ),
                'cookie_name' => __( 'Cookie Name' , 'cookie-connector' ),
                'expired_return_value' => __( 'Expired Return Value' , 'cookie-connector' ),
            ]
          ]
        );
    
    }

	
	/**
	 * add_cookie_connector
     * 
     * Add Connector to Beaver Themer
	 *
	 * @return void
	 */
	public static function add_cookie_connector() {

		/**
		 *  Add a custom group
		 */
		\FLPageData::add_group( 'cookie_connector', array(
			'label' => __( 'Cookie Connector', 'cookie-connector' )
		) );


		/**
		 *  Add a new property to custom group
		 */
		\FLPageData::add_post_property( 'cookie_connector', array(
			'label'   => __( 'Cookie Value', 'cookie-connector' ),
			'group'   => 'cookie_connector',
			'type'    => 'string',
			'getter'  => array( __CLASS__ , 'get_cookie_value' ),
		) );

		\FLPageData::add_post_property_settings_fields(
			'cookie_connector',
			array(
				'cookie_name' => array(
				    'type'          => 'text',
				    'label'         => __( 'Cookie Name', 'cookie-connector' ),
				    'default'       => '',
				    'maxlength'     => '',
				    'size'          => '15',
				    'placeholder'   => __( 'Cookie Name', 'cookie-connector' ),
				    'help'          => __( 'Enter the name of the cookie that you want to get.', 'cookie-connector' ),
					),
			)
		);

	}

	/**
	 * Get the cookie value
	 * @param  [type] $settings [description]
	 * @param  [type] $property [description]
	 * @return [type]           [description]
	 */
	public static function get_cookie_value( $settings , $property ) {

		if ( isset( $settings->cookie_name ) ) {
			if ( isset( $_COOKIE[ $settings->cookie_name ] ) ) {
				return is_array( $unserialized_value = json_decode( $_COOKIE[ $settings->cookie_name ] , true ) ) ? $unserialized_value : $_COOKIE[ $settings->cookie_name ];
			} else {
				return '';
			}
		} else {
			return '';
		}

		return '';
	}    
}