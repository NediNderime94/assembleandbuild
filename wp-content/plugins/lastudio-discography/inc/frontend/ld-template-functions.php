<?php
/**
 * LaStudio Discography Template Functions
 *
 * Functions used in the template files to output content - in most cases hooked in via the template actions. All functions are pluggable.
 *
 * @author LaStudio
 * @category Core
 * @package LaStudioDiscography/Templates
 * @since 1.0.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Output generator tag to aid debugging.
 */
function ld_generator_tag( $gen, $type ) {
	switch ( $type ) {
		case 'html':
			$gen .= "\n" . '<meta name="generator" content="LaStudioDiscography ' . esc_attr( LD_VERSION ) . '">';
			break;
		case 'xhtml':
			$gen .= "\n" . '<meta name="generator" content="LaStudioDiscography ' . esc_attr( LD_VERSION ) . '" />';
			break;
	}
	return $gen;
}

/**
 * Add specific class to the body when we're on the discography page
 *
 * @since 1.2.6
 * @param array $classes
 * @return array $classes
 */
function ld_body_class( $classes ) {

	if ( is_page( lastudio_discography_get_page_id() ) ) {
		$classes[] = 'discography-page';
	}

	if (
		! is_singular( 'ld_release' )
		&& ( 'ld_release' == get_post_type() || ( function_exists( 'lastudio_discography_get_page_id' ) && is_page( lastudio_discography_get_page_id() ) ) )
	) {
		$classes[] = 'lastudio-discography';
	}

	return $classes;
}

if ( ! function_exists( 'lastudio_discography_output_content_wrapper' ) ) {

	/**
	 * Output the start of the page wrapper.
	 *
	 * @access public
	 * @return void
	 */
	function lastudio_discography_output_content_wrapper() {
		lastudio_discography_get_template( 'global/wrapper-start.php' );
	}
}


if ( ! function_exists( 'lastudio_discography_output_content_wrapper_end' ) ) {

	/**
	 * Output the end of the page wrapper.
	 *
	 * @access public
	 * @return void
	 */
	function lastudio_discography_output_content_wrapper_end() {
		lastudio_discography_get_template( 'global/wrapper-end.php' );
	}
}

if ( ! function_exists( 'lastudio_discography_loop_start' ) ) {

	/**
	 * Output the start of a ticket loop. By default this is a UL
	 *
	 * @access public
	 * @return void
	 */
	function lastudio_discography_loop_start( $echo = true ) {
		ob_start();
		lastudio_discography_get_template( 'loop/loop-start.php' );
		if ( $echo )
			echo ob_get_clean();
		else
			return ob_get_clean();
	}
}


if ( ! function_exists( 'lastudio_discography_loop_end' ) ) {

	/**
	 * Output the end of a ticket loop. By default this is a UL
	 *
	 * @access public
	 * @return void
	 */
	function lastudio_discography_loop_end( $echo = true ) {
		ob_start();

		lastudio_discography_get_template( 'loop/loop-end.php' );

		if ( $echo )
			echo ob_get_clean();
		else
			return ob_get_clean();
	}
}