<?php
/**
 * LaStudio Events template functions
 *
 * Functions for the templating system.
 *
 * @author LaStudio
 * @category Core
 * @package LaStudioEvents/Functions
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Output generator tag to aid debugging.
 */
function le_generator_tag( $gen, $type ) {
	switch ( $type ) {
		case 'html':
			$gen .= "\n" . '<meta name="generator" content="LaStudioEvents ' . esc_attr( LE_VERSION ) . '">';
			break;
		case 'xhtml':
			$gen .= "\n" . '<meta name="generator" content="LaStudioEvents ' . esc_attr( LE_VERSION ) . '" />';
			break;
	}
	return $gen;
}

/**
 * Add body classes
 *
 * @param  array $classes
 * @return array
 */
function le_body_class( $classes ) {

	$classes = ( array ) $classes;

	$classes[] = 'lastudio-events';
	$classes[] = sanitize_title_with_dashes( get_template() ); // theme slug

	if ( is_singular( 'event' ) ) {
		$classes[] = 'single-event';
	}

	return array_unique( $classes );
}

/** Global ****************************************************************/

if ( ! function_exists( 'le_output_content_wrapper' ) ) {

	/**
	 * Output the start of the page wrapper.
	 *
	 */
	function le_output_content_wrapper() {
		le_get_template( 'global/wrapper-start.php' );
	}
}

if ( ! function_exists( 'le_output_content_wrapper_end' ) ) {

	/**
	 * Output the end of the page wrapper.
	 *
	 */
	function le_output_content_wrapper_end() {
		le_get_template( 'global/wrapper-end.php' );
	}
}