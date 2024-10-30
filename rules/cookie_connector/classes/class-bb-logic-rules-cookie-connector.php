<?php
/**
 * Server side processing for Cookie Connector.
 *
 * @since 0.1
 */
final class BB_Logic_Rules_Cookie_Connector {
	/**
	 * Sets up callbacks for conditional logic rules.
	 *
	 * @since  0.1
	 * @return void
	 */
	public static function init() {
		BB_Logic_Rules::register( array(
			'cookieconnector/cookie' 		=> __CLASS__ . '::evaluate_rule',
			) );
			
	}
	/**
	 * Process a Cookie Connector rule
	 * field location.
	 *
	 * @since  0.1
	 * @param string $object_id
	 * @param object $rule
	 * @return bool
	 */
	public static function evaluate_rule( $rule ) {

		$value = isset( $_COOKIE[ $rule->key ] ) ? $_COOKIE[ $rule->key ] : false;

		if ( is_array( $unserialized_value = json_decode( $value , true ) ) ) $value = $unserialized_value;

		if ( !isset( $_COOKIE[ $rule->key ] ) ) $value = $rule->expiredval ? $rule->expiredval : false;


		return BB_Logic_Rules::evaluate_rule( array(
			'value' 	=> $value,
			'operator' 	=> $rule->operator,
			'compare' 	=> $rule->compare,
			'isset'		=> isset( $_COOKIE[ $rule->key ] ) ? true : false,
		) );
	}

}

BB_Logic_Rules_Cookie_Connector::init();
