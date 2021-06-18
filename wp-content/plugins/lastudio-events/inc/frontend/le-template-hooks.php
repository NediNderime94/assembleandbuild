<?php
/**
 * LaStudio Events Template Hooks
 *
 * Action/filter hooks used for LaStudio Events functions/templates
 *
 * @author LaStudio
 * @category Core
 * @package LaStudioEvents/Templates
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Body class
 *
 * @see  le_body_class()
 */
add_filter( 'body_class', 'le_body_class' );

/**
 * WP Header
 *
 * @see  le_generator_tag()
 */
add_action( 'get_the_generator_html', 'le_generator_tag', 10, 2 );
add_action( 'get_the_generator_xhtml', 'le_generator_tag', 10, 2 );

/**
 * Content Wrappers
 *
 * @see le_output_content_wrapper()
 * @see le_output_content_wrapper_end()
 */
add_action( 'le_before_main_content', 'le_output_content_wrapper', 10 );
add_action( 'le_after_main_content', 'le_output_content_wrapper_end', 10 );

/**
 * Template redirect
 *
 * @see  le_template_redirect()
 */
add_action( 'template_redirect', 'le_template_redirect', 40 );