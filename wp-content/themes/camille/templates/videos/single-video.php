<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header();

do_action( 'camille/action/before_render_main' );


$page_title_bar = Camille()->settings()->get('page_title_bar_layout_post_single_global', 'off');
$page_title_bar2 = Camille()->settings()->get_post_meta(get_the_ID(), 'page_title_bar_layout');
$hide_breadcrumb = Camille()->settings()->get_post_meta(get_the_ID(), 'hide_breadcrumb');
?>
<div id="main" class="site-main">
	<div class="container">
		<div class="row">
			<main id="site-content" class="<?php echo esc_attr(Camille()->layout()->get_main_content_css_class('col-xs-12 site-content'))?>">
				<div class="site-content-inner">

					<?php do_action( 'camille/action/before_render_main_inner' );?>

					<div class="page-content">

						<div class="single-post-detail clearfix">
							<?php

							do_action( 'camille/action/before_render_main_content' );

							if( have_posts() ):  the_post(); ?>

								<article id="post-<?php the_ID(); ?>" <?php post_class('single-post-content'); ?>>

									<?php
									if('above' == Camille()->settings()->get('blog_post_title')){
										the_title( '<header class="entry-header entry-header-above single_post_item--title"><h1 class="entry-title h3">', '</h1></header>' );
										if($page_title_bar2 != 'hide' && $page_title_bar == 'off' && $hide_breadcrumb != 'yes'){
											echo '<div class="la-breadcrumbs text-color-secondary">';
											do_action('camille/action/breadcrumbs/render_html');
											echo '</div>';
										}
									}
									?>

									<?php
									if('below' == Camille()->settings()->get('blog_post_title') ){
										the_title( '<header class="entry-header entry-header-below entry-header single_post_item--title"><h1 class="entry-title h3">', '</h1></header>' );
									}
									?>

									<div class="entry-content">
										<?php

										the_content();
										?>
									</div><!-- .entry-content -->
									<div class="clearfix"></div>
									<footer class="entry-footer clearfix">
										<?php
										echo camille_get_the_term_list(get_the_ID(), 'video_type', '<div class="entry-meta-footer"><div class="tags-list"><span><i class="fa fa-tags"></i></span><span class="tags-list-item text-color-secondary">', ', ', '</div>');
										?>

										<?php
										if(Camille()->settings()->get('blog_social_sharing_box') == 'on'){
											echo '<div class="la-sharing-single-posts">';
											echo sprintf('<span>%s <i class="fa fa-share-alt"></i></span>', esc_html_x('Share this post', 'front-view', 'camille') );
											camille_social_sharing(get_the_permalink(), get_the_title(), (has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'full') : ''));
											echo '</div>';
										}
										?>

										<?php edit_post_link( null, '<span class="edit-link hidden">', '</span>' ); ?>
									</footer><!-- .entry-footer -->

								</article><!-- #post-## -->

								<div class="clearfix"></div>

								<?php


								if(Camille()->settings()->get('blog_comments') == 'on' && ( comments_open() || get_comments_number() ) ){
									comments_template();
									echo '<div class="clearfix"></div>';
								}

								?>

							<?php endif; ?>

							<?php

							do_action( 'camille/action/after_render_main_content' );

							wp_reset_postdata();

							?>

						</div>

					</div>

					<?php do_action( 'camille/action/after_render_main_inner' );?>
				</div>
			</main>
			<!-- #site-content -->
			<?php get_sidebar();?>
		</div>
		<div class="row portfolio-nav">
			<div class="col-xs-4">
				<?php
				$prev = get_previous_post();
				if(!empty($prev) && isset($prev->ID)){
					printf(
						'<a href="%s"><i class="dl-icon-left"></i><span>%s</span></a>',
						get_the_permalink($prev->ID),
						esc_html_x('Preview', 'front-end', 'camille')
					);
				}
				?>
			</div>
			<div class="col-xs-4">
				<?php

				$discography_get_page_id = lastudio_videos_get_page_id();
				if($discography_get_page_id > 0){
					echo '<div class="nav-parents">';
					echo sprintf('<a href="%s"><i class="dl-icon-menu5"></i></a>',
						esc_url(get_the_permalink($discography_get_page_id))
					);
					echo '</div>';
				}

				?>
			</div>
			<div class="col-xs-4">
				<?php
				$next = get_next_post();
				if(!empty($next) && isset($next->ID)){
					printf(
						'<a href="%s"><span>%s</span><i class="dl-icon-right"></i></a>',
						get_the_permalink($next->ID),
						esc_html_x('Next', 'front-end', 'camille')
					);
				}
				?>
			</div>
		</div>
	</div>
</div>
<div class="clearfix"></div>
<!-- .site-main -->
<?php do_action( 'camille/action/after_render_main' ); ?>
<?php get_footer();?>
