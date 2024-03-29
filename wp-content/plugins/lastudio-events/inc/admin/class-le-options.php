<?php
/**
 * LaStudio Events Options.
 *
 * @class LE_Options
 * @author LaStudio
 * @category Admin
 * @package LaStudioEvents/Admin
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * LE_Options class.
 */
class LE_Options {
	/**
	 * Constructor
	 */
	public function __construct() {

		// Admin init hooks
		$this->admin_init_hooks();
	}

	/**
	 * Admin init
	 */
	public function admin_init_hooks() {

		// Set default options
		add_action( 'admin_init', array( $this, 'default_options' ) );

		// Register settings
		add_action( 'admin_init', array( $this, 'register_settings' ) );

		// Add option sub-menu
		add_action( 'admin_menu', array( $this, 'add_options_menu' ) );
	}

	/**
	 * Add options menu
	 */
	public function add_options_menu() {

		$post_type_name = 'event';
		add_submenu_page( 'edit.php?post_type=' . $post_type_name, esc_html__( 'Settings', 'lastudio-events' ), esc_html__( 'Settings', 'lastudio-events' ), 'edit_plugins', 'lastudio-events-settings', array( $this, 'options_form' ) );
	}

	/**
	 * Register options
	 */
	public function register_settings() {
		register_setting( 'lastudio-events-settings', 'lastudio_events_settings', array( $this, 'settings_validate' ) );
		add_settings_section( 'lastudio-events-settings', '', array( $this, 'section_intro' ), 'lastudio-events-settings' );
		add_settings_field( 'page_id', esc_html__( 'Events Page', 'lastudio-events' ), array( $this, 'setting_page_id' ), 'lastudio-events-settings', 'lastudio-events-settings' );
		add_settings_field( 'past_events', esc_html__( 'Display past events in list', 'lastudio-events' ), array( $this, 'setting_past_events' ), 'lastudio-events-settings', 'lastudio-events-settings', array( 'class' => 'setting_past_events' ) );
		add_settings_field( 'single_page', esc_html__( 'Link to single page in list', 'lastudio-events' ), array( $this, 'setting_event_single_page' ), 'lastudio-events-settings', 'lastudio-events-settings', array( 'class' => 'setting_event_single_page' ) );
		add_settings_field( 'ticket_text', esc_html__( 'Ticket text', 'lastudio-events' ), array( $this, 'setting_ticket_text' ), 'lastudio-events-settings', 'lastudio-events-settings' );
		add_settings_field( 'upcoming_events_text', esc_html__( 'Upcoming events text', 'lastudio-events' ), array( $this, 'setting_upcoming_events_text' ), 'lastudio-events-settings', 'lastudio-events-settings',  array( 'class' => 'setting_upcoming_events_text' ) );
		add_settings_field( 'past_events_text', esc_html__( 'Past events text', 'lastudio-events' ), array( $this, 'setting_past_events_text' ), 'lastudio-events-settings', 'lastudio-events-settings', array( 'class' => 'setting_past_events_text' ) );
		add_settings_field( 'no_event_text', esc_html__( 'No event text', 'lastudio-events' ), array( $this, 'setting_no_event_text' ), 'lastudio-events-settings', 'lastudio-events-settings' );
		add_settings_field( 'instructions', esc_html__( 'Instructions', 'lastudio-events' ), array( $this, 'setting_event_instructions' ), 'lastudio-events-settings', 'lastudio-events-settings', array( 'class' => 'setting_event_instructions' ) );
	}

	/**
	 * Validate options
	 *
	 * @param array $input
	 * @return array $input
	 */
	public function settings_validate( $input ) {

		if ( isset( $input['page_id'] ) ) {
			update_option( '_lastudio_events_page_id', intval( $input['page_id'] ) );
			unset( $input['page_id'] );
		}

		$input['past_events']  = boolval( $input['past_events'] );
		$input['single_page'] = boolval( $input['single_page'] );
		return $input;
	}

	/**
	 * Debug section
	 */
	public function section_intro() {
		// debug
		//global $options;
		// var_dump(get_option( '_lastudio_events_page_id' ));
	}

	/**
	 * Page settings
	 *
	 * @return string
	 */
	public function setting_page_id() {
		$page_option = array( '' => esc_html__( '- Disabled -', 'lastudio-events' ) );
		$pages = get_pages();

		foreach ( $pages as $page ) {

			if ( get_post_field( 'post_parent', $page->ID ) ) {
				$page_option[ absint( $page->ID ) ] = '&nbsp;&nbsp;&nbsp; ' . sanitize_text_field( $page->post_title );
			} else {
				$page_option[ absint( $page->ID ) ] = sanitize_text_field( $page->post_title );
			}
		}
		?>
		<select name="lastudio_events_settings[page_id]">
			<option value="-1"><?php esc_html_e( 'Select a page...', 'lastudio-events' ); ?></option>
			<?php foreach ( $page_option as $k => $v ) : ?>
				<option value="<?php echo absint( $k ); ?>" <?php selected( absint( $k ), get_option( '_lastudio_events_page_id' ) ); ?>><?php echo sanitize_text_field( $v ); ?></option>
			<?php endforeach; ?>
		</select>
		<?php
	}

