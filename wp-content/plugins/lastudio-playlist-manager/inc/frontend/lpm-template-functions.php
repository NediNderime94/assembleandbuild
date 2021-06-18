<?php
/**
 * LaStudio Playlist template functions
 *
 * Functions for the templating system.
 *
 * @author LaStudio
 * @category Core
 * @package LaStudioPlaylistManager/Functions
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Output generator tag to aid debugging.
 */
function lpm_generator_tag( $gen, $type ) {
	switch ( $type ) {
		case 'html':
			$gen .= "\n" . '<meta name="generator" content="LaStudioPlaylist ' . esc_attr( LPM_VERSION ) . '">';
			break;
		case 'xhtml':
			$gen .= "\n" . '<meta name="generator" content="LaStudioPlaylist ' . esc_attr( LPM_VERSION ) . '" />';
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
function lpm_body_class( $classes ) {

	$classes = ( array ) $classes;

	$classes[] = 'lastudio-playlist-manager';
	$classes[] = sanitize_title_with_dashes( get_template() ); // theme slug

	// Specify if a sticky player is set
	if ( get_option( '_lpm_bar' ) || lpm_get_option( 'streaming_url' ) ) {
		$classes[] = 'is-lpm-bar-player';
	}

	// Specify if the sticky player is a streaming player
	if ( lpm_get_option( 'streaming_url' ) ) {
		$classes[] = 'lpm-bar-player-streaming';
	}

	return array_unique( $classes );
}