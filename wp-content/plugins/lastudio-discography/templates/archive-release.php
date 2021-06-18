<?php
/**
 * The Template for displaying release archives
 *
 * Override this template by copying it to yourtheme/lastudio-discography/archive-release.php
 *
 * @author LaStudio
 * @package LaStudioDiscography/Templates
 * @version 1.0.0
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'discography' ); ?>

	<?php
		/**
		 * lastudio_discography_before_main_content hook
		 *
		 * @hooked lastudio_discography_output_content_wrapper - 10 (outputs opening divs for the content)
		 */
		do_action( 'lastudio_discography_before_main_content' );
	?>

	<?php
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; ?>
		
		<?php if ( have_posts() ) : ?>
			
			<?php lastudio_discography_loop_start(); ?>
			
				<?php while ( have_posts() ) : the_post(); ?>
				
					<?php lastudio_discography_get_template_part( 'content', 'release' ); ?>
				
				<?php endwhile; ?>
			
			<?php lastudio_discography_loop_end(); ?>
		
			<?php lastudio_release_page_nav(); ?>
		
		<?php else : ?>

			<?php lastudio_discography_get_template( 'loop/no-releases-found.php' ); ?>

		<?php endif; ?>

	<?php
		/**
		 * lastudio_discography_after_main_content hook
		 *
		 * @hooked lastudio_discography_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action('lastudio_discography_after_main_content');
	?>

<?php
get_sidebar( 'discography' );
get_footer( 'discography' ); 
?>