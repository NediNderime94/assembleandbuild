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

						global $camille_loop;

						$tmp = $camille_loop;

						$camille_loop = array();

						$loop_layout = Camille()->settings()->get('video_display_type', 'grid');
						$loop_style = Camille()->settings()->get('video_display_style', '1');
						camille_set_theme_loop_prop('is_main_loop', true, true);
						camille_set_theme_loop_prop('loop_layout', $loop_layout);
						camille_set_theme_loop_prop('loop_style', $loop_style);
						camille_set_theme_loop_prop('responsive_column', Camille()->settings()->get('video_column', array('xlg'=> 3, 'lg'=> 3,'md'=> 2,'sm'=> 2,'xs'=> 1)));
						camille_set_theme_loop_prop('image_size', Camille_Helper::get_image_size_from_string(Camille()->settings()->get('video_thumbnail_size', 'full'),'full'));
						camille_set_theme_loop_prop('title_tag', 'h5');
						camille_set_theme_loop_prop('excerpt_length', 15);
						camille_set_theme_loop_prop('item_space', 'default');

						if(have_posts()):

							get_template_part('templates/videos/loop/start');

							$blog_template = 'templates/videos/loop/loop';

							while(have_posts()):

								the_post();
								get_template_part($blog_template);

							endwhile;

							get_template_part('templates/videos/loop/end');

						else:

							?>
							<p class="no-release"><?php _e( 'No video yet', 'camille' ); ?></p>
							<?php

						endif;

						/**
						 * Display pagination and reset loop
						 */

						camille_the_pagination();

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