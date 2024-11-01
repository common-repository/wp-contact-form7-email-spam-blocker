<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Contact_Form_7_Email_Spam_Blocker
 * @subpackage Contact_Form_7_Email_Spam_Blocker/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Contact_Form_7_Email_Spam_Blocker
 * @subpackage Contact_Form_7_Email_Spam_Blocker/public
 * @author     Hardik Kalathiya <hardikkalathiya93@gmail.com>
 */
class Contact_Form_7_Email_Spam_Blocker_Public {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

        add_filter('wpcf7_validate_email', array($this, 'custom_email_validation_filter'), 10, 2); // Email field
        add_filter('wpcf7_validate_email*', array($this, 'custom_email_validation_filter'), 10, 2); // Required Email field
    }

    public function blocked_email_domain_test($email, $post_id) {
        $blocked_emails_list_str = str_replace(" ", "", get_post_meta($post_id, "_wpcf7_block_email_list", true));
        $blocked_emails_domain_str = str_replace(" ", "", get_post_meta($post_id, "_wpcf7_block_email_domain", true));



//echo $blocked_emails_list_str;
        $blocked_emails = explode(",", trim($blocked_emails_list_str));
        $blocked_domains = explode(",", trim($blocked_emails_domain_str));

        $email_domain = strstr($email, '@');
//        echo $email_domain;
        
//        echo "<pre>";
//        print_r($blocked_domains);  
        if (in_array($email_domain, $blocked_domains) || in_array($email, $blocked_emails)) {
            return false;
        } else {
            return true;
        }
    }

    public function custom_email_validation_filter($result, $tag) {
        $type = $tag['type'];
        $name = $tag['name'];
        $basetype = $tag['basetype'];
        $post_id = $_POST['_wpcf7'];  // Get the post id

        $wpcf7_block_email_error_msg = get_post_meta($post_id, "_wpcf7_block_email_error_msg", true);


        if ($basetype == 'email') {// Only apply to fields with the form field name of "your-email"
            $the_value = $_POST[$name];
            if (!$this->blocked_email_domain_test($the_value, $post_id)) {
                $result->invalidate($tag, $wpcf7_block_email_error_msg);
            }
        }
        return $result;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Contact_Form_7_Email_Spam_Blocker_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Contact_Form_7_Email_Spam_Blocker_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/contact-form-7-email-spam-blocker-public.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Contact_Form_7_Email_Spam_Blocker_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Contact_Form_7_Email_Spam_Blocker_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/contact-form-7-email-spam-blocker-public.js', array('jquery'), $this->version, false);
    }

}
