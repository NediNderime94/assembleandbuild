<?php
/**
 * LaStudio Events Admin.
 *
 * @class LE_Admin
 * @author LaStudio
 * @category Admin
 * @package LaStudioEvents/Admin
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * LE_Admin class.
 */
class LE_Admin {
	/**
	 * Constructor
	 */
	public function __construct() {

		// Includes files
		$this->includes();

		// Set metaboxes
		$this->metaboxes();

		// Admin init hooks
		$this->admin_init_hooks();
	}

	/**
	 * Include any classes we need within admin.
	 */
	public function includes() {
		include_once( 'class-le-options.php' );
		include_once( 'class-le-metabox.php' );
		include_once( 'le-admin-functions.php' );
	}

	/**
	 * Admin init
	 */
	public function admin_init_hooks() {

		// Plugin paypal row meta
		//add_filter( 'plugin_action_links_' . plugin_basename( LE_PATH ), array( $this, 'settings_action_links' ) );

		// Plugin update notifications
		add_action( 'admin_init', array( $this, 'plugin_update' ) );

		// Check if tour dates posts exist
		add_action( 'admin_notices', array( $this, 'wtd_update' ) );
		add_action( 'admin_notices', array( $this, 'wtd_updated_successfully' ) );

		// Check events index page
		add_action( 'admin_notices', array( $this, 'check_page' ) );
		add_action( 'admin_notices', array( $this, 'create_page' ) );

		// Hide editors from index page
		add_action( 'edit_form_after_title', array( $this, 'is_events_index_page' ) );
		add_action( 'admin_init', array( $this, 'hide_editor' ) );
		add_action( 'admin_head', array( $this, 'hide_wpb_editor' ) );

		// Add columns to post list
		add_filter( 'manage_event_posts_columns', array( $this, 'admin_columns_head_events' ), 10 );
		add_action( 'manage_event_posts_custom_column', array( $this, 'admin_columns_content_events' ), 10, 2 );
	}

	/**
	 * Add metaboxes
	 */
	public function metaboxes() {
		include_once( 'le-metaboxes.php' );
	}

