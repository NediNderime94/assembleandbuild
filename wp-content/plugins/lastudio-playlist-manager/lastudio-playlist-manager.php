<?php
/**
 * Plugin Name: LaStudio Playlist
 * Plugin URI: #
 * Description: A plugin to manage your playlists
 * Version: 1.0.0
 * Author: LaStudio
 * Author URI: #
 * Requires at least: 4.9
 * Tested up to: 4.9
 *
 * Text Domain: lastudio-playlist-manager
 * Domain Path: /languages/
 *
 * @package LaStudiolistManager
 * @category Core
 * @author LaStudio
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'LaStudio_Playlist_Manager' ) ) {
	/**
	 * Main LaStudio_Playlist_Manager Class
	 *
	 * Contains the main functions for LaStudio_Playlist_Manager
	 *
	 * @class LaStudio_Playlist_Manager
	 * @version 1.0.0
	 * @since 1.0.0
	 */
	class LaStudio_Playlist_Manager {

		/**
		 * @var string
		 */
		private $required_php_version = '5.6.0';

		/**
		 * @var string
		 */
		public $version = '1.0.0';

		/**
		 * @var LaStudio Playlist The single instance of the class
		 */
		protected static $_instance = null;

		/**
		 * @var string
		 */
		private $update_url = 'https://plugins.la-studioweb.com/update';

		/**
		 * @var the support forum URL
		 */
		private $support_url = 'https://support.la-studioweb.com/';

		/**
		 * @var string
		 */
		public $template_url;

		/**
		 * Main LaStudio Playlist Instance
		 *
		 * Ensures only one instance of LaStudio Playlist is loaded or can be loaded.
		 *
		 * @static
		 * @see LPM()
		 * @return LaStudio Playlist - Main instance
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Cloning is forbidden.
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'lastudio-playlist-manager' ), '1.0' );
		}

		/**
		 * Unserializing instances of this class is forbidden.
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'lastudio-playlist-manager' ), '1.0' );
		}

		/**
		 * LaStudio Playlist Constructor.
		 */
		public function __construct() {

			if ( phpversion() < $this->required_php_version ) {
				add_action( 'admin_notices', array( $this, 'warning_php_version' ) );
				return;
			}

			$this->define_constants();
			$this->includes();
			$this->init_hooks();

			do_action( 'lpm_loaded' );
		}

		/**
		 * Display error notice if PHP version is too low
		 */
		public function warning_php_version() {
			?>
			<div class="notice notice-error">
				<p><?php

				printf(
					esc_html__( '%1$s needs at least PHP %2$s installed on your server. You have version %3$s currently installed. Please contact your hosting service provider if you\'re not able to update PHP by yourself.', 'lastudio-playlist-manager' ),
					'LaStudio Playlist',
					$this->required_php_version,
					phpversion()
				);
				?></p>
			</div>
			<?php
		}

		/**
		 * Hook into actions and filters
		 */
		private function init_hooks() {
			add_action( 'after_setup_theme', array( $this, 'include_template_functions' ), 11 );
			add_action( 'init', array( $this, 'init' ), 0 );
			register_activation_hook( __FILE__, array( $this, 'activate' ) );
		}

		/**
		 * Add a flag that will allow to flush the rewrite rules when needed.
		 */
		public function activate() {
			if ( ! get_option( '_lpm_flush_rewrite_rules_flag' ) ) {
				add_option( '_lpm_flush_rewrite_rules_flag', true );
			}
		}

		/**
		 * Flush rewrite rules on plugin activation to avoid 404 error
		 */
		public function flush_rewrite_rules(){
			if ( get_option( '_lpm_flush_rewrite_rules_flag' ) ) {
				flush_rewrite_rules();
				delete_option( '_lpm_flush_rewrite_rules_flag' );
			}
		}

		/**
		 * Define LPM Constants
		 */
		private function define_constants() {

			$constants = array(
				'LPM_DEV' => false,
				'LPM_DIR' => $this->plugin_path(),
				'LPM_URI' => $this->plugin_url(),
				'LPM_CSS' => $this->plugin_url() . '/assets/css',
				'LPM_JS' => $this->plugin_url() . '/assets/js',
				'LPM_SLUG' => plugin_basename( dirname( __FILE__ ) ),
				'LPM_PATH' => plugin_basename( __FILE__ ),
				'LPM_VERSION' => $this->version,
				'LPM_UPDATE_URL' => $this->update_url,
				'LPM_SUPPORT_URL' => $this->support_url,
				'LPM_DOC_URI' => 'https://docs.la-studioweb.com/documentation/plugins/' . plugin_basename( dirname( __FILE__ ) ),
				'LPM_LASTUDIO_DOMAIN' => 'la-studioweb.com',
			);

			foreach ( $constants as $name => $value ) {
				$this->define( $name, $value );
			}
		}

		/**
		 * Define constant if not already set
		 * @param  string $name
		 * @param  string|bool $value
		 */
		private function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		/**
		 * What type of request is this?
		 * string $type ajax, frontend or admin
		 * @return bool
		 */
		private function is_request( $type ) {
			switch ( $type ) {
				case 'admin' :
					return is_admin();
				case 'ajax' :
					return defined( 'DOING_AJAX' );
				case 'cron' :
					return defined( 'DOING_CRON' );
				case 'frontend' :
					return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
			}
		}

		/**
		 * Include required core files used in admin and on the frontend.
		 */
		public function includes() {

			/**
			 * Functions used in frontend and admin
			 */
			include_once( 'inc/lpm-core-functions.php' );

			include_once( 'inc/frontend/lpm-functions.php' );

			if ( $this->is_request( 'admin' ) ) {
				include_once( 'inc/admin/class-lpm-admin.php' );
			}

			if ( $this->is_request( 'ajax' ) ) {
				include_once( 'inc/ajax/lpm-ajax-functions.php' );
			}

			if ( $this->is_request( 'frontend' ) ) {
				include_once( 'inc/frontend/lpm-template-hooks.php' );
				include_once( 'inc/frontend/class-lpm-shortcode.php' );
			}
		}

		/**
		 * Function used to Init LaStudio Playlist Template Functions - This makes them pluggable by plugins and themes.
		 */
		public function include_template_functions() {
			include_once( 'inc/frontend/lpm-template-functions.php' );
		}

		/**
		 * register_widget function.
		 *
		 * @access public
		 * @return void
		 */
		public function register_widget() {

			// Include
			include_once( 'inc/class-lpm-playlist-widget.php' );

			// Register widget
			register_widget( 'LPM_Playlist_Widget' );
		}

		/**
		 * Init LaStudio Playlist when WordPress Initialises.
		 */
		public function init() {
			// Before init action
			do_action( 'before_lastudio_playlist_manager_init' );

			// Set up localisation
			$this->load_plugin_textdomain();

			// Variables
			$this->template_url = apply_filters( 'lastudio_playlist_manager_url', 'templates/playlist/' );

			// Classes/actions loaded for the frontend and for ajax requests
			if ( ! is_admin() || defined( 'DOING_AJAX' ) ) {

				// Hooks
				add_filter( 'template_include', array( $this, 'template_loader' ) );

			}

			// Hooks
			//add_action( 'widgets_init', array( $this, 'register_widget' ) );

			$this->register_post_type();

			$this->flush_rewrite_rules();

			// Init action
			do_action( 'lastudio_playlist_manager_init' );
		}

		/**
		 * Register post type
		 */
		public function register_post_type() {
			include_once( 'inc/lpm-register-post-type.php' );
		}

		/**
		 * Load a template.
		 *
		 * Handles template usage so that we can use our own templates instead of the themes.
		 *
		 * @param mixed $template
		 * @return string
		 */
		public function template_loader( $template ) {

			$find = array();
			$file = '';

			if ( is_single() && 'lpm_playlist' == get_post_type() ) {

				$file    = 'single-playlist.php';
				$find[] = $file;
				$find[] = $this->template_url . $file;

			// } elseif ( is_tax( 'lpm_playlist_type' ) ) {

			// 	$term = get_queried_object();

			// 	$file   = 'taxonomy-' . $term->taxonomy . '.php';
			// 	$find[] = 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
			// 	$find[] = $this->template_url . 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
			// 	$find[] = $file;
			// 	$find[] = $this->template_url . $file;


			}

			if ( $file ) {
				$template = locate_template( $find );
				if ( ! $template ) $template = $this->plugin_path() . '/templates/' . $file;
			}

			return $template;
		}

		/**
		 * Loads the plugin text domain for translation
		 */


		public function load_plugin_textdomain() {
			$domain = 'lastudio-playlist-manager';
			load_plugin_textdomain(
				$domain,
				false,
				dirname( plugin_basename( __FILE__ ) ) . '/languages/'
			);
		}

		/**
		 * Get the plugin url.
		 * @return string
		 */
		public function plugin_url() {
			return untrailingslashit( plugins_url( '/', __FILE__ ) );
		}

		/**
		 * Get the plugin path.
		 * @return string
		 */
		public function plugin_path() {
			return untrailingslashit( plugin_dir_path( __FILE__ ) );
		}

		/**
		 * Get the template path.
		 * @return string
		 */
		public function template_path() {
			return apply_filters( 'lpm_template_path', 'templates/playlist/' );
		}

		/**
		 * Get Ajax URL.
		 * @return string
		 */
		public function ajax_url() {
			return admin_url( 'admin-ajax.php', 'relative' );
		}
	}
} // endif class exists

/**
 * Returns the main instance of LPM to prevent the need to use globals.
 *
 * @return LaStudio_Playlist_Manager
 */
function LPM() {
	return LaStudio_Playlist_Manager::instance();
}

LPM(); // Go