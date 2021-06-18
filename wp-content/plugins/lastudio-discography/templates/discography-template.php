<?php
/**
 * The Template for displaying the main releases page
 *
 * Override this template by copying it to yourtheme/lastudio-discography/discography-template.php
 *
 * @author LaStudio
 * @package LaStudioDiscography/Templates
 * @version 1.0.0
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

get_header( 'discography' );

	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	$posts_per_page = apply_filters( 'ld_posts_per_page', -1 );
	
	$args = array(
		'post_type' => 'ld_release',
		'posts_per_page' => $posts_per_page,
	);

	if ( -1 < $posts_per_page ) {
		$args['paged'] = $paged;
	}

	$loop = new WP_Query( $args );

	/**
	 * lastudio_discography_before_main_content hook
	 *
	 * @hooked lastudio_discography_output_content_wrapper - 10 (outputs opening divs for the content)
	 */
	do_action( 'lastudio_discography_before_main_content' );

	if ( $loop->have_posts() ) : ?>

		<?php lastudio_discography_loop_start(); ?>

			<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

				<?php lastudio_discography_get_template_part( 'content', 'release' ); ?>

			<?php endwhile; ?>

		<?php lastudio_discography_loop_end(); ?>


	<?php lastudio_release_page_nav( $loop ); ?>

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

get_sidebar( 'discography' );
get_footer( 'discography' );
?>