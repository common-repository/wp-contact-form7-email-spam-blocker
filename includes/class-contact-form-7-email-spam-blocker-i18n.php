<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Contact_Form_7_Email_Spam_Blocker
 * @subpackage Contact_Form_7_Email_Spam_Blocker/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Contact_Form_7_Email_Spam_Blocker
 * @subpackage Contact_Form_7_Email_Spam_Blocker/includes
 * @author     Hardik Kalathiya <hardikkalathiya93@gmail.com>
 */
class Contact_Form_7_Email_Spam_Blocker_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'contact-form-7-email-spam-blocker',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
