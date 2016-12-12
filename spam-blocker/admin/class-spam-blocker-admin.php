<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://awais.example.com/
 * @since      1.0.0
 *
 * @package    Spam_Blocker
 * @subpackage Spam_Blocker/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Spam_Blocker
 * @subpackage Spam_Blocker/admin
 * @author     Awais M <awais300@gmail.com>
 */
class Spam_Blocker_Admin {

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
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

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
		 * defined in Spam_Blocker_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Spam_Blocker_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/spam-blocker-admin.css', array(), $this->version, 'all' );

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
		 * defined in Spam_Blocker_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Spam_Blocker_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/spam-blocker-admin.js', array( 'jquery' ), $this->version, false );
	}



	/**
     * Styles on login page.
     *
     * @since    1.0.0
     */
    public function loginpage_style() {
       echo "<style>
       			.required-dz{
       				display:none !important;
       			}
       		</style>";
    }



    /**
     *
     * @since  1.0.0
     */
    public function admin_left_menu() {
        add_menu_page(
            __('Spam Blocker', 'spam-blocker'),
            __('Spam Blocker', 'spam-blocker'),
            'manage_options',
            $this->plugin_name,
            array($this, 'admin_page_view'),
            plugin_dir_url(dirname(__FILE__)) . 'menu_icon.png',
            80
        );
    }



    /**
     * Admin view page
     */
    public function admin_page_view() {

		$message               = '';
        $honeypot_options      = get_option('dz-honeypot-options');

    	if (!empty($_POST)) {
    		if($_POST['form'] == 'honeypot-form') {
    			if (isset($_POST['honeypot-comments']) && $_POST['honeypot-comments'] == 'on') {
                    $honeypot_options['honeypot-comments'] = true;
                } else {
                    $honeypot_options['honeypot-comments'] = false;
                }

                if (isset($_POST['honeypot-login']) && $_POST['honeypot-login'] == 'on') {
                    $honeypot_options['honeypot-login'] = true;
                } else {
                    $honeypot_options['honeypot-login'] = false;
                }
                update_option('dz-honeypot-options', $honeypot_options, false);
                $message = 'Settings Saved';
    		}
    	}

    	include_once('partials/spam-blocker-admin-display.php');
    }



    /**
     * Add input field (Honeypot)
     */
    public function honeypot_login_form() {
        ?>
			<div class="required-dz">
			    <input autocomplete="off" name="login-form-area" type="text" value=""/>
			</div>
		<?php
	}



    /**
     * Check oneypot field at login page
     * @param  string $user
     * @param  string $password
     * @return $user | WP_Error
     */
    public function honeypot_wp_authenticate_user($user, $password) {
        if (strlen($_POST['login-form-area']) > 0) {
            global $error;
            return new WP_Error('dz-honeypot', __('<strong>ERROR</strong>: Spammer detected', 'spam-blocker'));
        } else {
            return $user;
        }
    }

}
