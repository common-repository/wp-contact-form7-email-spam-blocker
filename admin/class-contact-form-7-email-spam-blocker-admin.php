<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Contact_Form_7_Email_Spam_Blocker
 * @subpackage Contact_Form_7_Email_Spam_Blocker/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Contact_Form_7_Email_Spam_Blocker
 * @subpackage Contact_Form_7_Email_Spam_Blocker/admin
 * @author     Hardik Kalathiya <hardikkalathiya93@gmail.com>
 */
class Contact_Form_7_Email_Spam_Blocker_Admin {

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
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

        // hook into contact form 7 form
        add_filter('wpcf7_editor_panels', array($this, 'cf7pp_editor_panels'));

        // hook into contact form 7 admin form save
        add_action('wpcf7_after_save', array($this, 'cf7pp_save_contact_form'));
    }

    // hook into contact form 7 form
    public function cf7pp_editor_panels($panels) {

        $new_page = array(
            'Block-Email' => array(
                'title' => __("Block Email's/Email's Domain", "contact-form-7-email-blocker"),
                'callback' => array($this, 'cf7pp_admin_after_additional_settings')
            )
        );

        $panels = array_merge($panels, $new_page);
        return $panels;
    }

    public function cf7pp_admin_after_additional_settings($cf7) {
        $post_id = sanitize_text_field($_GET['post']);
        $wpcf7_block_email_list_val = get_post_meta($post_id, "_wpcf7_block_email_list", true);
        $wpcf7_block_email_error_msg = get_post_meta($post_id, "_wpcf7_block_email_error_msg", true);
        $wpcf7_block_email_domain = get_post_meta($post_id, "_wpcf7_block_email_domain", true);

        // Default error message
        if (empty($wpcf7_block_email_error_msg)) {
            $wpcf7_block_email_error_msg = 'You need to provide an email address that isn\'t hosted by a free provider. Please contact us directly if this isn\'t possible.';
        }
        ?>
        <div class="main-wrap">
            <fieldset>
                <div class="email-block-list">
                    <h3 class="blocker-7-setting">Add Emails that you want to block.</h3>
                    <textarea name="wpcf7_block_email_list" id="wpcf7-block-email-list-id" cols="100" rows="8" class="large-text-cf7hk"  placeholder="Eg: example@gmail.com, test@gmail.com"><?php echo trim($wpcf7_block_email_list_val); ?></textarea>
                    <input type='hidden' name='cf7pp_post' value='<?php echo $post_id; ?>'>
                </div>
                <div class="email-hosting-list">
                    <h3 class="blocker-7-setting">Add free email domains that you want to block.</h3>
                    <textarea name="wpcf7_block_email_domain" id="wpcf7-block-email-domain-id" cols="100" rows="8" class="large-text-cf7hk"  placeholder="Eg: @msn.com, @live.com, @outlook.com, @microsoft.com"><?php echo trim($wpcf7_block_email_domain); ?></textarea>
                    <input type='hidden' name='cf7pp_post' value='<?php echo $post_id; ?>'>
                </div>
                <div class="email-address-error-msg">
                    <h3 class="blocker-7-setting">Set your error message.</h3>
                    <input type="text" name="wpcf7_block_email_error_msg" id="wpcf7-block-email-error-id" class="wpcf7-block-email-error-cls" placeholder="Your error message" value="<?php echo trim($wpcf7_block_email_error_msg); ?>">
                </div>
            </fieldset>
        </div>
        <?php
    }

    // hook into contact form 7 admin form save
    public function cf7pp_save_contact_form($cf7) {
        $post_id = sanitize_text_field($_POST['cf7pp_post']);

        // Manual email list
        $wpcf7_block_email_list = sanitize_text_field($_POST['wpcf7_block_email_list']);
        update_post_meta($post_id, "_wpcf7_block_email_list", trim($wpcf7_block_email_list));

        // Block Email Domain
        $wpcf7_block_email_domain = sanitize_text_field($_POST['wpcf7_block_email_domain']);
        update_post_meta($post_id, "_wpcf7_block_email_domain", trim($wpcf7_block_email_domain));

        // Custom error message
        $wpcf7_block_email_error_msg = sanitize_text_field($_POST['wpcf7_block_email_error_msg']);
        update_post_meta($post_id, "_wpcf7_block_email_error_msg", trim($wpcf7_block_email_error_msg));
    }

    /**
     * Register the stylesheets for the admin area.
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
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/contact-form-7-email-spam-blocker-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
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
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/contact-form-7-email-spam-blocker-admin.js', array('jquery'), $this->version, false);
    }

}
