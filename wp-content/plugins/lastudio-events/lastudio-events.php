<?php
/**
 * Plugin Name: LaStudio Events
 * Plugin URI: http://la-studioweb.com/plugin/lastudio-events
 * Description: A plugin to manage your events
 * Version: 1.0.0
 * Author: LaStudio
 * Author URI: http://la-studioweb.com
 * Requires at least: 4.9
 * Tested up to: 4.9.5
 *
 * Text Domain: lastudio-events
 * Domain Path: /languages/
 *
 * @package LaStudioEvents
 * @category Core
 * @author LaStudio
 *
 * Copyright (C) 2018 LaStudio
 * This WordPress Plugin is a free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * It is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * See http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'LaStudio_Events' ) ) {
	/**
	 * Main LaStudio_Events Class
	 *
	 * Contains the main functions for LaStudio_Events
	 *
	 * @class LaStudio_Events
	 * @version 1.0.0
	 * @since 1.0.0
	 */
	class LaStudio_Events {

		/**
		 * @var string
		 */
		private $required_php_version = '5.6.0';

		/**
		 * @var string
		 */
		public $version = '1.0.0';

		/**
		 * @var LaStudio Events The single instance of the class
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
		 * Main LaStudio Events Instance
		 *
		 * Ensures only one instance of LaStudio Events is loaded or can be loaded.
		 *
		 * @static
		 * @see LE()
		 * @return LaStudio Events - Main instance
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * LaStudio Events Constructor.
		 */
		public function __construct() {

			$this->define_constants();
			$this->includes();
			$this->init_hooks();

			do_action( 'le_loaded' );
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

			add_option( '_lastudio_events_needs_page', true );

			if ( ! get_option( '_le_flush_rewrite_rules_flag' ) ) {
				add_option( '_le_flush_rewrite_rules_flag', true );
			}
		}

		/**
		 * Flush rewrite rules on plugin activation to avoid 404 error
		 */
		public function flush_rewrite_rules(){
			if ( get_option( '_le_flush_rewrite_rules_flag' ) ) {
				flush_rewrite_rules();
				delete_option( '_le_flush_rewrite_rules_flag' );
			}
		}

		/**
		 * Define LE Constants
		 */
		private function define_constants() {

			$constants = array(
				'LE_DEV' => false,
				'LE_DIR' => $this->plugin_path(),
				'LE_URI' => $this->plugin_url(),
				'LE_CSS' => $this->plugin_url() . '/assets/css',
				'LE_JS' => $this->plugin_url() . '/assets/js',
				'LE_SLUG' => plugin_basename( dirname( __FILE__ ) ),
				'LE_PATH' => plugin_basename( __FILE__ ),
				'LE_VERSION' => $this->version,
				'LE_UPDATE_URL' => $this->update_url,
				'LE_SUPPORT_URL' => $this->support_url,
				'LE_DOC_URI' => 'https://docs.la-studioweb.com/documentation/plugins/' . plugin_basename( dirname( __FILE__ ) ),
				'LE_LASTUDIO_DOMAIN' => 'la-studioweb.com',
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
			include_once( 'inc/le-core-functions.php' );
			include_once( 'inc/frontend/le-functions.php' );

			if ( $this->is_request( 'admin' ) ) {
				include_once( 'inc/admin/class-le-admin.php' );
			}

			if ( $this->is_request( 'ajax' ) ) {
				include_once( 'inc/ajax/le-ajax-functions.php' );
			}

			if ( $this->is_request( 'frontend' ) ) {
				include_once( 'inc/frontend/le-template-hooks.php' );
				include_once( 'inc/frontend/class-le-shortcode.php' );
			}
		}

		/**
		 * Function used to Init LaStudio Events Template Functions - This makes them pluggable by plugins and themes.
		 */
		public function include_template_functions() {
			include_once( 'inc/frontend/le-template-functions.php' );
		}

		/**
		 * register_widget function.
		 *
		 * @return void
		 */
		public function register_widget() {

			// Include
			//include_once( 'inc/class-le-events-widget.php' );
			include_once( 'inc/class-le-event-list-widget.php' );

			// Register widget
			//register_widget( 'LE_Events_Widget' );
			register_widget( 'LE_Event_List_Widget' );
		}

		/**
		 * Init LaStudio Events when WordPress Initialises.
		 */
		public function init() {
			// Before init action
			do_action( 'before_lastudio_events_init' );

			// Set up localisation
			$this->load_plugin_textdomain();

			// Variables
			$this->template_url = apply_filters( 'lastudio_events_template_url', 'templates/la-events/' );

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
			do_action( 'lastudio_events_init' );
		}

		/**
		 * Register post type
		 */
		public function register_post_type() {
			include_once( 'inc/le-register-post-type.php' );
		}

		/**
		 * Register taxonomy
		 */
		public function register_taxonomy() {
			include_once( 'inc/le-register-taxonomy.php' );
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

			if ( is_single() && 'event' == get_post_type() ) {

				$file    = 'single-event.php';
				$find[] = $file;
				$find[] = $this->template_url . $file;

			} elseif ( is_tax( 'artist' ) ) {

				$term = get_queried_object();

				$file   = 'taxonomy-' . $term->taxonomy . '.php';
				$find[] = 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
				$find[] = $this->template_url . 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
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

			$domain = 'lastudio-events';
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
			return apply_filters( 'le_template_path', 'templates/la-events/' );
		}
	} // end class
} // end class check

/**
 * Returns the main instance of LE to prevent the need to use globals.
 *
 * @return LaStudio_Events
 */
function LE() {
	return LaStudio_Events::instance();
}

LE(); // Go