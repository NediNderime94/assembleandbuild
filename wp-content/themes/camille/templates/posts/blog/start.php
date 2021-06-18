<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $wp_query, $wp_rewrite;

$blog_item_space = Camille()->settings()->get('blog_item_space', 'default');

if($blog_item_space == 'zero'){
    $blog_item_space = 0;
}

$blog_design = Camille()->settings()->get('blog_design', 'list_1');
if( Camille()->layout()->get_header_layout() == 11 ){
    $blog_design = 'list_1';
}

$blog_columns = wp_parse_args( (array) Camille()->settings()->get('blog_post_column'), array('lg'=> 1,'md'=> 1,'sm'=> 1,'xs'=> 1, 'mb' => 1) );
$blog_masonry = ( Camille()->settings()->get('blog_masonry') == 'on' ) ? true : false;
$blog_pagination_type = Camille()->settings()->get('blog_pagination_type', 'pagination');
$css_classes = array( 'la-loop', 'showposts-loop', 'blog-main-loop' );
$css_classes[] = 'blog-pagination-type-' . $blog_pagination_type;
$css_classes[] = 'blog-' . $blog_design;

$layout = $blog_design;
$style  = str_replace(array('grid_', 'list_'), '', $layout);
$layout = str_replace($style, '', $layout);
$layout = str_replace('_', '', $layout);

$css_classes[] = "$layout-$style";
$css_classes[] = 'showposts-' . $layout;

if($layout == 'grid'){
    $css_classes[] = 'grid-items';
    $css_classes[] = 'grid-space-' . $blog_item_space;
    $css_classes[] = camille_render_grid_css_class_from_columns($blog_columns);
}

$data_js_component = array();

if($blog_masonry){
    $css_classes[] = 'js-el la-isotope-container';
    $data_js_component[] = 'DefaultMasonry';
}
$page_path = '';
if($blog_pagination_type == 'infinite_scroll'){
    $css_classes[] = 'js-el la-infinite-container';
    $data_js_component[] = 'InfiniteScroll';
}
if($blog_pagination_type == 'load_more'){
    $css_classes[] = 'js-el la-infinite-container infinite-show-loadmore';
    $data_js_component[] = 'InfiniteScroll';
}
if($blog_pagination_type == 'infinite_scroll' || $blog_pagination_type == 'load_more'){
    $page_link = get_pagenum_link();
    if ( !$wp_rewrite->using_permalinks() || is_admin() || strpos($page_link, '?') ) {
        if (strpos($page_link, '?') !== false)
            $page_path = apply_filters( 'get_pagenum_link', $page_link . '&amp;paged=');
        else
            $page_path = apply_filters( 'get_pagenum_link', $page_link . '?paged=');
    }
    else {
        $page_path = apply_filters( 'get_pagenum_link', $page_link . user_trailingslashit( $wp_rewrite->pagination_base . "/" ));
    }
}


$thumbnail_size     = Camille_Helper::get_image_size_from_string(Camille()->settings()->get('blog_thumbnail_size', 'full'), 'full');
$excerpt_length     = Camille()->settings()->get('blog_excerpt_length');
$content_type       = (Camille()->settings()->get('blog_content_display', 'excerpt') == 'excerpt') ? 'excerpt' : 'full';
$show_thumbnail     = (Camille()->settings()->get('featured_images_blog') == 'on') ? true : false;
$height_mode        = 'original';
$thumb_custom_height= '';

camille_set_theme_loop_prop('is_main_loop', true, true);
camille_set_theme_loop_prop('loop_layout', $layout);
camille_set_theme_loop_prop('loop_style', $style);
camille_set_theme_loop_prop('title_tag', 'h2');
camille_set_theme_loop_prop('image_size', $thumbnail_size);
camille_set_theme_loop_prop('excerpt_length', $excerpt_length);
camille_set_theme_loop_prop('content_type', $content_type);
camille_set_theme_loop_prop('show_thumbnail', $show_thumbnail);
camille_set_theme_loop_prop('height_mode', $height_mode);
camille_set_theme_loop_prop('height', $thumb_custom_height);

?>
<div
    class="<?php echo esc_attr(implode(' ', $css_classes)); ?>"
    <?php if(!empty($data_js_component)) echo 'data-la_component="'. esc_attr(json_encode($data_js_component)) .'"'; ?>
    data-item_selector=".blog__item"
    data-page_num="<?php echo esc_attr( get_query_var('paged') ? get_query_var('paged') : 1 ) ?>"
    data-page_num_max="<?php echo esc_attr( $wp_query->max_num_pages ? $wp_query->max_num_pages : 1 ) ?>"
    data-path="<?php echo esc_url( $page_path ) ?>">