<?php
/**
 * LaStudio Events core functions
 *
 * General core functions available on admin and frontend
 *
 * @author LaStudio
 * @category Core
 * @package LaStudioEvents/Core
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Event meta
 *
 * @param string $date mysql formatted date
 * @return string $date
 */
function le_nice_date( $date ) {
	return date( get_option( 'date_format' ), strtotime( $date ) );
}

/**
 * lastudio_events page ID
 *
 * retrieve page id - used for the main albums page
 *
 *
 * @access public
 * @return int
 */
function lastudio_events_get_page_id() {

	$page_id = -1;

	if ( -1 != get_option( '_lastudio_events_page_id' ) && get_option( '_lastudio_events_page_id' ) ) {

		$page_id = get_option( '_lastudio_events_page_id' );

	}

	if ( -1 != $page_id ) {
		$page_id = apply_filters( 'wpml_object_id', absint( $page_id ), 'page', true ); // filter for WPML
	}

	return $page_id;
}

/**
 * Returns the URL of the events page
 */
function lastudio_get_events_url() {

	$page_id = lastudio_events_get_page_id();

	if ( -1 != $page_id ) {
		return get_permalink( $page_id );
	}
}

/**
 * Returns event date
 *
 * @param string $date, bool $custom
 * @return string
 */
function le_get_event_date( $date = null, $custom = null ) {

	if ( ! $date ) return;

	list( $month, $day, $year ) = explode( '-', $date );
	$sql_date = $year . '-' . $month . '-' . $day . ' 00:00:00';

	$format = $custom ? le_get_option( 'date_format' ) : get_option( 'date_format' );

	if ( $format == '\c\u\s\t\o\m' ) {
		$format = le_get_option( 'date_format_custom' );
	}

	if ( $date && $format != 'le_date' ) {
		return mysql2date( $format, $sql_date );
	}
	elseif ( $date ) {
		return le_custom_date_format( $date );
	}
}

/**
 * Get option
 *
 * @param string $value
 * @return string
 */
function le_get_option( $value = null, $default = null ) {

	global $options;

	$lastudio_events_settings = get_option( 'lastudio_events_settings' );

	if ( isset( $lastudio_events_settings[ $value ] ) && '' != $lastudio_events_settings[ $value ] ) {

		return $lastudio_events_settings[ $value ];

	} elseif ( $default ) {

		return $default;
	}
}

/**
 * Check if an event date is past
 *
 * @param string $date
 * @return bool
 */
function le_is_past_show( $date = null ) {

	if ( $date ) {
		list( $day, $month, $year ) = explode( '-', $date );
		$sql_date = $year . '-' . $month . '-' . $day . ' 00:00:00';

		$interval = ( strtotime( date( 'Y-m-d H:i:s' ) ) - strtotime( $sql_date ) );

		return $interval > 0;
	}
}

/**
 * Get template part (for templates like the release-loop).
 *
 * @access public
 * @param mixed $slug
 * @param string $name (default: '')
 * @return void
 */
function le_get_template_part( $slug, $name = '' ) {

	$lastudio_events = LE();
	$template = '';

	// Look in yourtheme/slug-name.php and yourtheme/lastudio-albums/slug-name.php
	if ( $name )
		$template = locate_template( array( "{$slug}-{$name}.php", "{$lastudio_events->template_url}{$slug}-{$name}.php" ) );

	// Get default slug-name.php
	if ( ! $template && $name && file_exists( $lastudio_events->plugin_path() . "/templates/{$slug}-{$name}.php" ) )
		$template = $lastudio_events->plugin_path() . "/templates/{$slug}-{$name}.php";

	// If template file doesn't exist, look in yourtheme/slug.php and yourtheme/lastudio-albums/slug.php
	if ( ! $template )
		$template = locate_template( array( "{$slug}.php", "{$lastudio_events->template_url}{$slug}.php" ) );

	if ( $template )
		load_template( $template, false );
}

/**
 * Get other templates (e.g. ticket attributes) passing attributes and including the file.
 *
 * @access public
 * @param mixed $template_name
 * @param array $args (default: array())
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return void
 */
function le_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {

	if ( $args && is_array($args) )
		extract( $args );

	$located = le_locate_template( $template_name, $template_path, $default_path );

	do_action( 'le_before_template_part', $template_name, $template_path, $located, $args );

	include( $located );

	do_action( 'le_after_template_part', $template_name, $template_path, $located, $args );
}

/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 * yourtheme/$template_path/$template_name
 * yourtheme/$template_name
 * $default_path/$template_name
 *
 * @access public
 * @param mixed $template_name
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return string
 */
function le_locate_template( $template_name, $template_path = '', $default_path = '' ) {

	if ( ! $template_path ) $template_path = LE()->template_url;
	if ( ! $default_path ) $default_path = LE()->plugin_path() . '/templates/';

	// Look within passed path within the theme - this is priority
	$template = locate_template(
		array(
			trailingslashit( $template_path ) . $template_name,
			$template_name
		)
	);

	// Get default template
	if ( ! $template )
		$template = $default_path . $template_name;

	// Return what we found
	return apply_filters( 'le_locate_template', $template, $template_name, $template_path );
}

/**
 * Create a formatted sample of any text
 *
 * Remove HTML and shortcode, sanitize and shorten a string
 *
 * @param string $text
 * @param int $num_words
 * @param string $more
 * @return string
 */
function le_sample( $text, $num_words  = 55, $more = '...' ) {
	return wp_trim_words( strip_shortcodes( $text ), $num_words, $more );
}
/**
 * Remove all double spaces
 *
 * This function is mainly used to clean up inline CSS
 *
 * @param string $css
 * @return string
 */
function le_clean_spaces( $string, $hard = true ) {

	return preg_replace( '/\s+/', ' ', $string );
}

/**
 * "order by" SQL filter
 *
 * @param string $orderby
 * @return string
 */
function le_order_by( $orderby ) {
	global $wpdb;
	$meta = $wpdb->prefix . 'postmeta';
	$new_orderby = str_replace( "$meta.meta_value", "STR_TO_DATE( $meta.meta_value, '%d-%m-%Y' )", $orderby );
	return $new_orderby;
}

/**
 * "where" SQL filter
 *
 * for future events
 *
 * @param string $where
 * @return string
 */
function le_future_where( $where ) { // future events
	global $wpdb;
	$meta = $wpdb->prefix . 'postmeta';
	$where .= "AND STR_TO_DATE( $meta.meta_value,'%d-%m-%Y' ) >= CURDATE()";
	return $where;
}

/**
 * "where" SQL filter
 *
 * for past events
 *
 * @param string $where
 * @return string
 */
function le_past_where( $where ) { // past events
	global $wpdb;
	$meta = $wpdb->prefix . 'postmeta';
	$where .= "AND STR_TO_DATE( $meta.meta_value,'%d-%m-%Y' ) < CURDATE()";
	return $where;
}