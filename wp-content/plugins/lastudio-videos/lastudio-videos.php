<?php
/**
 * Plugin Name: LaStudio Videos
 * Plugin URI: https://la-studioweb.com/plugin/lastudio-videos/
 * Description: A video gallery post type for your site
 * Version: 1.0.0
 * Author: LaStudio
 * Author URI: https://la-studioweb.com
 * Requires at least: 4.4.1
 * Tested up to: 4.9.4
 *
 * Text Domain: lastudio-videos
 * Domain Path: /languages/
 *
 * @package LaStudioVideos
 * @category Core
 * @author LaStudio
 *
 * Being a free product, this plugin is distributed as-is without official support.
 * Verified customers however, who have purchased a premium theme
 * at https://themeforest.net/user/LaStudio-Themes/portfolio?ref=LaStudio-Themes
 * will have access to support for this plugin in the forums
 * https://help.la-studioweb.com/
 *
 * Copyright (C) 2013 Constantin Saguin
 * This WordPress Plugin is a free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * It is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * See https://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Main LaStudio_Videos Class
 *
 * Contains the main functions for LaStudio_Videos
 *
 * @class LaStudio_Videos
 * @version 1.0.0
 * @since 1.0.0
 * @package LaStudioDiscography
 * @author LaStudio
 */
class LaStudio_Videos {

	/**
	 * @var string
	 */
	private $required_php_version = '5.6.0';

	/**
	 * @var string
	 */
	public $version = '1.0.0';

	/**
	 * @var LaStudio Videos The single instance of the class
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
	 * Main LaStudio Videos Instance
	 *
	 * Ensures only one instance of LaStudio Videos is loaded or can be loaded.
	 *
	 * @static
	 * @see WE()
	 * @return LaStudio Videos - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * LaStudio Videos Constructor.
	 */
	public function __construct() {

		if ( phpversion() < $this->required_php_version ) {
			add_action( 'admin_notices', array( $this, 'warning_php_version' ) );
			return;
		}

		$this->define_constants();
		$this->includes();
		$this->init_hooks();

		do_action( 'lv_loaded' );
	}

	/**
	 * Display error notice if PHP version is too low
	 */
	public function warning_php_version() {
		?>
		<div class="notice notice-error">
			<p><?php

			printf(
				esc_html__( '%1$s needs at least PHP %2$s installed on your server. You have version %3$s currently installed. Please contact your hosting service provider if you\'re not able to update PHP by yourself.', 'lastudio-videos' ),
				'LaStudio Videos',
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
	 * Activation function
	 */
	public function activate() {

		add_option( '_lastudio_videos_needs_page', true );

		if ( ! get_option( '_lastudio_videos_flush_rewrite_rules_flag' ) ) {
			add_option( '_lastudio_videos_flush_rewrite_rules_flag', true );
		}
	}

	/**
	 * Flush rewrite rules on plugin activation to avoid 404 error
	 */
	public function flush_rewrite_rules(){
		if ( get_option( '_lastudio_videos_flush_rewrite_rules_flag' ) ) {
			flush_rewrite_rules();
			delete_option( '_lastudio_videos_flush_rewrite_rules_flag' );
		}
	}

	/**
	 * Define WE Constants
	 */
	private function define_constants() {

		$constants = array(
			'LV_DEV' => false,
			'LV_DIR' => $this->plugin_path(),
			'LV_URI' => $this->plugin_url(),
			'LV_CSS' => $this->plugin_url() . '/assets/css',
			'LV_JS' => $this->plugin_url() . '/assets/js',
			'LV_SLUG' => plugin_basename( dirname( __FILE__ ) ),
			'LV_PATH' => plugin_basename( __FILE__ ),
			'LV_VERSION' => $this->version,
			'LV_UPDATE_URL' => $this->update_url,
			'LV_SUPPORT_URL' => $this->support_url,
			'LV_DOC_URI' => 'https://docs.la-studioweb.com/documentation/plugins/' . plugin_basename( dirname( __FILE__ ) ),
			'LV_LASTUDIO_DOMAIN' => 'la-studioweb.com',
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
		include_once( 'inc/lv-core-functions.php' );

		if ( $this->is_request( 'admin' ) ) {
			include_once( 'inc/admin/class-lv-admin.php' );
		}

		if ( $this->is_request( 'frontend' ) ) {
			include_once( 'inc/frontend/lv-functions.php' );
			include_once( 'inc/frontend/lv-template-hooks.php' );
			include_once( 'inc/frontend/class-lv-shortcode.php' );
		}
	}

	/**
	 * Function used to Init LaStudio Videos Template Functions - This makes them pluggable by plugins and themes.
	 */
	public function include_template_functions() {
		include_once( 'inc/frontend/lv-template-functions.php' );
	}

	/**
	 * register_widget function.
	 *
	 * @access public
	 * @return void
	 */
	public function register_widget() {

	}

	/**
	 * Init LaStudio Videos when WordPress Initialises.
	 */
	public function init() {
		// Before init action
		do_action( 'before_lastudio_videos_init' );

		// Set up localisation
		$this->load_plugin_textdomain();

		// Variables
		$this->template_url = apply_filters( 'lastudio_videos_template_url', 'templates/videos/' );

		// Classes/actions loaded for the frontend and for ajax requests
		if ( ! is_admin() || defined( 'DOING_AJAX' ) ) {

			// Hooks
			add_filter( 'template_include', array( $this, 'template_loader' ) );

		}

		// Hooks
		//add_action( 'widgets_init', array( $this, 'register_widget' ) );

		$this->register_post_type();
		$this->register_taxonomy();
		$this->flush_rewrite_rules();

		// Init action
		do_action( 'lastudio_videos_init' );
	}

	/**
	 * Register post type
	 */
	public function register_post_type() {
		include_once( 'inc/lv-register-post-type.php' );
	}

	/**
	 * Register taxonomy
	 */
	public function register_taxonomy() {
		include_once( 'inc/lv-register-taxonomy.php' );
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

		$find = array( 'lastudio-videos.php' ); // nope! not used
		$file = '';

		if ( is_single() && get_post_type() == 'la_video' ) {

			$file    = 'single-video.php';
			$find[] = $file;
			$find[] = $this->template_url . $file;

		} elseif ( is_tax( 'video_type' ) || is_tax( 'video_tag' ) ) {

			$term = get_queried_object();
			$file 		= 'archive-video.php';
			$find[] 	= 'taxonomy-video.php';
			$find[] 	= 'taxonomy-' . $term->taxonomy . '.php';
			$find[] 	= 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
			$find[] 	= $this->template_url . 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
			$find[] 	= $file;
			$find[] 	= $this->template_url . $file;

		}
		elseif ( is_post_type_archive( 'la_video' ) ) {

			$file = 'archive-video.php';
			$find[] = $file;
			$find[] = $this->template_url . $file;
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

		$domain = 'lastudio-videos';
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
		return apply_filters( 'lv_template_path', 'templates/videos/' );
	}

} // end class

/**
 * Returns the main instance of LV to prevent the need to use globals.
 *
 * @return LaStudio_Videos
 */
function LV() {
	return LaStudio_Videos::instance();
}

LV(); // Go