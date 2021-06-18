<?php
/**
 * LaStudio Discography Hooks
 *
 * Action/filter hooks used for LaStudioDiscography functions/templates
 *
 * @author LaStudio
 * @category Core
 * @package LaStudioDiscography/Templates
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed direct
}

/**
 * Body class
 *
 * @see  ld_body_class()
 */
add_filter( 'body_class', 'ld_body_class' );

/**
 * WP Header
 *
 * @see  ld_generator_tag()
 */
add_action( 'get_the_generator_html', 'ld_generator_tag', 10, 2 );
add_action( 'get_the_generator_xhtml', 'ld_generator_tag', 10, 2 );

/**
 * Content wrappers
 *
 * @see lastudio_discography_output_content_wrapper()
 * @see lastudio_discography_output_content_wrapper_end()
 */
add_action( 'lastudio_discography_before_main_content', 'lastudio_discography_output_content_wrapper', 10 );
add_action( 'lastudio_discography_after_main_content', 'lastudio_discography_output_content_wrapper_end', 10 );

add_action( 'template_redirect', 'lastudio_discography_template_redirect', 40 );