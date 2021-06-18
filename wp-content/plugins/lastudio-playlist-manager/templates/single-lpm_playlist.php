<?php
/**
 * The Template for displaying all single playlist posts.
 *
 * @package WordPress
 * @subpackage LaStudio Playlist
 * @since LaStudio Playlist 1.0.0
 */
get_header( 'lpm_playlist' );
?>
<div id="primary" class="content-area">
	<main id="content" class="site-content clearfix" role="main">
		<?php
			/**
			 * lpm_before_main_content hook
			 */
			do_action( 'lpm_before_main_content' );
		?>

		<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php
					/**
					 * lpm_playlist_post_start hook
					 */
					do_action( 'lpm_playlist_post_start' );
				?>
				<?php
					/**
					 * Playlist template tag
					 */
					lpm_playlist( get_the_ID() );
				?>
				<footer class="entry-meta no-border">
					<?php edit_post_link( esc_html__( 'Edit', 'lastudio-playlist-manager' ), '<span class="edit-link">', '</span>' ); ?>
				</footer><!-- .entry-meta -->
				<?php
					/**
					 * lpm_playlist_post_end hook
					 */
					do_action( 'lpm_playlist_post_end' );
				?>
			</article><!-- #post -->
			<?php comments_template(); ?>
		<?php endwhile; // end of the loop. ?>
		<?php
			/**
			 * lpm_after_main_content hook
			 */
			do_action( 'lpm_after_main_content' );
		?>

	</main><!-- main#content .site-content-->
</div><!-- #primary .content-area -->
<?php
get_footer( 'lpm_playlist' );
?>