	/**
	 * Invite to update from LaStudio Tour Dates
	 */
	public function wtd_update() {

		$is_tour_dates = class_exists( 'LaStudio_Tour_Dates' );

		// delete_option( '_lastudio_events_tour_dates_updated' );

		if ( isset( $_GET['lastudio_events_tour_dates_import'] ) || ! $is_tour_dates ) {
			return;
		}

		// WTD update declined
		if ( isset( $_GET['skip_lastudio_events_tour_dates_import'] ) ) {
			delete_option( '_lastudio_events_needs_tour_dates_update' );
			update_option( '_lastudio_events_tour_dates_updated', true );
			return;
		}

		// WTD already updated
		if ( $is_tour_dates && get_option( '_lastudio_events_tour_dates_updated' ) ) {
			return;
		} else {
			// flag update needed
			update_option( '_lastudio_events_needs_tour_dates_update', true );
		}

		$message = wp_kses(
			__( '<strong>LaStudio Events</strong> is the newer version of <strong>LaStudio Tour Dates</strong> plugin with more features and updates to come! Would you like to import your posts from LaStudio Tour Dates plugin?', 'lastudio-events' ),
			array(
				'a' => array(
					'href' => array(),
					'class' => array(),
					'title' => array(),
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			)
		);

		$message .= sprintf(
			wp_kses(
				__( '<br><br>
				<a href="%1$s" class="button button-primary">Import tour dates</a>
				&nbsp;
				<a href="%2$s" class="button">Skip</a>', 'lastudio-events' ),

				array(
						'a' => array(
							'href' => array(),
							'class' => array(),
							'title' => array(),
						),
						'br' => array(),
						'em' => array(),
						'strong' => array(),
					)
			),
			esc_url( admin_url( '?lastudio_events_tour_dates_import=true' ) ),
			esc_url( admin_url( '?skip_lastudio_events_tour_dates_import=true' ) )
		);

		$output = '<div class="updated"><p>';

			$output .= $message;

		$output .= '</p></div>';

		echo $output;

		return false;
	}

	/**
	 * Update from WTD done confirmation
	 */
	public function wtd_updated_successfully() {

		if ( isset( $_GET['lastudio_events_tour_dates_import'] ) && $_GET['lastudio_events_tour_dates_import'] == 'true' ) {

			// WTD import post here

			if ( $this->import_posts_from_wtd() ) {

				$message = esc_html__( 'Your posts have been successfully imported.', 'lastudio-events' );

				$output = '<div class="updated"><p>';

					$output .= $message;

				$output .= '</p></div>';

				echo $output;

			} else {
				$message = esc_html__( 'Importation failed :(.', 'lastudio-events' );

				$output = '<div class="error"><p>';

					$output .= $message;

				$output .= '</p></div>';

				echo $output;
			}
		}

		return false;
	}

	/**
	 * Import WTD posts as event posts
	 *
	 */
	public function import_posts_from_wtd() {

		$metabox_slugs = array(
			'date', 'city', 'time', 'country', 'contry_short', 'state', 'venue', 'address', 'zip', 'phone', 'email', 'website',
			'map', 'fb', 'url', 'price', 'free', 'soldout', 'cancel',
		);

		$old_posts = get_posts( array( 'post_type' => 'show', 'posts_per_page' => -1, ) ); // get all old shows

		foreach ( $old_posts as $post ) {

			$old_post_id = $post->ID;

			// get old taxonomy

			$args = array(
				'post_title' => $post->post_title,
				'post_content' => $post->post_content,
				'post_status' => 'publish',
				'post_type' => 'event',
			);

			// create new post
			$new_post_id = wp_insert_post( $args );

			// get taxonomy from old post
			$term_list = wp_get_post_terms( $post->ID, 'artist', array( 'fields' => 'all' ) );

			foreach( $term_list as $term ) {

				$new_term = term_exists( $term->name, 'artist' );

				if ( ! $new_term ) {

					// create term from old one if not already done
					wp_insert_term(
						$term->name,
						'artist',
						array(
							'description'=> $term->description,
							'slug' => $term->slug,
						)
					);
				}

				wp_set_post_terms( $new_post_id, $term->name, 'artist' );
			}

			//continue;

			if ( $new_post_id ) {

				// old metas
				foreach ( $metabox_slugs as $slug ) {

					if ( 'date' == $slug ) {
						$slug = 'start_date';
					}

					update_post_meta( $new_post_id, '_lastudio_event_' . $slug, get_post_meta( $old_post_id, '_lastudio_show_' . $slug, true ) );
				}

				if ( get_post_thumbnail_id( $old_post_id ) ) {
					update_post_meta( $new_post_id, '_thumbnail_id', get_post_thumbnail_id( $old_post_id ) );
					update_post_meta( $new_post_id, '_post_bg_type', 'image' );
				}
			}
		}

		// update shortcode in posts

		//delete_option( '_lastudio_events_needs_tour_dates_update' );
		//update_option( '_lastudio_events_tour_dates_updated', true );

		return true;
	}

	/**
	 * Check events page
	 *
	 * Display a notification if we can't get the events page id
	 *
	 */
	public function check_page() {

		$output    = '';
		$theme_dir = get_template_directory();

		// update_option( '_lastudio_events_needs_page', true );
		// delete_option( '_lastudio_events_no_needs_page', true );
		// delete_option( '_lastudio_events_page_id' );

		if ( get_option( '_lastudio_events_no_needs_page' ) ) {
			return;
		}

		if ( ! get_option( '_lastudio_events_needs_page' ) ) {
			return;
		}

		if ( -1 == lastudio_events_get_page_id() && ! isset( $_GET['lastudio_events_create_page'] ) ) {

			if ( isset( $_GET['skip_lastudio_events_setup'] ) ) {
				delete_option( '_lastudio_events_needs_page' );
				return;
			}

			update_option( '_lastudio_events_needs_page', true );

			$message = '<strong>LaStudio Events</strong> ' . sprintf(
					wp_kses(
						__( 'says : <em>Almost done! you need to <a href="%1$s">create a page</a> for your galleries or <a href="%2$s">select an existing page</a> in the plugin settings</em>.', 'lastudio-events' ),
						array(
							'a' => array(
								'href' => array(),
								'class' => array(),
								'title' => array(),
							),
							'br' => array(),
							'em' => array(),
							'strong' => array(),
						)
					),
					esc_url( admin_url( '?lastudio_events_create_page=true' ) ),
					esc_url( admin_url( 'edit.php?post_type=event&page=lastudio-events-settings' ) )
			);

			$message .= sprintf(
				wp_kses(
					__( '<br><br>
					<a href="%1$s" class="button button-primary">Create a page</a>
					&nbsp;
					<a href="%2$s" class="button button-primary">Select an existing page</a>
					&nbsp;
					<a href="%3$s" class="button">Skip setup</a>', 'lastudio-events' ),

					array(
							'a' => array(
								'href' => array(),
								'class' => array(),
								'title' => array(),
							),
							'br' => array(),
							'em' => array(),
							'strong' => array(),
						)
				),
					esc_url( admin_url( '?lastudio_events_create_page=true' ) ),
					esc_url( admin_url( 'edit.php?post_type=event&page=lastudio-events-settings' ) ),
					esc_url( admin_url( '?skip_lastudio_events_setup=true' ) )
			);

			$output = '<div class="updated"><p>';

				$output .= $message;

			$output .= '</p></div>';

			echo $output;
		} else {

			delete_option( '_lastudio_events_need_page' );
		}

		return false;
	}

	/**
	 * Create events page
	 */
	public function create_page() {

		if ( isset( $_GET['lastudio_events_create_page'] ) && $_GET['lastudio_events_create_page'] == 'true' ) {

			$output = '';

			// Create post object
			$post = array(
				'post_title'  => esc_html__( 'Events', 'lastudio-events' ),
				'post_type'   => 'page',
				'post_status' => 'publish',
			);

			// Insert the post into the database
			$post_id = wp_insert_post( $post );

			if ( $post_id ) {

				update_option( '_lastudio_events_page_id', $post_id );
				update_post_meta( $post_id, '_wpb_status', 'off' ); // disable page builder mode for this page

				$message = esc_html__( 'Your events page has been created succesfully', 'lastudio-events' );

				$output = '<div class="updated"><p>';

				$output .= $message;

				$output .= '</p></div>';

				echo $output;
			}
		}

		return false;
	}

	/**
	 * Display notice on album index page
	 */
	public function is_events_index_page() {

		if ( isset( $_GET['post'] ) && absint( $_GET['post'] ) == lastudio_events_get_page_id() ) {
			$message = esc_html__( 'You are currently editing the page that shows the events.', 'lastudio-events' );

			$output = '<div class="notice notice-warning inline"><p>';

			$output .= $message;

			$output .= '</p></div>';

			echo $output;
		}
	}

	/**
	 * Hide the editor if we're on the admin events page
	 */
	public function hide_editor() {
		if ( isset( $_GET['post'] ) && absint( $_GET['post'] ) == lastudio_events_get_page_id() ) {
			remove_post_type_support( 'page', 'editor' );
		}
	}

	/**
	 * Hide the editor if we're on the admin events page
	 */
	public function hide_wpb_editor() {
		if ( isset( $_GET['post'] ) && absint( $_GET['post'] ) == lastudio_events_get_page_id() ) {
			?>
			<style type="text/css">
			.wpb-toggle-editor,
			#wpb-import-export-buttons,
			#wpb_content{
				display:none!important;
			}
			</style>
			<?php
		}
	}

	/**
	 * Add show column head in admin posts list
	 *
	 * @param array $columns
	 * @return array $columns
	 */
	public function admin_columns_head_events( $columns ) {

		unset( $columns['date'] );
		$columns['event_date']   = esc_html__( 'Event Date', 'lastudio-events' );
		$columns['event_place']  = esc_html__( 'Place', 'lastudio-events' );
		$columns['event_venue']  = esc_html__( 'Venue', 'lastudio-events' );
		$columns['event_status'] = esc_html__( 'Status', 'lastudio-events' );
		return $columns;
	}

	/**
	 * Add show column in admin posts list
	 *
	 * @param string $column_name
	 * @param int $post_id
	 */
	public function admin_columns_content_events( $column_name, $post_id ) {

		$start_date = get_post_meta( $post_id, '_lastudio_event_start_date', true );
		$end_date = get_post_meta( $post_id, '_lastudio_event_end_date', true );
		$date_format = get_option( 'date_format' );
		$cancelled = get_post_meta( $post_id, '_lastudio_event_cancel', true );
		$soldout = get_post_meta( $post_id, '_lastudio_event_soldout', true );
		$status = esc_html__( 'upcoming', 'lastudio-events' );

		$date = ( $end_date ) ? $end_date : $start_date;

		if ( le_is_past_show( $date ) ) {

			$status = esc_html__( 'past', 'lastudio-events' );

		} elseif ( $cancelled ) {

			$status = esc_html__( 'cancelled', 'lastudio-events' );

		} elseif ( $soldout ) {

			$status = esc_html__( 'sold out', 'lastudio-events' );
		}

		$city = get_post_meta( $post_id, '_lastudio_event_city', true );
		$country = get_post_meta( $post_id, '_lastudio_event_country_short', true );
		$state = get_post_meta( $post_id, '_lastudio_event_state', true );
		$venue = get_post_meta( $post_id, '_lastudio_event_venue', true );
		$place = $city;

		if ( $country && ! $state ) {
			$place = $city . ', ' . $country;
		}

		if ( ! $country && $state ) {
			$place = $city . ', ' . $state;
		}

		if ( $country && $state ) {
			$place = $city . ', ' . $state . ' (' . $country . ')';
		}

		if ( $column_name == 'event_date' ) {

			if ( $start_date ) {
				echo le_nice_date( $start_date );
			}

			if ( $end_date ) {
				echo ' &mdash; ' . le_nice_date( $end_date );
			}

		}

		if ( $column_name == 'event_place' ) {

			if ( $place ) echo sanitize_text_field( $place );

		}

		if ( $column_name == 'event_venue' ) {

			if ( $venue ) echo sanitize_text_field( $venue );

		}

		if ( $column_name == 'event_status' ) {

			if ( $status ) echo sanitize_text_field( $status );
		}
	}

	/**
	 * Add settings link in plugin page
	 */
	public function settings_action_links( $links ) {
		$setting_link = array(
			'<a href="' . admin_url( 'edit.php?post_type=event&page=lastudio-events-settings' ) . '">' . esc_html__( 'Settings', 'lastudio-events' ) . '</a>',
		);
		return array_merge( $links, $setting_link );
	}

	/**
	 * Plugin update
	 */
	public function plugin_update() {

		$plugin_slug = LE_SLUG;
		$plugin_path = LE_PATH;
		$remote_path = LE_UPDATE_URL . '/' . $plugin_slug;
		$plugin_data = get_plugin_data( LE_DIR . '/' . LE_SLUG . '.php' );
		$current_version = $plugin_data['Version'];
		include_once( 'class-le-update.php');
		new LE_Update( $current_version, $remote_path, $plugin_path );
	}
} // end class

return new LE_Admin();