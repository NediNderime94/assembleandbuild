<?php
/**
 * The Template for displaying all event posts.
 *
 * @package WordPress
 * @subpackage LaStudio Events
 * @since LaStudio Events 1.0.0
 */
get_header( 'events' );
?>
	<?php
		/**
		 * le_before_main_content hook
		 *
		 * @hooked le_output_content_wrapper - 10 (outputs opening divs for the content)
		 */
		do_action( 'le_before_main_content' );
	?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php echo lastudio_events(); ?>

		<?php endwhile; // end of the loop. ?>

	<?php
		/**
		 * le_after_main_content hook
		 *
		 * @hooked le_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'le_after_main_content' );
	?>
<?php
get_sidebar( 'events' );
get_footer( 'events' );
?>