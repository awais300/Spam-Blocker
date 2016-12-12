<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://awais.example.com/
 * @since      1.0.0
 *
 * @package    Spam_Blocker
 * @subpackage Spam_Blocker/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Spam_Blocker
 * @subpackage Spam_Blocker/includes
 * @author     Awais M <awais300@gmail.com>
 */
class Spam_Blocker_Deactivator {

	/**
	 * Remove saved settings from database.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		delete_option('dz-honeypot-options');
	}

}
