<?php
/**
 * Video Loop Start
 *
 * @author LaStudio
 * @package LaStudioVideos/Templates
 * @since 1.0.3
 */
$columns = lastudio_videos_get_option( 'col', 4 );
?>
<div class="videos <?php echo sanitize_html_class( 'videos-grid-col-' . $columns ); ?>">