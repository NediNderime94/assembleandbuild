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

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'videos' );

	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	$posts_per_page = apply_filters( 'lv_posts_per_page', -1 );

	$args = array(
		'post_type' => 'la_video',
		'posts_per_page' => $posts_per_page,
	);

	if ( -1 < $posts_per_page ) {
		$args['paged'] = $paged;
	}

	/* Video Post Loop */
	$loop = new WP_Query( $args );
?>
	<div id="container" class="videos-container">
		<?php if ( $loop->have_posts() ) : ?>

			<?php
				/**
				 * Video Category Filter
				 */
				lastudio_videos_get_template( 'filter.php' );
			?>

			<?php lastudio_videos_loop_start(); ?>

				<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

					<?php lastudio_videos_get_template_part( 'content', 'video' ); ?>

				<?php endwhile; ?>

			<?php lastudio_videos_loop_end(); ?>

			<?php else : ?>

				<?php lastudio_videos_get_template( 'loop/no-video-found.php' ); ?>

		<?php endif; // end have_posts() check ?>
	</div><!-- .video-container -->
<?php
get_sidebar( 'videos' );
get_footer( 'videos' ); ?>