<?php
/**
 * LaStudio Events frontend functions
 *
 * General functions available on frontend
 *
 * @author LaStudio
 * @category Core
 * @package LaStudioEvents/Frontend
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Events
 */
function lastudio_events( $args = array() ) {
	include_once( 'class-lastudio-events.php' );
	$events = new LE_Frontend();
	return $events->events( $args );
}


/**
 * Event list
 */
function lastudio_event_list( $args = array() ) {
	include_once( 'class-lastudio-events.php' );
	$events = new LE_Frontend();
	return $events->event_list( $args );
}

/**
 * Event meta
 */
function le_get_event_meta( $post_id = '' ) {
	$post_id = ( $post_id ) ? $post_id : get_the_ID();
	include_once( 'class-lastudio-events.php' );
	$events = new LE_Frontend();
	return $events->get_event_meta( $post_id );
}

/**
 * Sanitize_iframe
 *
 * @param string $iframe
 * @return string
 */
function le_sanitize_iframe( $iframe ) {

	return wp_kses( $iframe, array(
		'iframe' => array(
			'src' => array(),
		),
	) );
}

/**
 * Get custom iframe code
 *
 * @param string $iframe
 * @return string
 */
function le_get_iframe(  $iframe ) {

	if ( preg_match( '/src=("|\')?([a-zA-Z0-9:\/\'?!=.+%-_]+)("|\')?"/', $iframe, $match ) ) {

		if ( isset( $match[2] ) ) {
			$src = $match[2];

			return '<iframe width="100%" height="250" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="' . esc_url( $src ) . '&amp;output=embed"></iframe>';
		}
	}
}

/**
 * Sanitize formatted date in list
 *
 * @param string $date
 * @return string $date
 */
function le_sanitize_date( $date ) {
	$date = wp_kses( $date, array(
		'span' => array(
			'href' => array(),
			'class' => array(),
			'id' => array(),
			'rel' => array(),
			'itemprop' => array(),
		),
		'strong' => array(
			'class' => array(),
			'id' => array(),
			'itemprop' => array(),
		),
		'em' => array(
			'class' => array(),
			'id' => array(),
			'itemprop' => array(),
		),
		'div' => array(
			'class' => array(),
			'id' => array(),
			'itemprop' => array(),
		),
	) );

	return $date;
}

/**
 * Sanitize action (buy ticket, cancelled, sold out, free)
 *
 * @param string $date
 * @return string $date
 */
function le_sanitize_action( $action ) {
	$action = wp_kses( $action, array(
		'a' => array(
			'href' => array(),
			'class' => array(),
			'id' => array(),
			'rel' => array(),
			'itemprop' => array(),
		),
		'span' => array(
			'class' => array(),
			'id' => array(),
			'rel' => array(),
			'itemprop' => array(),
		),
	) );
	return $action;
}


/**
 * Returns post thumbnail URL
 *
 * @param string $format
 * @param int $post_id
 * @return string
 */
function le_get_post_thumbnail_url( $format, $post_id = null ) {
	global $post;

	if ( is_object( $post ) && isset( $post->ID ) && $post_id == null ) {
		$ID = $post->ID;
	} else {
		$ID = $post_id;
	}

	if ( $ID && has_post_thumbnail( $ID ) ) {

		$attachment_id = get_post_thumbnail_id( $ID );
		if ( $attachment_id ){
			$img_src = wp_get_attachment_image_src( $attachment_id, $format );

			if ( $img_src && isset( $img_src[0] ) ){
				return $img_src[0];
			}
		}
	}
}

/**
 * Handle redirects before content is output - hooked into template_redirect so is_page albums.
 *
 * @access public
 * @return void
 */
function le_template_redirect() {

	if ( is_page( lastudio_events_get_page_id() ) && ! post_password_required() ) {
		le_get_template( 'events.php' );
		exit();
	}
}

/**
 * Add specific class to the event depending on context
 *
 * @param array $classes
 * @return array $classes
 */
function le_post_classes( $classes ) {

	if ( 'event' === get_post_type() ) {
		$cancelled = get_post_meta( get_the_ID(), '_lastudio_event_cancel', true );
		$soldout = get_post_meta( get_the_ID(), '_lastudio_event_soldout', true );

		if ( $cancelled ) {

			$classes[] = 'le-cancelled';

		} elseif ( $soldout ) {

			$classes[] = 'le-soldout';

		}
	}

	return $classes;
}
add_filter( 'post_class', 'le_post_classes' );