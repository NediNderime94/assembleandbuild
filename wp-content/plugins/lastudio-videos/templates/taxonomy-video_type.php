<?php
/**
 * The Template for displaying the main videos page
 *
 * Override this template by copying it to yourtheme/lastudio-videos/videos-template.php
 *
 * @author LaStudio
 * @package LaStudioVideos/Templates
 * @since 1.0.3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'videos' ); ?>
	<div class="videos-container">
		<?php if ( have_posts() ) : ?>
			
			<?php
				/**
				 * Video Category Filter
				 */
				lastudio_videos_get_template( 'filter.php' );
			?>
			
			<?php lastudio_videos_loop_start(); ?>
				
				<?php while ( have_posts() ) : the_post(); ?>
				
					<?php lastudio_videos_get_template_part( 'content', 'video' ); ?>
				
				<?php endwhile; ?>
			
			<?php lastudio_videos_loop_end(); ?>
			
			<?php else : ?>

				<?php lastudio_videos_get_template( 'loop/no-video-found.php' ); ?>
			
			<?php endif; // end have_posts() check ?>
	</div><!-- .video-container -->
<?php get_footer( 'videos' ); ?>