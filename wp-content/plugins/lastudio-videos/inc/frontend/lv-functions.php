<?php
/**
 * LaStudioVideos Functions
 *
 * Hooked-in functions for LaStudioVideos related events on the front-end.
 *
 * @author LaStudio
 * @category Core
 * @package LaStudioVideos/Functions
 * @since 1.0.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


/**
 * Handle redirects before content is output - hooked into template_redirect so is_page videos.
 *
 * @return void
 */
function lastudio_videos_template_redirect() {

	if ( is_page( lastudio_videos_get_page_id() ) && ! post_password_required() ) {
		lastudio_videos_get_template( 'videos-template.php' );
		exit();
	}
}