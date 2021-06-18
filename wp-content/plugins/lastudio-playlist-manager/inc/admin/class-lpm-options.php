<?php
/**
 * LaStudio Playlist Options.
 *
 * @class LPM_Options
 * @author LaStudio
 * @category Admin
 * @package LaStudioPlaylistManager/Admin
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * LPM_Options class.
 */
class LPM_Options {
	/**
	 * Constructor
	 */
	public function __construct() {
		
		// default options
		add_action( 'admin_init', array( $this, 'default_options' ) );

		// register settings
		add_action( 'admin_init', array( $this, 'register_settings' ) );

		// add option sub-menu
		add_action( 'admin_menu', array( $this, 'add_settings_menu' ) );
	}

	/**
	 * Add options menu
	 */
	public function add_settings_menu() {

		add_submenu_page( 'edit.php?post_type=lpm_playlist', esc_html__( 'Settings', 'lastudio-playlist-manager' ), esc_html__( 'Settings', 'lastudio-playlist-manager' ), 'edit_plugins', 'lastudio-playlist-manager-settings', array( $this, 'options_form' ) );
	}

	/**
	 * Set default options
	 */
	public function default_options() {

		global $options;

		if ( false === get_option( 'lastudio_playlist_manager_settings' ) ) {

			$default = array(
				'theme' => 'dark',
			);

			add_option( 'lastudio_playlist_manager_settings', $default );
		}
	}

	/**
	 * Init Settings
	 */
	public function register_settings() {

		register_setting( 'lastudio-playlist-manager-settings', 'lastudio_playlist_manager_settings', array( $this, 'settings_validate' ) );
		
		add_settings_section( 'lastudio-playlist-manager-settings', '', array( $this, 'section_intro' ), 'lastudio-playlist-manager-settings' );
		
		add_settings_field( 'streaming_url', esc_html__( 'Streaming URL', 'lastudio-playlist-manager' ), array( $this, 'setting_streaming_url' ), 'lastudio-playlist-manager-settings', 'lastudio-playlist-manager-settings' );
		add_settings_field( 'streaming_name', esc_html__( 'Streaming Name', 'lastudio-playlist-manager' ), array( $this, 'setting_streaming_name' ), 'lastudio-playlist-manager-settings', 'lastudio-playlist-manager-settings' );
		add_settings_field( 'streaming_description', esc_html__( 'Streaming Description', 'lastudio-playlist-manager' ), array( $this, 'setting_streaming_description' ), 'lastudio-playlist-manager-settings', 'lastudio-playlist-manager-settings' );
	}

	/**
	 * Validate settings
	 */
	public function settings_validate( $input ) {

		if ( isset( $input['streaming_url'] ) ) {
			
			$input['streaming_url'] = esc_url_raw( $input['streaming_url'] );
			delete_option( '_lpm_bar' );
		
		} else {
			
			$input['streaming_url'] = '';
		}

		$input['streaming_name'] = esc_attr( $input['streaming_name'] );
		$input['streaming_description'] = esc_attr( $input['streaming_description'] );

		return $input;
	}

	/**
	 * Intro section
	 *
	 * @return string
	 */
	public function section_intro() {

		// add instructions
		//var_dump( get_option( 'lastudio_playlist_manager_settings' ) );
		//var_dump( lpm_get_option( 'streaming_url' ) );
	}

	/**
	 * Streaming URL
	 *
	 * @return string
	 */
	public function setting_streaming_url() {
		?>
		<input type="text" placeholder="<?php esc_html_e( 'http://streamingexample.com:8010/stream.mp3', 'lastudio-playlist-manager' ); ?>" class="regular-text" name="lastudio_playlist_manager_settings[streaming_url]"
			value="<?php echo esc_attr( lpm_get_option( 'streaming_url' ) ); ?>"
		>
		<p>
			<em>
			<?php
				/*
				 *  Instructions
				 */
				echo wp_kses_post(
					sprintf(
						__( 'Enter your mp3 streaming URL here and a player will be displayed at the bottom of your pages. It will overwrite the current playlist set as "sticky player".<br>Your theme must support this feature. <a href="%s">Get a theme with sticky player support</a>.', 'lastudio-playlist-manager' ),
						esc_url( '#' )
					)
				);
			?>
			</em>
		</p>
		<?php
	}

	/**
	 * Streaming name
	 *
	 * @return string
	 */
	public function setting_streaming_name() {
		?>
		<input type="text" placeholder="<?php esc_html_e( 'My Radio', 'lastudio-playlist-manager' ); ?>" class="regular-text" name="lastudio_playlist_manager_settings[streaming_name]"
			value="<?php echo esc_attr( lpm_get_option( 'streaming_name' ) ); ?>"
		>
		<?php
	}

	/**
	 * Streaming description
	 *
	 * @return string
	 */
	public function setting_streaming_description() {
		?>
		<input type="text" placeholder="<?php esc_html_e( 'The Best Radio in the World', 'lastudio-playlist-manager' ); ?>" class="regular-text" name="lastudio_playlist_manager_settings[streaming_description]"
			value="<?php echo esc_attr( lpm_get_option( 'streaming_description' ) ); ?>"
		>
		<?php
	}

	/**
	 * Display options form
	 *
	 */
	public function options_form() {
		?>
		<div class="wrap">
			<h2><?php esc_html_e( 'Playlist Settings' ) ?></h2>
			<?php if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] ) { ?>
			<div id="setting-error-settings_updated" class="updated settings-error">
				<p><strong><?php esc_html_e( 'Settings saved.', 'lastudio-playlist-manager' ); ?></strong></p>
			</div>
			<?php } ?>
			<form action="options.php" method="post">
				<?php settings_fields( 'lastudio-playlist-manager-settings' ); ?>
				<?php do_settings_sections( 'lastudio-playlist-manager-settings' ); ?>
				<p class="submit"><input name="save" type="submit" class="button-primary" value="<?php esc_html_e( 'Save Changes', 'lastudio-playlist-manager' ); ?>" /></p>
			</form>
		</div>
		<?php
	}
}

return new LPM_Options();