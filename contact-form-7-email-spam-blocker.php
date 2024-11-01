<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Contact_Form_7_Email_Spam_Blocker
 *
 * @wordpress-plugin
 * Plugin Name:       Contact Form 7 Email Spam Blocker
 * Plugin URI:        http://example.com/contact-form-7-email-spam-blocker/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Hardik Kalathiya
 * Author URI:        http://example.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       contact-form-7-email-spam-blocker
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-contact-form-7-email-spam-blocker-activator.php
 */
function activate_contact_form_7_email_spam_blocker() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-contact-form-7-email-spam-blocker-activator.php';
	Contact_Form_7_Email_Spam_Blocker_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-contact-form-7-email-spam-blocker-deactivator.php
 */
function deactivate_contact_form_7_email_spam_blocker() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-contact-form-7-email-spam-blocker-deactivator.php';
	Contact_Form_7_Email_Spam_Blocker_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_contact_form_7_email_spam_blocker' );
register_deactivation_hook( __FILE__, 'deactivate_contact_form_7_email_spam_blocker' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-contact-form-7-email-spam-blocker.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_contact_form_7_email_spam_blocker() {

	$plugin = new Contact_Form_7_Email_Spam_Blocker();
	$plugin->run();

}
run_contact_form_7_email_spam_blocker();
