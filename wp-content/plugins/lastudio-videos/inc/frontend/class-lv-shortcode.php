<?php
/**
 * LaStudio Videos Shortcode.
 *
 * @class LV_Shortcode
 * @author LaStudio
 * @category Core
 * @package LaStudioPageBuilder/Shortcode
 * @version 1.0.0
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * LV_Shortcode class.
 */
class LV_Shortcode {
	/**
	 * Constructor
	 */
	public function __construct() {

		add_shortcode( 'lastudio_last_videos', array( $this, 'shortcode' ) );
	}

	/**
	 * Add filter to exlude password protected posts
	 *
	 * Create a new filtering function that will add our where clause to the query
	 */
	public function filter_where( $where = '' ) {
		$where .= " AND post_password = ''";
		return $where;
	}

	/**
	 * Shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	public function shortcode( $atts ) {
		extract(
			shortcode_atts(
				array(
					'count' => 4,
					'category' => null,
					'tag' => null,
					'col' => lastudio_videos_get_option( 'col', 4 ),
					'padding' => 'yes',
					'animation' => '',
					'animation_delay' => '',
				), $atts
			)
		);

		ob_start();

		$args = array(
			'post_type' => array( 'la_video' ),
			'posts_per_page' => absint( $count ),
		);

		if ( $category ) {
			$args['video_type'] = $category;
		}

		if ( $tag ) {
			$args['video_tag'] = $tag;
		}

		$class = 'shortcode-video-grid';
		$class .= ' video-grid-col-' . absint( $col );
		$class .= ' shortcode-video-padding-' . esc_attr( $padding );
			
		add_filter( 'posts_where', array( $this, 'filter_where' ) );
		$loop = new WP_Query( $args );
		remove_filter( 'posts_where', array( $this, 'filter_where' ) );
		
		if ( $loop->have_posts() ) : ?>
			<div class="<?php echo $class; ?>" data-animation-parent="<?php echo esc_attr( $animation ); ?>">
				<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

					<?php lastudio_videos_get_template_part( 'content', 'video-shortcode' ); ?>

				<?php endwhile; ?>
			</div><!-- .shortcode-videos-grid -->
			<div class="clear"></div>
		<?php else : // no video ?>
			<?php lastudio_videos_get_template( 'loop/no-video-found.php' ); ?>
		<?php endif;
		wp_reset_postdata();

		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}

	/**
	 * Helper method to determine if a shortcode attribute is true or false.
	 *
	 * @since 1.0.2
	 *
	 * @param string|int|bool $var Attribute value.
	 * @return bool
	 */
	protected function shortcode_bool( $var ) {
		$falsey = array( 'false', '0', 'no', 'n' );
		return ( ! $var || in_array( strtolower( $var ), $falsey, true ) ) ? false : true;
	}

} // end class

return new LV_Shortcode();