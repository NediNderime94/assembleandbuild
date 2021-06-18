<?php
/**
 * LaStudioVideos Hooks
 *
 * Action/filter hooks used for LaStudioVideos functions/templates
 *
 * @author LaStudio
 * @category Core
 * @package LaStudioVideos/Templates
 * @since 1.0.3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Body class
 *
 * @see  wfolio_body_class()
 */
add_filter( 'body_class', 'lv_body_class' );

/**
 * WP Header
 *
 * @see  lastudio_videos_generator_tag()
 */
add_action( 'get_the_generator_html', 'lastudio_videos_generator_tag', 10, 2 );
add_action( 'get_the_generator_xhtml', 'lastudio_videos_generator_tag', 10, 2 );

/** Template Hooks ********************************************************/

if ( ! is_admin() || defined('DOING_AJAX') ) {

	/**
	 * Content Wrappers
	 *
	 * @see lastudio_videos_output_content_wrapper()
	 * @see lastudio_videos_output_content_wrapper_end()
	 */
	add_action( 'lastudio_videos_before_main_content', 'lastudio_videos_output_content_wrapper', 10 );
	add_action( 'lastudio_videos_after_main_content', 'lastudio_videos_output_content_wrapper_end', 10 );
}

/** Event Hooks *****************************************************/

add_action( 'template_redirect', 'lastudio_videos_template_redirect', 40 );