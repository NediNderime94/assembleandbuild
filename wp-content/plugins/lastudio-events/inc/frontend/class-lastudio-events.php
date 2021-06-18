<?php
/**
 * LaStudio Events Frontend class.
 *
 * @class LE_Admin
 * @author LaStudio
 * @category Frontend
 * @package LaStudioEvents/Frontend
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * LE_Admin class.
 */
class LE_Frontend {

	/**
	 * @var object
	 */
	private $wpdb;

	/**
	 * LE_Frontend constructor
	 */
	public function __construct() {
		global $wpdb;
		$this->wpdb = &$wpdb;
	}

	/**
	 * Loop function
	 *
	 * Display the event posts
	 *
	 * @param array $args
	 */
	public function events( $args = array() ) {
		$this->event_list($args);
	}

	/**
	 * Loop function
	 *
	 * Display the events list
	 *
	 * @param array $args
	 */
	public function event_list( $args = array() ) {

		$args = wp_parse_args( $args, array(
			'count' => -1,
			//'past' => le_get_option( 'past_shows' ),
			'timeline' => 'future', // future or past
			'link' => le_get_option( 'single_page' ),
			'artist' => false,
			'widget' => false,
			'el_class'	=> ''
		) );

		$args = $this->sanitize_args( $args );

		$count = $args['count'];
		$timeline = $args['timeline'];
		$link = $args['link'];
		$artist = $args['artist'];
		$widget = $args['widget'];

		echo '<div class="lastudio-events">';

		if ( 'past' === $timeline ) {
			$events = $this->past_events_query( $count, $artist );
		} else {
			$events = $this->future_events_query( $count, $artist );
		}

		if ( $events->have_posts() ) {

			$container_class = 'lastudio-events-table lastudio-upcoming-events-table';
			if(!empty($args['el_class'])){
				$container_class .= ' '. $args['el_class'];
			}

			if ( 'past' === $timeline ) {
				$container_class .= ' lastudio-past-events-table';
			} else {
				$container_class .= ' lastudio-upcoming-events-table';
			}

			if ( $widget ) {
				$container_class .= ' lastudio-events-widget-table';
			}

			echo '<div class="' . esc_attr( $container_class ) . '">';

			while ( $events->have_posts() ) : $events->the_post();

				$meta = $this->get_event_meta( get_the_ID() );

				$meta['link'] = $link;
				$cancelled = $meta['cancelled'];

				if ( 'past' === $timeline ) {
					$meta['action'] = ''; // no buy ticket button
				}

				// don't display event in widget if cancelled
				if ( $widget && $cancelled ) {
					continue;
				}

				do_action( 'le_before_event_list', $args, $meta );

				le_get_template('event-list-item.php', $meta);

				do_action( 'le_after_event_list', $args, $meta );

			endwhile;

			echo '</div><!-- .lastudio-upcoming-events -->';

		} else { // no events
			?><p><?php echo le_get_option( 'no_shows_text', esc_html__( 'No upcoming shows scheduled', 'lastudio-events' ) ); ?></p><?php
		}
		wp_reset_postdata();

		echo '</div><!-- .lastudio-events -->';
	}

