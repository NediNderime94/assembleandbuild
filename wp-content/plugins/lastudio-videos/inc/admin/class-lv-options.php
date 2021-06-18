<?php
/**
 * LaStudio Videos Options.
 *
 * @class LV_Options
 * @author LaStudio
 * @category Admin
 * @package LaStudioVideos/Admin
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * LV_Options class.
 */
class LV_Options {
	/**
	 * Constructor
	 */
	public function __construct() {
		// register settings
		add_action( 'admin_init', array( $this, 'register_settings' ) );

		// set default options
		add_action( 'admin_init', array( $this, 'default_options' ) );

		// add option sub-menu
		add_action( 'admin_menu', array( $this, 'add_settings_menu' ) );
	}

	/**
	 * Add options menu
	 */
	public function add_settings_menu() {

		add_submenu_page( 'edit.php?post_type=la_video', esc_html__( 'Settings', 'lastudio-videos' ), esc_html__( 'Settings', 'lastudio-videos' ), 'edit_plugins', 'lastudio-videos-settings', array( $this, 'options_form' ) );
		//add_submenu_page( 'edit.php?post_type=la_video', esc_html__( 'Shortcode', 'lastudio-videos' ), esc_html__( 'Shortcode', 'lastudio-videos' ), 'edit_plugins', 'lastudio-videos-shortcode', array( $this, 'help' ) );
	}

	/**
	 * Set default options
	 */
	public function default_options() {

		global $options;

		if ( false ===  get_option( 'lastudio_videos_settings' )  ) {

			$default = array(
				'isotope' => 1,
				'col' => 4,
			);

			add_option( 'lastudio_videos_settings', $default );
		}
	}

	/**
	 * Register options
	 */
	public function register_settings() {

		register_setting( 'lastudio-videos-settings', 'lastudio_videos_settings', array( $this, 'settings_validate' ) );
		add_settings_section( 'lastudio-videos-settings', '', array( $this, 'section_intro' ), 'lastudio-videos-settings' );
		add_settings_field( 'page_id', esc_html__( 'Videos page', 'lastudio-videos' ), array( $this, 'setting_page_id' ), 'lastudio-videos-settings', 'lastudio-videos-settings' );
//		add_settings_field( 'columns', esc_html__( 'Max number of column', 'lastudio-videos' ), array( $this, 'setting_columns' ), 'lastudio-videos-settings', 'lastudio-videos-settings', array( 'class' => 'lastudio-videos-settings-columns' ) );
//		add_settings_field( 'isotope', esc_html__( 'Use Isotope filter', 'lastudio-videos' ), array( $this, 'setting_isotope' ), 'lastudio-videos-settings', 'lastudio-videos-settings', array( 'class' => 'lastudio-videos-settings-columns' ) );
	}

	/**
	 * Validate options
	 *
	 * @param array $input
	 * @return array $input
	 */
	public function settings_validate( $input ) {

		if ( isset( $input['page_id'] ) ) {
			update_option( '_lastudio_videos_page_id', intval( $input['page_id'] ) );
			unset( $input['page_id'] );
		}

		$input['columns']= absint( $input['col'] );
		$input['isotope'] = boolval( $input['isotope'] );

		return $input;
	}

	/**
	 * Debug section
	 *
	 */
	public function section_intro() {
		// debug
		// var_dump(get_option('_lastudio_videos_page_id'));
	}

	/**
	 * Page settings
	 *
	 */
	public function setting_page_id() {
		$pages = get_pages();
		?>
		<select name="lastudio_videos_settings[page_id]">
			<option value="-1"><?php esc_html_e( 'Select a page...', 'lastudio-videos' ); ?></option>
			<?php foreach ( $pages as $page ) : ?>
				<option value="<?php echo absint( $page->ID ); ?>" <?php selected( absint( $page->ID ), get_option( '_lastudio_videos_page_id' ) ); ?>><?php echo sanitize_text_field( $page->post_title ); ?></option>
			<?php endforeach; ?>
		</select>
		<?php
	}

	/**
	 * Use custom style
	 */
	public function setting_columns() {
		$columns = array( 1, 2, 3, 4, 5, 6 );
		?>
		<select name="lastudio_videos_settings[col]">
			<?php foreach ( $columns as $column ) : ?>
			<option <?php selected( $column, lastudio_videos_get_option( 'col', 4 ) ); ?>><?php echo absint( $column ); ?></option>
			<?php endforeach; ?>
		</select>
		<?php esc_html_e( 'Number of column on desktop screen', 'lastudio-videos' ); ?>
		<?php
	}

	/**
	 * Use isotope filter
	 */
	public function setting_isotope() {
		?>
		<input type="hidden" name="lastudio_videos_settings[isotope]" value="0">
		<label><input type="checkbox" name="lastudio_videos_settings[isotope]" value="1" <?php echo ( ( lastudio_videos_get_option( 'isotope' ) == 1) ? ' checked="checked"' : '' ); ?>>
		</label>
		<?php
	}

	/**
	 * Displays Shortcode help
	 */
	public function help() {
		?>
		<div class="wrap">
			<h2><?php esc_html_e( 'Videos shortcode', 'lastudio-videos' ) ?></h2>
			<p><?php esc_html_e( 'To display your last videos in your post or page you can use the following shortcode.', 'lastudio-videos' ); ?></p>
			<p><code>[lastudio_last_videos]</code></p>
			<p><?php esc_html_e( 'Additionally, you can add a count, columns, tag and category attributes.', 'lastudio-videos' ); ?></p>
			<p><code>[lastudio_last_videos col="2|3|4" count="4" category="my-category" tag="my-tag"]</code></p>
		</div>
		<?php
	}

	/**
	 * Options form
	 *
	 */
	public function options_form() {
		?>
		<div class="wrap">
			<div id="icon-options-general" class="icon32"></div>
			<h2><?php esc_html_e( 'Videos options', 'lastudio-videos' ); ?></h2>
			<?php if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] ) { ?>
			<div id="setting-error-settings_updated" class="updated settings-error">
				<p><strong><?php esc_html_e( 'Settings saved.', 'lastudio-videos' ); ?></strong></p>
			</div>
			<?php } ?>
			<form action="options.php" method="post">
				<?php settings_fields( 'lastudio-videos-settings' ); ?>
				<?php do_settings_sections( 'lastudio-videos-settings' ); ?>
				<p class="submit"><input name="save" type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'lastudio-videos' ); ?>" /></p>
			</form>
		</div>
		<?php
	}
}

return new LV_Options();