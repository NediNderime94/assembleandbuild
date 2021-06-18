<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $camille_loop;

$tmp = $camille_loop;
$camille_loop = array();

$loop_layout = Camille()->settings()->get('portfolio_display_type', 'grid');
$loop_style = Camille()->settings()->get('portfolio_display_style', '1');

camille_set_theme_loop_prop('is_main_loop', true, true);
camille_set_theme_loop_prop('loop_layout', $loop_layout);
camille_set_theme_loop_prop('loop_style', $loop_style);
camille_set_theme_loop_prop('responsive_column', Camille()->settings()->get('portfolio_column', array('xlg'=> 1, 'lg'=> 1,'md'=> 1,'sm'=> 1,'xs'=> 1)));
camille_set_theme_loop_prop('image_size', Camille_Helper::get_image_size_from_string(Camille()->settings()->get('portfolio_thumbnail_size', 'full'),'full'));
camille_set_theme_loop_prop('title_tag', 'h4');
camille_set_theme_loop_prop('excerpt_length', '15');
camille_set_theme_loop_prop('item_space', (int) Camille()->settings()->get('portfolio_item_space', 0));

echo '<div id="archive_portfolio_listing" class="la-portfolio-listing">';

if( have_posts() ){

    get_template_part("templates/portfolios/start", $loop_style);

    while( have_posts() ){

        the_post();

        get_template_part("templates/portfolios/loop", $loop_style);

    }

    get_template_part("templates/portfolios/end", $loop_style);

}

echo '</div>';
/**
 * Display pagination and reset loop
 */

camille_the_pagination();

wp_reset_postdata();

$camille_loop = $tmp;