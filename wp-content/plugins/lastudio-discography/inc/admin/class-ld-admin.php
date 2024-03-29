<?php
/**
 * LaStudio Discography Admin.
 *
 * @class LD_Admin
 * @author LaStudio
 * @category Admin
 * @package LaStudioDiscography/Admin
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * LD_Admin class.
 */
class LD_Admin {
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
		include_once( 'class-ld-options.php' );
		include_once( 'class-ld-metabox.php' );
		include_once( 'ld-admin-functions.php' );
	}

	/**
	 * Admin init
	 */
	public function admin_init_hooks() {

		// Plugin settings link
		add_filter( 'plugin_action_links_' . plugin_basename( LD_PATH ), array( $this, 'settings_action_links' ) );

		// Plugin update notifications
		add_action( 'admin_init', array( $this, 'plugin_update' ) );

		// Create page notice
		add_action( 'admin_notices', array( $this, 'check_page' ) );
		add_action( 'admin_notices', array( $this, 'create_page' ) );

		// Hide editors from index page
		add_action( 'edit_form_after_title', array( $this, 'is_index_page' ) );
		add_action( 'admin_init', array( $this, 'hide_editor' ) );
		add_action( 'admin_head', array( $this, 'hide_wpb_editor' ) );

		// Add columns to post list
		add_filter( 'manage_release_posts_columns', array( $this, 'admin_columns_head_release_thumb' ), 10 );
		add_action( 'manage_release_posts_custom_column', array( $this, 'admin_columns_content_release_thumb' ), 10, 2 );
	}

	/**
	 * Add metaboxes
	 */
	public function metaboxes() {
		include_once( 'ld-metaboxes.php' );
	}

	/**
	 * Check discography page
	 *
	 * Display a notification if we can't get the discography page id
	 *
	 */
	public function check_page() {

		$output    = '';
		$theme_dir = get_template_directory();

		// update_option( '_lastudio_discography_needs_page', true );
		// delete_option( '_lastudio_discography_no_needs_page', true );
		// delete_option( '_lastudio_discography_page_id' );

		if ( get_option( '_lastudio_discography_no_needs_page' ) )
			return;

		if ( ! get_option( '_lastudio_discography_needs_page' ) )
			return;

		if ( -1 == lastudio_discography_get_page_id() && ! isset( $_GET['lastudio_discography_create_page'] ) ) {

			if ( isset( $_GET['skip_lastudio_discography_setup'] ) ) {
				delete_option( '_lastudio_discography_needs_page' );
				return;
			}

			update_option( '_lastudio_discography_needs_page', true );

			$message = '<strong>LaStudio Discography</strong> ' . sprintf(
					wp_kses(
						__( 'says : <em>Almost done! you need to <a href="%1$s">create a page</a> for your releases or <a href="%2$s">select an existing page</a> in the plugin settings</em>.', 'lastudio-discography' ),
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
					esc_url( admin_url( '?lastudio_discography_create_page=true' ) ),
					esc_url( admin_url( 'edit.php?post_type=ld_release&page=lastudio-discography-settings' ) )
			);

			$message .= sprintf(
				wp_kses(
					__( '<br><br>
					<a href="%1$s" class="button button-primary">Create a page</a>
					&nbsp;
					<a href="%2$s" class="button button-primary">Select an existing page</a>
					&nbsp;
					<a href="%3$s" class="button">Skip setup</a>', 'lastudio-discography' ),

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
					esc_url( admin_url( '?lastudio_discography_create_page=true' ) ),
					esc_url( admin_url( 'edit.php?post_type=ld_release&page=lastudio-discography-settings' ) ),
					esc_url( admin_url( '?skip_lastudio_discography_setup=true' ) )
			);

			$output = '<div class="updated lastudio-admin-notice lastudio-plugin-admin-notice"><p>';

				$output .= $message;

			$output .= '</p></div>';

			echo $output;
		} else {

			delete_option( '_lastudio_discography_need_page' );
		}

		return false;
	}

	/**
	 * Create discography page
	 */
	public function create_page() {

		if ( isset( $_GET['lastudio_discography_create_page'] ) && $_GET['lastudio_discography_create_page'] == 'true' ) {

			$output = '';

			// Create post object
			$post = array(
				'post_title'  => esc_html__( 'Discography', 'lastudio-discography' ),
				'post_type'   => 'page',
				'post_status' => 'publish',
			);

			// Insert the post into the database
			$post_id = wp_insert_post( $post );

			if ( $post_id ) {

				update_option( '_lastudio_discography_page_id', $post_id );
				update_post_meta( $post_id, '_wpb_status', 'off' ); // disable page builder mode for this page

				$message = esc_html__( 'Your discography page has been created succesfully', 'lastudio-discography' );

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
	public function is_index_page() {

		if ( isset( $_GET['post'] ) && absint( $_GET['post'] ) == lastudio_discography_get_page_id() ) {
			$message = esc_html__( 'You are currently editing the page that shows the discography.', 'lastudio-discography' );

			$output = '<div class="notice notice-warning inline"><p>';

			$output .= $message;

			$output .= '</p></div>';

			echo $output;
		}
	}

	/**
	 * Hide the editor if we're on the admin discography page
	 */
	public function hide_editor() {
		if ( isset( $_GET['post'] ) && absint( $_GET['post'] ) == lastudio_discography_get_page_id() ) {
			remove_post_type_support( 'page', 'editor' );
		}
	}

	/**
	 * Hide the editor if we're on the admin discography page
	 */
	public function hide_wpb_editor() {
		if ( isset( $_GET['post'] ) && absint( $_GET['post'] ) == lastudio_discography_get_page_id() ) {
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
	 * Add thumbnail column head in admin posts list
	 *
	 * @param array $columns
	 * @return array $columns
	 */
	public function admin_columns_head_release_thumb( $columns ) {

		$columns['release_thumbnail']   = esc_html__( 'Thumbnail', 'lastudio-discography' );
		return $columns;
	}

	/**
	 * Add thumbnail column in admin posts list
	 *
	 * @param string $column_name
	 * @param int $post_id
	 */
	public function admin_columns_content_release_thumb( $column_name, $post_id ) {

		$thumbnail = get_the_post_thumbnail();

		if ( 'release_thumbnail' == $column_name ) {

			if ( $thumbnail ) {
				echo '<a href="' . get_edit_post_link() . '" title="' . esc_attr( sprintf( esc_html__( 'Edit "%s"', 'lastudio-discography' ), get_the_title() ) ) . '">' . get_the_post_thumbnail( '', array( 60, 60 ), array( 'style' => 'max-width:60px;height:auto;' ) ) . '</a>';
			}
		}
	}

	/**
	 * Add settings link in plugin page
	 */
	public function settings_action_links( $links ) {
		$setting_link = array(
			'<a href="' . admin_url( 'edit.php?ld_release=release&page=lastudio-discography-settings' ) . '">' . esc_html__( 'Settings', 'lastudio-discography' ) . '</a>',
		);
		return array_merge( $links, $setting_link );
	}

	/**
	 * Plugin update
	 */
	public function plugin_update() {
		
		$plugin_name = LD_SLUG;
		$plugin_slug = LD_SLUG;
		$plugin_path = LD_PATH;
		$remote_path = LD_UPDATE_URL . '/' . $plugin_slug;
		$plugin_data = get_plugin_data( LD_DIR . '/' . LD_SLUG . '.php' );
		$current_version = $plugin_data['Version'];
		include_once( 'class-ld-update.php');
		new LD_Update( $current_version, $remote_path, $plugin_path );
	}
}

return new LD_Admin();