	/**
	 * Display past events settings
	 */
	public function setting_past_events() {
		?>
		<input type="hidden" name="lastudio_events_settings[past_events]" value="0">
		<label for="lastudio_events_settings[past_events]"><input type="checkbox" name="lastudio_events_settings[past_events]" value="1" <?php echo intval( le_get_option( 'past_events' ) ) == 1 ? ' checked="checked"' : ''; ?>>
		</label>
		<?php
	}

	/**
	 * Link events in list to sinlge page option
	 */
	public function setting_event_single_page() {
		?>
		<input type="hidden" name="lastudio_events_settings[single_page]" value="0">
		<label for="lastudio_events_settings[single_page]"><input type="checkbox" name="lastudio_events_settings[single_page]" value="1" <?php echo intval( le_get_option( 'single_page' ) ) == 1 ? ' checked="checked"' : ''; ?>>
		</label>
		<?php
	}

	/**
	 * Ticket text
	 */
	public function setting_ticket_text() {
		?>
		<input type="text" value="<?php echo le_get_option( 'ticket_text', esc_html__( 'Tickets', 'lastudio-events' ) ); ?>" name="lastudio_events_settings[ticket_text]">
		<?php
	}

	/**
	 * Upcoming events text
	 */
	public function setting_upcoming_events_text() {
		?>
		<input type="text" value="<?php echo le_get_option( 'upcoming_events_text', esc_html__( 'Upcoming events', 'lastudio-events' ) ); ?>" name="lastudio_events_settings[upcoming_events_text]">
		<?php
	}

	/**
	 * Past event text
	 */
	public function setting_past_events_text() {
		?>
		<input type="text" value="<?php echo le_get_option( 'past_events_text', esc_html__( 'Past events', 'lastudio-events' ) ); ?>" name="lastudio_events_settings[past_events_text]">
		<?php
	}

	/**
	 * Past event Text
	 */
	public function setting_no_event_text() {
		?>
		<input type="text" value="<?php echo le_get_option( 'no_event_text', esc_html__( 'No upcoming event scheduled', 'lastudio-events' ) ); ?>" name="lastudio_events_settings[no_event_text]">
		<?php
	}

	/**
	 * Display additional instructions
	 */
	public function setting_event_instructions() {
		?>
		<p><?php esc_html_e( 'To display your event list, paste the following shortcode in a post or page :', 'lastudio-events' ); ?></p>
		<p><code>[lastudio_event_list]</code></p>
		<p><?php esc_html_e( 'Additionally, you can add some attributes.', 'lastudio-events' ); ?></p>
		<p><code>[lastudio_event_list count="10" past="true|false" link="true|false"]</code></p>
		<p><?php esc_html_e( 'The "past" attribute: display the past events or not in the list', 'lastudio-events' ); ?></p>
		<p><?php esc_html_e( 'The "link" attribute: link your events to the single page or not.', 'lastudio-events' ); ?></p>
		<?php
	}

	/**
	 * Options form
	 */
	public function options_form() {
		?>
		<div class="wrap">
			<h2><?php esc_html_e( 'Events Options', 'lastudio-events' ); ?></h2>
			<?php if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] ) { ?>
			<div id="setting-error-settings_updated" class="updated settings-error">
				<p><strong><?php esc_html_e( 'Settings saved.', 'lastudio-events' ); ?></strong></p>
			</div>
			<?php } ?>
			<form action="options.php" method="post">
				<?php settings_fields( 'lastudio-events-settings' ); ?>
				<?php do_settings_sections( 'lastudio-events-settings' ); ?>
				<p class="submit"><input name="save" type="submit" class="button-primary" value="<?php esc_html_e( 'Save Changes', 'lastudio-events' ); ?>" /></p>
			</form>
		</div>
		<?php
	}

	/**
	 * Set default options
	 */
	public function default_options() {

		// delete_option( 'lastudio_events_settings' );

		if ( false === get_option( 'lastudio_events_settings' )  ) {

			$default = array(
				'ticket_text' => esc_html__( 'Tickets', 'lastudio-events' ),
				'upcoming_events_text' => esc_html__( 'Upcoming events', 'lastudio-events' ),
				'past_events_text' => esc_html__( 'Past events', 'lastudio-events' ),
				'no_event_text' => esc_html__( 'No upcoming event scheduled', 'lastudio-events' ),
				'past_events' => true,
				'single_page' => true,
			);

			add_option( 'lastudio_events_settings', $default );
		}
	}
} // end class

return new LE_Options();