	/**
	 * Get all meta values from meta data and returns a nice formatted array
	 *
	 * @param int $post_id
	 * @return array $meta
	 */
	public function get_event_meta( $post_id ) {

		$meta = $this->set_default_event_meta();

		$meta['name'] = get_the_title();
		$meta['permalink'] = get_permalink();
		$meta['description'] = le_sample( get_the_content() );
		$meta['thumbnail_url'] = ( has_post_thumbnail() ) ? le_get_post_thumbnail_url( 'large' ) : '';

		// set class array
		$classes = array( 'le-list-event', 'le-table-row' );

		$meta['facebook_url'] = get_post_meta( $post_id, '_lastudio_event_fb', true );

		// time
		$time = get_post_meta( $post_id, '_lastudio_event_time', true );
		$meta['time'] = ( $this->format_time( $time ) ) ? $time : '00:00';

		// start date
		$start_date = get_post_meta( $post_id, '_lastudio_event_start_date', true );
		$meta['start_date'] = ( $start_date ) ? $start_date : '2020-01-01';
		$meta['raw_start_date'] = $start_date . 'T' . $this->format_time( $time );
		$meta['formatted_start_date'] = $this->format_date( $start_date, $this->format_time( $time ) );

		// end date
		$end_date = get_post_meta( $post_id, '_lastudio_event_end_date', true );
		$meta['end_date'] = ( $end_date ) ? $end_date : '';
		$meta['raw_end_date'] = ( $end_date ) ? $end_date . 'T' . $this->format_time( $time ) : '';
		$meta['formatted_end_date'] = ( $end_date ) ? $this->format_date( $end_date, $this->format_time( $time ) ) : '';

		// place
		$meta['display_location'] = get_post_meta( $post_id, '_lastudio_event_location', true );
		$meta['venue'] = get_post_meta( $post_id, '_lastudio_event_venue', true );
		$meta['city'] = get_post_meta( $post_id, '_lastudio_event_city', true );
		$meta['address'] = get_post_meta( $post_id, '_lastudio_event_address', true );
		$meta['zipcode'] = get_post_meta( $post_id, '_lastudio_event_zip', true );
		$meta['phone'] = get_post_meta( $post_id, '_lastudio_event_phone', true );
		$meta['email'] = get_post_meta( $post_id, '_lastudio_event_email', true );
		$meta['website'] = get_post_meta( $post_id, '_lastudio_event_website', true );
		$meta['country'] = get_post_meta( $post_id, '_lastudio_event_country_short', true );
		$meta['state'] = get_post_meta( $post_id, '_lastudio_event_state', true );

		$artist = get_the_term_list( get_the_ID(), 'le_artist', '', ', ', '' );
		$meta['artist'] = ( $artist ) ? $artist : '';

		// action
		$action = '';
		$ticket_url = get_post_meta( $post_id, '_lastudio_event_ticket', true );
		$cancelled = get_post_meta( $post_id, '_lastudio_event_cancel', true );
		$soldout = get_post_meta( $post_id, '_lastudio_event_soldout', true );
		$free = get_post_meta( $post_id, '_lastudio_event_free', true );
		$meta['ticket_url'] = get_post_meta( $post_id, '_lastudio_event_ticket', true );
		$meta['cancelled'] = get_post_meta( $post_id, '_lastudio_event_cancel', true );
		$meta['soldout'] = get_post_meta( $post_id, '_lastudio_event_soldout', true );
		$meta['free'] = get_post_meta( $post_id, '_lastudio_event_free', true );
		$meta['map'] = get_post_meta( $post_id, '_lastudio_event_map', true );

		// Buy ticket links
		if ( ! $cancelled && ! $soldout && ! $free && $ticket_url ) {
			$action_text = apply_filters( 'le_ticket_link_text', le_get_option( 'ticket_text', esc_html__( 'Buy Ticket', 'lastudio-events' ) ) );
			$ticket_url_class = apply_filters( 'le_ticket_link_class', 'le-ticket-link' );
			$action = '<a class="' . esc_attr( $ticket_url_class ) . '" href="' . esc_url( $ticket_url ) . '">' . sanitize_text_field( $action_text ) . '</a>';
		}

		if ( $free && ! $cancelled && ! $soldout ) {
			$action_text = apply_filters( 'le_free_text', esc_html__( 'Free', 'lastudio-events' ) );
			$action  = '<span class="le-label le-label-free">' . sanitize_text_field( $action_text ) . '</span>';
		}

		if ( $cancelled ) {
			$link = false;
			$classes[] = 'le-cancelled';
			$action_text = apply_filters( 'le_cancelled_text', esc_html__( 'Cancelled', 'lastudio-events' ) );
			$action  = '<span class="le-label le-label-cancelled">' . sanitize_text_field( $action_text ) . '</span>';
		}

		if ( $soldout ) {
			$classes[] = 'le-soldout';
			$action_text = apply_filters( 'le_soldout_text', esc_html__( 'Sold out', 'lastudio-events' ) );
			$action  = '<span class="le-label le-label-soldout">' . sanitize_text_field( $action_text ) . '</span>';
		}

		$meta['action'] = $action;

		$meta['classes'] = implode( ' ', array_filter( $classes ) );

		return $this->sanitize_meta_values( $meta );
	}

