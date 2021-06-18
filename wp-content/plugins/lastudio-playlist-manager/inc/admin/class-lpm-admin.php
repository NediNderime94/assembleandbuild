<?php
/**
 * LaStudio Playlist Admin.
 *
 * @class LPM_Admin
 * @author LaStudio
 * @category Admin
 * @package LaStudioPlaylistManager/Admin
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * LPM_Admin class.
 */
class LPM_Admin {
	/**
	 * Constructor
	 */
	public function __construct() {

		// Plugin settings links
		add_filter( 'plugin_action_links_' . plugin_basename( LPM_PATH ), array( $this, 'settings_action_links' ) );

		// Includes necessary files
		add_action( 'init', array( $this, 'includes' ) );

		// Add admin body class
		add_filter( 'admin_body_class', array( $this, 'admin_body_class' ) );

		// Enqueue admin scripts & styles
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );

		// Add metabox
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );

		// Save post hook
		add_action( 'save_post', array( $this, 'save_post' ) );

		// Plugin update notifications
		add_action( 'admin_init', array( $this, 'plugin_update' ) );
	}

	/**
	 * admin scripts
	 */
	public function admin_scripts() {

		$version = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? time() : LPM_VERSION;

		// Styles
		wp_enqueue_style( 'lpm-admin', LPM_CSS . '/admin/lpm-admin.css', array(), $version );

		// Scripts
		wp_enqueue_script( 'wp-media' );
		wp_enqueue_script( 'lpm-admin', LPM_JS . '/admin/admin.js', array( 'jquery', 'jquery-ui-sortable' ), $version, true );

		// Global JS variables
		wp_localize_script( 'lpm-admin', 'WPMAdminParams', array(
				'adminUrl' => esc_url( admin_url( 'admin-ajax.php' ) ),
				'chooseImage' => esc_html__( 'Select an image', 'lastudio-playlist-manager' ),
				'chooseAudio' => esc_html__( 'Select audio files', 'lastudio-playlist-manager' ),
				'removeConfirmText' => esc_html__( 'Are you sure to want to remove this track?', 'lastudio-playlist-manager' ),
			)
		);
	}

	/**
	 * Adds the meta box container.
	 */
	public function add_meta_box( $post_type ) {

		add_meta_box(
			'lpm_tracklist',
			esc_html__( 'Tracklist', 'lastudio-playlist-manager' ),
			array( $this, 'render_tracklist_metabox' ),
			'lpm_playlist',
			'normal',
			'high'
		);

		add_meta_box(
			'lpm_tracklist_shortcode',
			esc_html__( 'Playlist shortcode', 'lastudio-playlist-manager' ),
			array( $this, 'render_shortcode_metabox' ),
			'lpm_playlist',
			'side',
			'high'
		);

		/* Bar option */
		if ( current_theme_supports( 'lpm_bar' ) ) {
			add_meta_box(
				'lpm_sticky_option',
				esc_html__( 'Use this playlist as sticky player', 'lastudio-playlist-manager' ),
				array( $this, 'render_sticky_player_option_metabox' ),
				'lpm_playlist',
				'side',
				'high'
			);
		}
	}

	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_shortcode_metabox( $post ) {
		$post_id = $post->ID;
		?>
		<p>
			<?php esc_html_e( 'Copy and paste the following shortcode in your post or page to display your playlist.', 'lastudio-playlist-manager' ); ?>
		</p>
		<input id="lpm-playlist-shortcode" readonly type="text" value='[lastudio_playlist id="<?php echo absint( $post_id ); ?>"]'>
		<?php
	}

	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_tracklist_metabox( $post ) {
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'lpm_tracklist', 'lpm_tracklist_nonce' );
		$tracklist_ids = lpm_array_to_list( get_post_meta( $post->ID, '_lpm_tracklist', true ) );
		?>
		<div id="lpm-playlist-editor" class="lpm-panel hide-if-no-js">
			<div class="lpm-panel-body">
				<p><?php esc_html_e( 'Click on the button below to add tracks to your playlist, then drag and drop to reorder them.', 'lastudio-playlist-manager' ); ?></p>
				<input type="hidden" id="file_ids" name="tracklist_ids" value="<?php echo esc_attr( $tracklist_ids ); ?>">
				<p><a href="#" class="button lpm-upload"><?php esc_html_e( 'Add tracks', 'lastudio-playlist-manager' ); ?></a></p>
				<div id="lpm-tracklist">
					<?php lpm_get_track_markup( $tracklist_ids ); ?>
				</div><!-- .lpm-tracklist -->
			</div><!-- .lpm-panel-body -->
		</div><!-- #lpm-playlist-editor -->
		<?php
	}

	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_sticky_player_option_metabox( $post ) {
		$meta = get_post_meta( $post->ID, '_do_lpm_bar', true );
		?>
		<label>
			<input <?php echo checked( true, $meta ); ?> type="checkbox" name="do_lpm_bar" value="1">
			<?php esc_html_e( 'Use this player as sticky player that will be displayed at the bottom of every page.', 'lastudio-playlist-manager' ); ?>
		</label>
		<?php
	}

	/**
	 * Process data while saving post
	 */
	public function save_post( $post_id ) {
		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['lpm_tracklist_nonce'] ) ) {
			return $post_id;
		}

		$nonce = $_POST['lpm_tracklist_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'lpm_tracklist' ) ) {
			return $post_id;
		}

		// If this is an autosave, our form has not been submitted,
		// so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		// Check the user's permissions.
		if ( 'lpm_playlist' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			}

		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}
		}

		/* OK, its safe for us to save the data now. */
		$tracklist_ids = lpm_list_to_array( $_POST['tracklist_ids'] ); // clean up list

		// Update the tracklist
		update_post_meta( $post_id, '_lpm_tracklist', $tracklist_ids );

		// Bar option
		$do_lpm_bar = isset( $_POST['do_lpm_bar'] );

		if ( $do_lpm_bar ) {

			// reset for other playlist
			$playlists = get_posts( array( 'post_type' => 'lpm_playlist', 'posts_per_page' => -1, ) ); // get all playlist

			foreach ( $playlists as $playlist ) {

				delete_post_meta( $playlist->ID, '_do_lpm_bar' );
			}

			update_option( '_lpm_bar', $post_id );

		} elseif ( $post_id == get_option( '_lpm_bar' ) ) {

			delete_option( '_lpm_bar' );
		}

		// Update the bar option
		update_post_meta( $post_id, '_do_lpm_bar', $do_lpm_bar );
	}

	/**
	 * Include any classes we need within admin.
	 */
	public function includes() {
		include_once( 'class-lpm-options.php' );
	}

	/**
	 * Add body class to the admin for cosmetic purpose
	 */
	public function admin_body_class( $classes ) {

		$classes .= ' lpm-admin';

		return $classes;
	}

	/**
	 * Add settings link in plugin page
	 */
	public function settings_action_links( $links ) {
		$setting_link = array(
			'<a href="' . admin_url( 'edit.php?post_type=lpm_playlist&page=lastudio-playlist-manager-settings' ) . '">' . esc_html__( 'Settings', 'lastudio-playlist-manager' ) . '</a>',
		);
		return array_merge( $links, $setting_link );
	}

	/**
	 * Plugin update
	 */
	public function plugin_update() {

		$plugin_slug = LPM_SLUG;
		$plugin_path = LPM_PATH;
		$remote_path = LPM_UPDATE_URL . '/' . $plugin_slug;
		$plugin_data = get_plugin_data( LPM_DIR . '/' . LPM_SLUG . '.php' );
		$current_version = $plugin_data['Version'];
		include_once( 'class-lpm-update.php');
		new LPM_Update( $current_version, $remote_path, $plugin_path );
	}
} // end class

return new LPM_Admin();