<?php
/**
 * The Template for displaying all single releases.
 *
 * @author LaStudio
 * @package LaStudioDiscography/Templates
 * @version 1.0.0
 * @since 1.0.0
 */
 get_header();
?>
	<?php
		/**
		 * lastudio_discography_before_main_content hook
		 *
		 * @hooked lastudio_discography_output_content_wrapper - 10 (outputs opening divs for the content)
		 */
		do_action( 'lastudio_discography_before_main_content' );
	?>

	<?php while ( have_posts() ) : the_post(); ?>
	<article itemscope itemtype="http://schema.org/MusicAlbum" data-post-id="<?php the_ID(); ?>" id="post-<?php the_ID(); ?>" <?php post_class( array( 'lastudio-release' ) ); ?>>
		<?php
			/**
			 * lastudio_release_start_hook
			 */
			do_action( 'lastudio_release_start' );
		?>
		<div class="entry-thumbnail">
			<?php
				/**
				 * Cover
				 */
				ld_release_thumbnail();

				/**
				 * Buy Buttons
				 */
				ld_release_buttons();
			?>
		</div>

		<div class="entry-content">
			<h2 class="entry-title">
				<?php the_title(); ?>
			</h2>
			<div class="lastudio-release-meta">
				<?php
					/**
					 * Meta
					 */
					ld_release_meta();

					/**
					 * Tracklists
					 */
					ld_release_tracklist();
				?>
			</div>

			<?php the_content(); ?>
		</div><!-- .entry-content -->

		<div class="clear"></div>

		<?php // comments_template(); ?>

	</article><!-- .lastudio-release -->
	<?php lastudio_release_nav(); ?>
	<?php endwhile; ?>
	<?php
		/**
		 * lastudio_discography_after_main_content hook
		 *
		 * @hooked lastudio_discography_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'lastudio_discography_after_main_content' );
	?>

<?php
get_sidebar();
get_footer();
?>