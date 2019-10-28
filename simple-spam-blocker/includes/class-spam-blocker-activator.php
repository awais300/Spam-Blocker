<?php

/**
 * Fired during plugin activation
 *
 * @link       awais300@gmail.com
 * @since      1.0.0
 *
 * @package    Spam_Blocker
 * @subpackage Spam_Blocker/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Spam_Blocker
 * @subpackage Spam_Blocker/includes
 * @author     Awais <awais300@gmail.com>
 */
class Spam_Blocker_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		$options = get_option( 'awp-honeypot-options' );
		if ( empty( $options ) ) {
			$default = array(
				'honeypot-login'    => true,
				'honeypot-comments' => true,
			);
			update_option( 'awp-honeypot-options', $default, false );
		}
	}

}
