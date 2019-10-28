<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       awais300@gmail.com
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
 * @author     Awais <awais300@gmail.com>
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
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

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
		echo '<style>
       			.required-awp{
       				display:none !important;
       			}
       		</style>';
	}

	/**
	 * Add admin menu page
	 *
	 * @since  1.0.0
	 */
	public function admin_left_menu() {
		add_menu_page(
			__( 'Spam Blocker', 'spam-blocker' ),
			__( 'Spam Blocker', 'spam-blocker' ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'admin_page_view' ),
			plugin_dir_url( dirname( __FILE__ ) ) . '/admin/images/menu_icon.jpg',
			80
		);
	}

	/**
	 * View Page for the admin options
	 */
	public function admin_page_view() {

		$message          = '';
		$honeypot_options = get_option( 'awp-honeypot-options' );

		$post = array();
		if ( ! empty( $_POST ) ) {
			$post = $_POST;
			foreach ( $post as $key => $value ) {
				$post[ $key ] = wp_unslash( $value );
			}
		}

		if ( isset( $post['form'] ) && 'honeypot-form' === $post['form'] && ! wp_verify_nonce( $post['_wpnonce'] ) ) {
			wp_die( esc_html__( 'Unauthorized', 'spam-blocker' ) );
		} elseif ( 'honeypot-form' === $post['form'] ) {
			if ( isset( $post['honeypot-comments'] ) && 'on' === $post['honeypot-comments'] ) {
				$honeypot_options['honeypot-comments'] = true;
			} else {
				$honeypot_options['honeypot-comments'] = false;
			}

			if ( isset( $post['honeypot-login'] ) && 'on' === $post['honeypot-login'] ) {
				$honeypot_options['honeypot-login'] = true;
			} else {
				$honeypot_options['honeypot-login'] = false;
			}
			update_option( 'awp-honeypot-options', $honeypot_options, false );
			$message = 'Settings Saved';
		}

		include_once 'partials/spam-blocker-admin-display.php';
	}

	/**
	 * Add input field (Honeypot)
	 */
	public function honeypot_login_form() {
		?>
			<div class="required-awp">
				<input autocomplete="off" name="login-form-area" type="text" value=""/>
			</div>
		<?php
	}

	/**
	 * Check oneypot field at login page
	 *
	 * @param  string $user
	 * @param  string $password
	 * @return $user | WP_Error
	 */
	public function honeypot_wp_authenticate_user( $user, $password ) {
		$login_field = '';
		if ( isset( $_POST['login-form-area'] ) ) {
			$login_field = sanitize_text_field( wp_unslash( $_POST['login-form-area'] ) );
		}

		if ( isset( $login_field ) && strlen( $login_field ) > 0 ) {
			global $error;
			return new WP_Error( 'awp-honeypot', esc_html__( 'ERROR: Spammer detected', 'spam-blocker' ) );
		} else {
			return $user;
		}
	}

}
