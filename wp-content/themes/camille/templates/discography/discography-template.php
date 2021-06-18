<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
get_header(); ?>
<?php do_action( 'camille/action/before_render_main' ); ?>
<div id="main" class="site-main">
	<div class="container">
		<div class="row">
			<main id="site-content" class="<?php echo esc_attr(Camille()->layout()->get_main_content_css_class('col-xs-12 site-content'))?>">
				<div class="site-content-inner">

					<?php do_action( 'camille/action/before_render_main_inner' ); ?>

					<div id="blog_content_container" class="main--loop-container"><?php

						do_action( 'camille/action/before_render_main_content' );

						$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
						$posts_per_page = apply_filters( 'camille_ld_posts_per_page', -1 );

						$args = array(
							'post_type' => 'ld_release',
							'posts_per_page' => $posts_per_page,
						);

						if ( -1 < $posts_per_page ) {
							$args['paged'] = $paged;
						}

						$loop = new WP_Query( $args );

						global $camille_loop;

						$tmp = $camille_loop;

						$camille_loop = array();

						$loop_layout = Camille()->settings()->get('discography_display_type', 'grid');
						$loop_style = Camille()->settings()->get('discography_display_style', '1');
						camille_set_theme_loop_prop('is_main_loop', true, true);
						camille_set_theme_loop_prop('loop_layout', $loop_layout);
						camille_set_theme_loop_prop('loop_style', $loop_style);
						camille_set_theme_loop_prop('responsive_column', Camille()->settings()->get('discography_column', array('xlg'=> 4, 'lg'=> 4,'md'=> 3,'sm'=> 2,'xs'=> 1)));
						camille_set_theme_loop_prop('image_size', Camille_Helper::get_image_size_from_string(Camille()->settings()->get('discography_thumbnail_size', 'full'),'full'));
						camille_set_theme_loop_prop('title_tag', 'h5');
						camille_set_theme_loop_prop('excerpt_length', 15);
						camille_set_theme_loop_prop('item_space', 'default');

						if($loop->have_posts()):

							get_template_part('templates/discography/loop/start');

							$blog_template = 'templates/discography/loop/loop';

							while($loop->have_posts()):

								$loop->the_post();
								get_template_part($blog_template);

							endwhile;

							get_template_part('templates/discography/loop/end');

						else:

							?>
							<p class="no-release"><?php _e( 'No release yet', 'camille' ); ?></p>
							<?php

						endif;

						/**
						 * Display pagination and reset loop
						 */

						camille_the_pagination(array(), $loop);

						wp_reset_postdata();

						$tmp = $camille_loop;

						do_action( 'camille/action/after_render_main_content' ); ?>

					</div>

					<?php do_action( 'camille/action/after_render_main_inner' ); ?>
				</div>
			</main>
			<?php get_sidebar();?>
		</div>
	</div>
</div>
<?php do_action( 'camille/action/after_render_main' ); ?>
<?php get_footer();?>