	/**
	 * Format time (AM PM to 24hrs format if needed)
	 */
	public function format_time( $time ) {
		
		if ( ! $time ) {
			return;
		}

		$time = trim( strtoupper( preg_replace( '/\s+/', '', $time ) ) );
		$time = preg_replace( '/[^AM|PM0-9:]+/', '', $time );

		if ( preg_match( '[AM|PM]', $time ) ) {
			
			return date( 'H:i', strtotime( $time ) );
		
		} elseif ( $time ) {
			return $time;
		}
	}

	/**
	 * Sanitize all meta values
	 *
	 * @param array $meta
	 * @return array $meta
	 */
	public function sanitize_meta_values( $meta = array() ) {

		$meta['name'] = sanitize_text_field( $meta['name'] );
		$meta['permalink'] = esc_url( $meta['permalink'] );
		$meta['description'] = sanitize_text_field( $meta['description'] );
		$meta['thumbnail_url'] = esc_url( $meta['thumbnail_url'] );
		$meta['facebook_url'] = esc_url( $meta['facebook_url'] );
		$meta['classes'] = sanitize_text_field( $meta['classes'] );
		$meta['start_date'] = sanitize_text_field( $meta['start_date'] );
		$meta['end_date'] = sanitize_text_field( $meta['end_date'] );
		$meta['time'] = sanitize_text_field( $meta['time'] );
		$meta['raw_start_date'] = sanitize_text_field( $meta['raw_start_date'] );
		$meta['formatted_start_date'] = le_sanitize_date( $meta['formatted_start_date'] );
		$meta['raw_end_date'] = sanitize_text_field( $meta['raw_end_date'] );
		$meta['formatted_end_date'] = le_sanitize_date( $meta['formatted_end_date'] );
		$meta['display_location'] = sanitize_text_field( $meta['display_location'] );
		$meta['venue'] = sanitize_text_field( $meta['venue'] );
		$meta['city'] = sanitize_text_field( $meta['city'] );
		$meta['address'] = sanitize_text_field( $meta['address'] );
		$meta['zipcode'] = sanitize_text_field( $meta['zipcode'] );
		$meta['phone'] = sanitize_text_field( $meta['phone'] );
		$meta['email'] = sanitize_email( $meta['email'] );
		$meta['website'] = esc_url( $meta['website'] );
		$meta['country'] = sanitize_text_field( $meta['country'] );
		$meta['artist'] = wp_kses_post( $meta['artist'] );
		$meta['country_short'] = sanitize_text_field( $meta['country_short'] );
		$meta['state'] = sanitize_text_field( $meta['state'] );
		$meta['ticket_url'] = esc_url( $meta['ticket_url'] );
		$meta['cancelled'] = boolval( $meta['cancelled'] );
		$meta['soldout'] = boolval( $meta['soldout'] );
		$meta['free'] = boolval( $meta['free'] );
		$meta['action'] = le_sanitize_action( $meta['action'] );
		$meta['map'] = le_sanitize_iframe( $meta['map'] );

		return $meta;
	}

