<?php
/**
 * LaStudio Playlist Template Hooks
 *
 * Action/filter hooks used for LaStudio Playlist functions/templates
 *
 * @author LaStudio
 * @category Core
 * @package LaStudioPlaylistManager/Templates
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Body class
 *
 * @see  lpm_body_class()
 */
add_filter( 'body_class', 'lpm_body_class' );

/**
 * WP Header
 *
 * @see  lpm_generator_tag()
 */
add_action( 'get_the_generator_html', 'lpm_generator_tag', 10, 2 );
add_action( 'get_the_generator_xhtml', 'lpm_generator_tag', 10, 2 );