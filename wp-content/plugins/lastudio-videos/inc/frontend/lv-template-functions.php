<?php
/**
 * LaStudioVideos Template Functions
 *
 * Functions used in the template files to output content - in most cases hooked in via the template actions. All functions are pluggable.
 *
 * @author LaStudio
 * @category Core
 * @package LaStudioVideos/Templates
 * @since 1.0.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Output generator tag to aid debugging.
 */
function lastudio_videos_generator_tag( $gen, $type ) {
	switch ( $type ) {
		case 'html':
			$gen .= "\n" . '<meta name="generator" content="LaStudioVideos ' . esc_attr( LV_VERSION ) . '">';
			break;
		case 'xhtml':
			$gen .= "\n" . '<meta name="generator" content="LaStudioVideos ' . esc_attr( LV_VERSION ) . '" />';
			break;
	}
	return $gen;
}

/**
 * Add specific class to the body when we're on the portfolio pages
 *
 * @since 1.1.6
 * @param array $classes
 * @return array $classes
 */
function lv_body_class( $classes ) {

	if (
		! is_singular( 'la_video' )
		&& ( 'la_video' == get_post_type() || ( function_exists( 'lastudio_videos_get_page_id' ) && is_page( lastudio_videos_get_page_id() ) ) )
		&& ! is_search()
	) {
		$classes[] = 'lastudio-videos';
		$classes[] = 'lastudio-videos-cols-' . lastudio_videos_get_option( 'col', 3 );
	}

	return $classes;
}

/** Global ****************************************************************/

if ( ! function_exists( 'lastudio_videos_output_content_wrapper' ) ) {

	/**
	 * Output the start of the page wrapper.
	 *
	 * @access public
	 * @return void
	 */
	function lastudio_videos_output_content_wrapper() {
		lastudio_videos_get_template( 'videos/wrapper-start.php' );
	}
}


if ( ! function_exists( 'lastudio_videos_output_content_wrapper_end' ) ) {

	/**
	 * Output the end of the page wrapper.
	 *
	 * @access public
	 * @return void
	 */
	function lastudio_videos_output_content_wrapper_end() {
		lastudio_videos_get_template( 'videos/wrapper-end.php' );
	}
}

if ( ! function_exists( 'lastudio_videos_loop_start' ) ) {

	/**
	 * Output the start of a ticket loop. By default this is a UL
	 *
	 * @access public
	 * @return void
	 */
	function lastudio_videos_loop_start( $echo = true ) {
		ob_start();
		
		lastudio_videos_get_template( 'loop/loop-start.php' );
		
		if ( $echo )
			echo ob_get_clean();
		else
			return ob_get_clean();
	}
}


if ( ! function_exists( 'lastudio_videos_loop_end' ) ) {

	/**
	 * Output the end of a ticket loop. By default this is a UL
	 *
	 * @access public
	 * @return void
	 */
	function lastudio_videos_loop_end( $echo = true ) {
		ob_start();

		lastudio_videos_get_template( 'loop/loop-end.php' );

		if ( $echo )
			echo ob_get_clean();
		else
			return ob_get_clean();
	}
}