	/**
	 * Set a default meta array
	 *
	 * We will store all the data related to the post here
	 *
	 * @param array $meta
	 * @return array $meta
	 */
	public function set_default_event_meta() {
		return array(
			'classes' => '',
			'name' => '',
			'permalink' => '',
			'description' => '',
			'thumbnail_url' => '',
			'facebook_url' => '',
			'start_date' => '',
			'end_date' => '',
			'time' => '',
			'raw_start_date' => '',
			'raw_end_date' => '',
			'formatted_start_date' => '',
			'formatted_end_date' => '',
			'display_location' => '',
			'venue' => '',
			'city' => '',
			'address' => '',
			'zipcode' => '',
			'phone' => '',
			'email' => '',
			'artist' => '',
			'website' => '',
			'country' => '',
			'country_short' => '',
			'state' => '',
			'ticket_url' => '',
			'cancelled' => '',
			'soldout' => '',
			'free' => '',
			'action' => '',
			'map' => '',
		);
	}

	/**
	 * Returns show date
	 *
	 * @param string $date, bool $custom
	 * @return string
	 */
	public function format_date( $date = null, $time = '00:00' ) {

		if ( ! $date ) {
			return;
		}

		list( $day, $monthnbr, $year ) = explode( '-', $date );
		$search = array( '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12' );
		$replace = array(
			esc_html__('Jan', 'lastudio-events'),
			esc_html__('Feb', 'lastudio-events'),
			esc_html__('Mar', 'lastudio-events'),
			esc_html__('Apr', 'lastudio-events'),
			esc_html__('May', 'lastudio-events'),
			esc_html__('Jun', 'lastudio-events'),
			esc_html__('Jul', 'lastudio-events'),
			esc_html__('Aug', 'lastudio-events'),
			esc_html__('Sep', 'lastudio-events'),
			esc_html__('Oct', 'lastudio-events'),
			esc_html__('Nov', 'lastudio-events'),
			esc_html__('Dec', 'lastudio-events')
		);
		$month = str_replace( $search, $replace, $monthnbr );
		$display = '<span class="le-day">' . $day . '</span><span class="le-month">' . $month . '</span>';

		return apply_filters( 'le_formatted_date', $display, $date, $time );
	}

	/**
	 * Sanitize args and set default value from options if needed
	 *
	 * @param array $args
	 * @return array $args
	 */
	public function sanitize_args( $args ) {

		$args['count'] = intval( $args['count'] );
		$args['timeline'] = esc_attr( $args['timeline'] );
		$args['link'] = boolval( $args['link'] );
		$args['widget'] = boolval( $args['widget'] );
		$args['artist'] = esc_attr( $args['artist'] );
		$args['el_class'] = esc_attr( $args['el_class'] );

		return $args;
	}

	/**
	 * Custom SQL query for future events
	 *
	 * @param int $count
	 * @return object
	 */
	public function future_events_query( $count, $artist ) {

		add_filter( 'posts_orderby', 'le_order_by', 10, 1 );
		add_filter( 'posts_where', 'le_future_where', 10,  1 );

		$today = date( 'm-d-Y' );

		$args = array(
			'post_type' => 'event',
			'meta_key' => '_lastudio_event_start_date',
			'orderby' => 'meta_value',
			'order' => 'ASC',
			'posts_per_page' => $count,
		);

		if ( $artist ) {
			$args['le_artist'] = $artist;
		}

		$query = new WP_Query( $args );

		remove_filter( 'posts_orderby', 'le_order_by' );
		remove_filter( 'posts_where', 'le_future_where' );

		return $query;
	}

	/**
	 * Custom SQL query for past events
	 *
	 * @param int $count
	 * @return object
	 */
	public function past_events_query( $count, $artist ) {
		add_filter( 'posts_orderby', 'le_order_by', 10, 1 );
		add_filter( 'posts_where', 'le_past_where', 10,  1 );

		$today = date( 'm-d-Y' );

		$args  = array(
			'post_type' => 'event',
			'meta_key' => '_lastudio_event_start_date',
			'orderby' => 'meta_value',
			'order' => 'DESC',
			'posts_per_page' => $count,
		);

		if ( $artist ) {
			$args['le_artist'] = $artist;
		}

		$query = new WP_Query( $args );

		remove_filter( 'posts_orderby', 'le_order_by' );
		remove_filter( 'posts_where', 'le_past_where' );

		return $query;
	}
}