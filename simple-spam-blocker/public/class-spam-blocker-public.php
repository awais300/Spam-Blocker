<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       awais300@gmail.com
 * @since      1.0.0
 *
 * @package    Spam_Blocker
 * @subpackage Spam_Blocker/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Spam_Blocker
 * @subpackage Spam_Blocker/public
 * @author     Awais <awais300@gmail.com>
 */
class Spam_Blocker_Public {


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
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

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
		 * defined in Spam_Blocker_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Spam_Blocker_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/spam-blocker-public.css', array(), $this->version, 'all' );

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
		 * defined in Spam_Blocker_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Spam_Blocker_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/spam-blocker-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Styles for comment section.
	 *
	 * @since    1.0.0
	 */
	public function comment_style() {
		echo '<style>
       			.required-awp{
       				display:none !important;
       			}
       		</style>';
	}

	/**
	 * Add input field (Honeypot)
	 */
	public function honeypot_comment_form() {
		?>
			<div class="required-awp">
				<input autocomplete="off" name="comment-form-area" type="text" value=""/>
			</div>
		<?php
	}

	/**
	 * Check spam for WP comments
	 *
	 * @param  Array $commentdata
	 * @return $commentdata| wp_die
	 */
	public function honeypot_preprocess_comment( $commentdata ) {
		$login_field = '';
		if ( isset( $_POST['comment-form-area'] ) ) {
			$login_field = sanitize_text_field( wp_unslash( $_POST['comment-form-area'] ) );
		}

		if ( strlen( $login_field ) > 0 ) {
			wp_die( esc_html__( 'ERROR: Spam detected', 'spam-blocker' ) );
		} else {
			return $commentdata;
		}

	}

}
