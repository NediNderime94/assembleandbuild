<?php
/**
 * LaStudio Discography core functions
 *
 * General core functions available on admin and frontend
 *
 * @author LaStudio
 * @category Core
 * @package LaStudioDiscography/Core
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * lastudio_discography page IDs
 *
 * retrieve page ids - used for the main discography page
 *
 * returns -1 if no page is found
 *
 * @param string $page
 * @return int
 */
function lastudio_discography_get_page_id() {

	$page_id = -1;

	if ( -1 != get_option( '_lastudio_discography_page_id' ) && get_option( '_lastudio_discography_page_id' ) ) {

		$page_id = get_option( '_lastudio_discography_page_id' );

	}

	if ( -1 != $page_id ) {
		$page_id = apply_filters( 'wpml_object_id', absint( $page_id ), 'page', true ); // filter for WPML
	}

	return $page_id;
}

/**
 * lastudio_discography page link
 *
 * retrieve discography page permalink
 *
 *
 * @param string $page
 * @return string
 */
function lastudio_discography_get_page_link() {

	$page_id = lastudio_discography_get_page_id();

	if ( $page_id != -1 ) {
		return get_permalink( $page_id );
	}
}

/**
 * Get template part (for templates like the release-loop).
 *
 * @param mixed $slug
 * @param string $name (default: '')
 */
function lastudio_discography_get_template_part( $slug, $name = '' ) {
	$template = '';

	$lastudio_discography = LD();

	// Look in yourtheme/slug-name.php and yourtheme/lastudio_discography/slug-name.php
	if ( $name )
		$template = locate_template( array( "{$slug}-{$name}.php", "{$lastudio_discography->template_url}{$slug}-{$name}.php" ) );

	// Get default slug-name.php
	if ( ! $template && $name && file_exists( $lastudio_discography->plugin_path() . "/templates/{$slug}-{$name}.php" ) )
		$template = $lastudio_discography->plugin_path() . "/templates/{$slug}-{$name}.php";

	// If template file doesn't exist, look in yourtheme/slug.php and yourtheme/lastudio_discography/slug.php
	if ( ! $template )
		$template = locate_template( array( "{$slug}.php", "{$lastudio_discography->template_url}{$slug}.php" ) );

	if ( $template )
		load_template( $template, false );
}


/**
 * Get other templates (e.g. ticket attributes) passing attributes and including the file.
 *
 * @param mixed $template_name
 * @param array $args (default: array())
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 */
function lastudio_discography_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {

	if ( $args && is_array($args) )
		extract( $args );

	$located = lastudio_discography_locate_template( $template_name, $template_path, $default_path );

	do_action( 'lastudio_discography_before_template_part', $template_name, $template_path, $located, $args );

	include( $located );

	do_action( 'lastudio_discography_after_template_part', $template_name, $template_path, $located, $args );
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
 * @param mixed $template_name
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return string
 */
function lastudio_discography_locate_template( $template_name, $template_path = '', $default_path = '' ) {

	if ( ! $template_path ) $template_path = LD()->template_url;
	if ( ! $default_path ) $default_path = LD()->plugin_path() . '/templates/';

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
	return apply_filters( 'lastudio_discography_locate_template', $template, $template_name, $template_path );
}

/**
 * Widget function
 *
 * Displays the show list in the widget
 *
 * @param int $count, string $url, bool $link
 * @return string
 */
function lastudio_get_release_option( $value, $default = null ) {

	$lastudio_releases_settings = get_option( 'lastudio_release_settings' );

	if ( isset( $lastudio_releases_settings[ $value ] ) && '' != $lastudio_releases_settings[ $value ] ) {

		return $lastudio_releases_settings[ $value ];

	}
	elseif( $default ) {

		return $default;
	}
}

/**
 * Discography Widget function
 *
 * Displays the discography widget
 *
 * @param int $count
 * @return string
 */
function lastudio_widget_discography( $count = 3 ) {
	global $wpdb;
	$query = new WP_Query( array(
			'post_type' => 'release',
			'posts_per_page' => $count
		)
	);


	if ( $query->have_posts() ) {
		$i = 0;
		while ( $query->have_posts() ) {
			$query->the_post();
			$i ++;
			$post_id = get_the_ID();
			$class = $i == 1 ? ' class="release-widget-first-child"' : '';
			$thumb = $i == 1 ? 'CD' : 'thumbnail';
			?><a<?php echo $class; ?> href="<?php echo the_permalink() ?>"><?php the_post_thumbnail( 'CD' ); ?></a><?php
		}
		echo '<div style="clear:both"></div>';
	} else {
		echo "<p>";
		_e( 'No release to display yet.', 'lastudio-discography' );
		echo "</p>";
	}
	wp_reset_postdata();
}

/**
 * Last Release Widget function
 *
 * Displays the last release widget
 *
 * @return string
 */
function lastudio_widget_last_release() {
	global $wpdb;
	$query = new WP_Query( array(
			'post_type' => 'release',
			'posts_per_page' => 1
		)
	);

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$post_id = get_the_ID();
			$thumbnail_size = get_post_meta( $post_id, '_lastudio_release_type', true ) == 'DVD' || get_post_meta( $post_id, '_lastudio_release_type', true ) == 'K7' ? 'DVD' : 'CD';
			?>
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( $thumbnail_size ); ?></a>
			<h4 class="entry-title"><a title="<?php esc_html_e( 'View Details', 'lastudio-discography' ); ?>" class="entry-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
			<?php
		}
	} else {
		echo "<p>";
		esc_html_e( 'No release to display yet.', 'lastudio-discography' );
		echo "</p>";
	}
	wp_reset_postdata();
}