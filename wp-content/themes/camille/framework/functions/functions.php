<?php if ( ! defined( 'ABSPATH' ) ) { die; }

if(!function_exists('camille_entry_meta_item_postdate')){
    function camille_entry_meta_item_postdate(){

        global $post;

        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated hidden" datetime="%3$s">%4$s</time>';
        }

        $h_time = get_the_date();
        $time = get_post_time( 'G', true, $post, false );
        if ( ( abs( $t_diff = time() - $time ) ) < DAY_IN_SECONDS ) {
            if ( $t_diff < 0 ) {
                $h_time = sprintf( _x( '%s from now', '%s = human-readable time difference', 'camille' ), human_time_diff( $time ) );
            } else {
                $h_time = sprintf( _x( '%s ago', '%s = human-readable time difference', 'camille'), human_time_diff( $time ) );
            }
        }

        $time_string = sprintf( $time_string,
            esc_attr( get_the_date( 'c' ) ),
            esc_html( $h_time ),
            esc_attr( get_the_modified_date( 'c' ) ),
            esc_html( get_the_modified_date() )
        );
        printf(
            '<div class="loop__item__meta--item posted-on"><a href="%1$s" rel="bookmark"><i class="dl-icon-clock"></i><span class="screen-reader-text">%2$s </span>%3$s</a></div>',
            esc_url( get_permalink() ),
            esc_html_x('Posted on', 'front-view', 'camille'),
            $time_string
        );
    }
}
if(!function_exists('camille_entry_meta_item_author')){
    function camille_entry_meta_item_author( $show_avatar = false ){

        if( $show_avatar ) {
            $avatar_html = get_avatar( get_the_author_meta( 'user_email' ), 50 );
        }
        else{
            $avatar_html = '<i class="dl-icon-user1"></i>';
        }

        printf(
            '<div class="loop__item__meta--item byline"><span class="author vcard"><a class="url fn n" href="%1$s">%4$s<span class="screen-reader-text">%2$s </span>%3$s</a></span></div>',
            esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
            esc_html_x('by', 'front-view', 'camille'),
            esc_html( get_the_author() ),
            $avatar_html
        );
    }
}
if(!function_exists('camille_entry_meta_item_category_list')){
    function camille_entry_meta_item_category_list($before = '', $after = '', $separator = ', ', $parents = '', $post_id = false){
        add_filter('get_the_terms', 'camille_exclude_demo_term_in_category');
        $categories_list = get_the_category_list('{{_}}', $parents, $post_id );
        remove_filter('get_the_terms', 'camille_exclude_demo_term_in_category');
        if ( $categories_list ) {
            printf(
                '%3$s<span class="screen-reader-text">%1$s </span><span>%2$s</span>%4$s',
                esc_html_x('Posted in', 'front-view', 'camille'),
                str_replace('{{_}}', $separator, $categories_list),
                $before,
                $after
            );
        }
    }
}

if(!function_exists('camille_exclude_demo_term_in_category')){
    function camille_exclude_demo_term_in_category( $term ){
        return apply_filters('camille/post_category_excluded', $term);
    }
}

if(!function_exists('camille_entry_meta_item_comment_post_link')){
    function camille_entry_meta_item_comment_post_link(){
        if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
            echo '<div class="comments-link">';
            comments_popup_link();
            echo '</div>';
        }
    }
}

if(!function_exists('camille_get_the_term_list')){
    function camille_get_the_term_list( $id, $taxonomy, $before = '', $sep = '', $after = '', $limit = 0 ) {
        $terms = get_the_terms( $id, $taxonomy );
        if ( is_wp_error( $terms ) )
            return $terms;

        if ( empty( $terms ) )
            return false;

        $links = array();

        $limit = absint($limit);
        $_counter = 1;

        foreach ( $terms as $term ) {
            if($limit > 0 && $_counter > $limit){
                break;
            }
            $_counter++;
            $link = get_term_link( $term, $taxonomy );
            if ( is_wp_error( $link ) ) {
                return $link;
            }
            $links[] = '<a href="' . esc_url( $link ) . '" rel="tag">' . $term->name . '</a>';
        }

        $term_links = apply_filters( "term_links-{$taxonomy}", $links );

        return $before . join( $sep, $term_links ) . $after;
    }
}

if(!function_exists('camille_entry_meta_item_comment_post_link_with_icon')){
    function camille_entry_meta_item_comment_post_link_with_icon(){
        if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {

            $svg_icon = '<svg aria-hidden="true" data-prefix="fal" data-icon="comments" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="svg-inline--fa"><path fill="currentColor" d="M532 386.2c27.5-27.1 44-61.1 44-98.2 0-80-76.5-146.1-176.2-157.9C368.4 72.5 294.3 32 208 32 93.1 32 0 103.6 0 192c0 37 16.5 71 44 98.2-15.3 30.7-37.3 54.5-37.7 54.9-6.3 6.7-8.1 16.5-4.4 25 3.6 8.5 12 14 21.2 14 53.5 0 96.7-20.2 125.2-38.8 9.1 2.1 18.4 3.7 28 4.8 31.5 57.5 105.5 98 191.8 98 20.8 0 40.8-2.4 59.8-6.8 28.5 18.5 71.6 38.8 125.2 38.8 9.2 0 17.5-5.5 21.2-14 3.6-8.5 1.9-18.3-4.4-25-.5-.4-22.6-24.2-37.9-54.9zM142.2 311l-11.4 7.4c-20.1 13.1-50.5 28.2-87.7 32.5 8.8-11.3 20.2-27.6 29.5-46.4L83 283.7l-16.5-16.3C50.7 251.9 32 226.2 32 192c0-70.6 79-128 176-128s176 57.4 176 128-79 128-176 128c-17.7 0-35.4-2-52.6-6l-13.2-3zm303 103.4l-11.4-7.4-13.2 3.1c-17.2 4-34.9 6-52.6 6-65.1 0-122-25.9-152.4-64.3C326.9 348.6 416 278.4 416 192c0-9.5-1.3-18.7-3.3-27.7C488.1 178.8 544 228.7 544 288c0 34.2-18.7 59.9-34.5 75.4L493 379.7l10.3 20.7c9.4 18.9 20.8 35.2 29.5 46.4-37.1-4.2-67.5-19.4-87.6-32.4zm-37.8-267.7c.1.2.1.4.2.6-.1-.2-.1-.4-.2-.6z"></path></svg>';

            echo '<div class="comments-link">';
            comments_popup_link('<i class="fa fa-comments">'.$svg_icon.'</i>', '<i class="fa fa-comments">'.$svg_icon.'</i><span>1</span>', '<i class="fa fa-comments">'.$svg_icon.'</i><span>%</span>');
            echo '</div>';
        }
    }
}

if(!function_exists('camille_entry_meta_item_post_love')) {
    function camille_entry_meta_item_post_love()
    {
        echo '<span class="post-love-count">';
        $post_love_count = get_post_meta(get_the_ID(), '_la_love_count', true);
        printf(
            '<a data-post-id="%s" href="%s">%s</a>',
            esc_attr(get_the_ID()),
            esc_url( get_permalink() ),
            absint($post_love_count)
        );
        echo '</span>';
    }
}

if(!function_exists('camille_single_post_thumbnail')){
    function camille_single_post_thumbnail( $thumbnail_size = 'full'){
        if ( post_password_required() || is_attachment() ) {
            return;
        }
        $flag_format_content = false;

        switch(get_post_format()){
            case 'link':
                $link = Camille()->settings()->get_post_meta( get_the_ID(), 'format_link' );
                if(!empty($link)){
                    printf(
                        '<div class="blog_item--thumbnail format-link" %2$s><div class="format-content">%1$s</div><a class="post-link-overlay" href="%1$s"></a></div>',
                        esc_url($link),
                        has_post_thumbnail() ? 'style="background-image:url('.Camille()->images()->get_post_thumbnail_url(get_the_ID()).')"' : ''
                    );
                    $flag_format_content = true;
                }
                break;
            case 'quote':
                $quote_content = Camille()->settings()->get_post_meta(get_the_ID(), 'format_quote_content');
                $quote_author = Camille()->settings()->get_post_meta(get_the_ID(), 'format_quote_author');
                $quote_background = Camille()->settings()->get_post_meta(get_the_ID(), 'format_quote_background');
                $quote_color = Camille()->settings()->get_post_meta(get_the_ID(), 'format_quote_color');
                if(!empty($quote_content)){
                    $quote_content = '<p class="format-quote-content">'. $quote_content .'</p>';
                    if(!empty($quote_author)){
                        $quote_content .= '<span class="quote-author">'. $quote_author .'</span>';
                    }
                    $styles = array();
                    $styles[] = 'background-color:' . $quote_background;
                    $styles[] = 'color:' . $quote_color;
                    printf(
                        '<div class="blog_item--thumbnail format-quote" style="%3$s"><div class="format-content">%1$s</div><a class="post-link-overlay" href="%2$s"></a></div>',
                        $quote_content,
                        get_the_permalink(),
                        esc_attr( implode(';', $styles) )
                    );
                    $flag_format_content = true;
                }

                break;

            case 'gallery':
                $ids = Camille()->settings()->get_post_meta(get_the_ID(), 'format_gallery');
                $ids = explode(',', $ids);
                $ids = array_map('trim', $ids);
                $ids = array_map('absint', $ids);
                $__tmp = '';
                if(!empty( $ids )){
                    foreach($ids as $image_id){
                        $__tmp .= sprintf('<div><a href="%1$s">%2$s</a></div>',
                            get_the_permalink(),
                            Camille()->images()->get_attachment_image( $image_id, $thumbnail_size)
                        );
                    }
                }
                if(has_post_thumbnail()){
                    $__tmp .= sprintf('<div><a href="%1$s">%2$s</a></div>',
                        get_the_permalink(),
                        Camille()->images()->get_post_thumbnail(get_the_ID(), $thumbnail_size )
                    );
                }
                if(!empty($__tmp)){
                    printf(
                        '<div class="blog_item"><div class="blog_item--thumbnail format-gallery"><div data-la_component="AutoCarousel" class="js-el la-slick-slider" data-slider_config="%1$s">%2$s</div></div></div>',
                        esc_attr(json_encode(array(
                            'slidesToShow' => 1,
                            'slidesToScroll' => 1,
                            'dots' => false,
                            'arrows' => true,
                            'speed' => 300,
                            'autoplay' => false,
                            'prevArrow'=> '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
                            'nextArrow'=> '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>'
                        ))),
                        $__tmp
                    );
                    $flag_format_content = true;
                }
                break;

            case 'audio':
            case 'video':
                $embed_source = Camille()->settings()->get_post_meta(get_the_ID(), 'format_embed');
                $embed_aspect_ration = Camille()->settings()->get_post_meta(get_the_ID(), 'format_embed_aspect_ration');
                if(!empty($embed_source)){
                    $flag_format_content = true;
                    printf(
                        '<div class="blog_item--thumbnail format-embed"><div class="la-media-wrapper la-media-aspect-%2$s">%1$s</div></div>',
                        $embed_source,
                        esc_attr($embed_aspect_ration ? $embed_aspect_ration : 'origin')
                    );
                }
                break;
        }

        if(!$flag_format_content && has_post_thumbnail()){ ?>
            <div class="entry-thumbnail">
                <a href="<?php the_permalink();?>">
                    <?php Camille()->images()->the_post_thumbnail(get_the_ID(), $thumbnail_size); ?>
                    <span class="pf-icon pf-icon-<?php echo get_post_format() ? get_post_format() : 'standard' ?>"></span>
                </a>
            </div>
            <?php
        }

    }
}

if(!function_exists('camille_social_sharing')){
    function camille_social_sharing( $post_link = '', $post_title = '', $image = '', $post_excerpt = '', $echo = true){
        if(empty($post_link) || empty($post_title)){
            return;
        }
        if(!$echo){
            ob_start();
        }
        echo '<div class="social--sharing">';
        if(Camille()->settings()->get('sharing_facebook') || 'on' == Camille()->settings()->get('sharing_facebook')){
            printf('<a target="_blank" href="%1$s" rel="nofollow" class="facebook" title="%2$s"><i class="fa fa-facebook"></i></a>',
                esc_url( 'https://www.facebook.com/sharer.php?u=' . $post_link ),
                esc_attr_x('Share this post on Facebook', 'front-view', 'camille')
            );
        }
        if(Camille()->settings()->get('sharing_twitter') || 'on' == Camille()->settings()->get('sharing_twitter')){
            printf('<a target="_blank" href="%1$s" rel="nofollow" class="twitter" title="%2$s"><i class="fa fa-twitter"></i></a>',
                esc_url( 'https://twitter.com/intent/tweet?text=' . $post_title . '&url=' . $post_link ),
                esc_attr_x('Share this post on Twitter', 'front-view', 'camille')
            );
        }
        if(Camille()->settings()->get('sharing_reddit') || 'on' == Camille()->settings()->get('sharing_reddit')){
            printf('<a target="_blank" href="%1$s" rel="nofollow" class="reddit" title="%2$s"><i class="fa fa-reddit"></i></a>',
                esc_url( 'https://www.reddit.com/submit?url=' . $post_link . '&title=' . $post_title ),
                esc_attr_x('Share this post on Reddit', 'front-view', 'camille')
            );
        }
        if(Camille()->settings()->get('sharing_linkedin') || 'on' == Camille()->settings()->get('sharing_linkedin')){
            printf('<a target="_blank" href="%1$s" rel="nofollow" class="linkedin" title="%2$s"><i class="fa fa-linkedin"></i></a>',
                esc_url( 'https://www.linkedin.com/shareArticle?mini=true&url=' . $post_link . '&title=' . $post_title ),
                esc_attr_x('Share this post on Linked In', 'front-view', 'camille')
            );
        }
        if(Camille()->settings()->get('sharing_tumblr') || 'on' == Camille()->settings()->get('sharing_tumblr')){
            printf('<a target="_blank" href="%1$s" rel="nofollow" class="tumblr" title="%2$s"><i class="fa fa-tumblr"></i></a>',
                esc_url( 'https://www.tumblr.com/share/link?url=' . $post_link ) ,
                esc_attr_x('Share this post on Tumblr', 'front-view', 'camille')
            );
        }
        if(Camille()->settings()->get('sharing_pinterest') || 'on' == Camille()->settings()->get('sharing_pinterest')){
            printf('<a target="_blank" href="%1$s" rel="nofollow" class="pinterest" title="%2$s"><i class="fa fa-pinterest-p"></i></a>',
                esc_url( 'https://pinterest.com/pin/create/button/?url=' . $post_link . '&media=' . $image . '&description=' . $post_title) ,
                esc_attr_x('Share this post on Pinterest', 'front-view', 'camille')
            );
        }
        if(Camille()->settings()->get('sharing_google_plus') || 'on' == Camille()->settings()->get('sharing_google_plus')){
            printf('<a target="_blank" href="%1$s" rel="nofollow" class="google-plus" title="%2$s"><i class="fa fa-google-plus"></i></a>',
                esc_url( 'https://plus.google.com/share?url=' . $post_link ),
                esc_attr_x('Share this post on Google Plus', 'front-view', 'camille')
            );
        }
        if(Camille()->settings()->get('sharing_vk') || 'on' == Camille()->settings()->get('sharing_vk')){
            printf('<a target="_blank" href="%1$s" rel="nofollow" class="vk" title="%2$s"><i class="fa fa-vk"></i></a>',
                esc_url( 'http://vkontakte.ru/share.php?url=' . $post_link . '&title=' . $post_title ) ,
                esc_attr_x('Share this post on VK', 'front-view', 'camille')
            );
        }
        if(Camille()->settings()->get('sharing_email') || 'on' == Camille()->settings()->get('sharing_email')){
            printf('<a target="_blank" href="%1$s" rel="nofollow" class="email" title="%2$s"><i class="fa fa-envelope"></i></a>',
                esc_url( 'mailto:?subject=' . $post_title . '&body=' . $post_link ),
                esc_attr_x('Share this post via Email', 'front-view', 'camille')
            );
        }
        echo '</div>';
        if(!$echo){
            return ob_get_clean();
        }
    }
}

if(!function_exists('camille_the_pagination')){
    function camille_the_pagination($args = array(), $query = null) {
        if(null === $query) {
            $query = $GLOBALS['wp_query'];
        }
        if($query->max_num_pages < 2) {
            return;
        }
        $paged        = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
        $pagenum_link = html_entity_decode(get_pagenum_link());
        $wp_rewrite  = $GLOBALS['wp_rewrite'];
        $query_args   = array();
        $url_parts    = explode('?', $pagenum_link);
        if(isset($url_parts[1])) {
            wp_parse_str($url_parts[1], $query_args);
        }

        $pagenum_link = remove_query_arg(array_keys($query_args), $pagenum_link);
        $pagenum_link = trailingslashit($pagenum_link) . '%_%';

        $format  = $wp_rewrite->using_index_permalinks() && ! strpos($pagenum_link, 'index.php') ? 'index.php/' : '';
        $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit('page/%#%', 'paged') : '?paged=%#%';
        printf('<div class="la-pagination">%s</div>',
            paginate_links(array_merge(array(
                'base'     => $pagenum_link,
                'format'   => $format,
                'total'    => $query->max_num_pages,
                'current'  => $paged,
                'mid_size' => 1,
                'add_args' => array_map('urlencode', $query_args),
                'prev_text'    => esc_html_x('Prev', 'front-view', 'camille'),
                'next_text'    => esc_html_x('Next', 'front-view', 'camille'),
                'type'         => 'list'
            ), $args))
        );
    }
}

if(!function_exists('camille_get_social_media')){
    function camille_get_social_media( $style = 'default', $el_class = ''){
        $css_class = implode(' ', array(
                'social-media-link',
                'style-' . $style
            )) ;
        $css_class .= ' ' . $el_class;

        $social_links = Camille()->settings()->get('social_links', array());
        if(!empty($social_links)){
            echo '<div class="'.esc_attr($css_class).'">';
            foreach($social_links as $item){
                if(!empty($item['link']) && !empty($item['icon'])){
                    $title = isset($item['title']) ? $item['title'] : '';
                    printf(
                        '<a href="%1$s" class="%2$s" title="%3$s" target="_blank" rel="nofollow"><i class="%4$s"></i></a>',
                        esc_url($item['link']),
                        esc_attr(sanitize_title($title)),
                        esc_attr($title),
                        esc_attr($item['icon'])
                    );
                }
            }
            echo '</div>';
        }
    }
}
if(!function_exists('camille_get_portfolio_social_media')){
    function camille_get_portfolio_social_media($post_id = 0, $el_class = ''){

        $css_class = 'social--sharing ' . $el_class;

        $social_links = Camille()->settings()->get_post_meta($post_id,'social_links');

        if(!empty($social_links) && is_array($social_links)){
            echo '<div class="'.esc_attr($css_class).'">';
            foreach($social_links as $item){
                if(!empty($item['link']) && !empty($item['icon'])){
                    $title = isset($item['title']) ? $item['title'] : '';
                    $custom_style = array();
                    if(!empty($item['text_color'])){
                        $custom_style[] = "color:" .$item['text_color'];
                    }
                    if(!empty($item['bg_color'])){
                        $custom_style[] = "background-color:" .$item['bg_color'];
                    }
                    printf(
                        '<a href="%1$s" class="%2$s" title="%3$s" style="%5$s" target="_blank" rel="nofollow"><i class="%4$s"></i></a>',
                        esc_url($item['link']),
                        esc_attr(sanitize_title($title)),
                        esc_attr($title),
                        esc_attr($item['icon']),
                        esc_attr(implode(';', $custom_style))
                    );
                }
            }
            echo '</div>';
        }
    }
}

if(!function_exists('camille_comment_form_callback')) {
    function camille_comment_form_callback($comment, $args, $depth){
        $GLOBALS['comment'] = $comment;
        switch ($comment->comment_type) :
            case 'pingback' :
            case 'trackback' :
                ?>
                <li id="pingback-comment-<?php comment_ID(); ?>">
                <p class="cmt-pingback"><?php echo esc_html_x('Pingback:', 'front-view', 'camille'); ?><?php comment_author_link(); ?><?php edit_comment_link(esc_html_x('Edit', 'front-view', 'camille'), '<span class="ping-meta"><span class="edit-link">', '</span></span>'); ?></p>
                <?php
                break;
            default :
                // Proceed with normal comments.
                ?>
            <li id="li-comment-<?php echo esc_attr(get_comment_ID()); ?>" <?php comment_class('clearfix'); ?>>
                <div id="comment-<?php echo esc_attr(get_comment_ID()); ?>" class="comment_container clearfix">
                    <?php echo get_avatar($comment, $args['avatar_size']); ?>
                    <div class="comment-text">
                        <div class="description"><?php comment_text(); ?></div>
                        <div class="comment-meta">
                            <div class="comment-author"><?php comment_author_link(); ?></div><?php
                            printf('<time datetime="%1$s">%2$s</time>',
                                get_comment_time('c'),
                                sprintf(esc_html_x('%1$s', '1: date', 'camille'), get_comment_date())
                            );
                            edit_comment_link(esc_html_x('Edit', 'front-view', 'camille'), ' <span class="edit-link">', '</span>'); ?>
                            <?php if ('0' == $comment->comment_approved) : ?>
                                <em class="comment-awaiting-moderation"><?php echo esc_html_x('Your comment is awaiting moderation.', 'front-view', 'camille'); ?></em>
                            <?php endif; ?>
                            <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
                        </div>
                    </div>
                </div>
                <?php
                break;
        endswitch;
    }
}


if(!function_exists('camille_get_favorite_link')){
    function camille_get_favorite_link( $post_id = 0 ){
        if(empty($post_id)){
            $post_id = get_the_ID();
        }
        $lists = Camille()->favorite()->load_favorite_lists();
        $count = Camille()->favorite()->get_total_favorites_for_post( $post_id );
        $class = '';
        if(in_array($post_id, $lists)){
            $class = 'added';
        }
        $svg_icon = '<svg aria-hidden="true" data-prefix="fal" data-icon="thumbs-up" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa"><path fill="currentColor" d="M496.656 285.683C506.583 272.809 512 256 512 235.468c-.001-37.674-32.073-72.571-72.727-72.571h-70.15c8.72-17.368 20.695-38.911 20.695-69.817C389.819 34.672 366.518 0 306.91 0c-29.995 0-41.126 37.918-46.829 67.228-3.407 17.511-6.626 34.052-16.525 43.951C219.986 134.75 184 192 162.382 203.625c-2.189.922-4.986 1.648-8.032 2.223C148.577 197.484 138.931 192 128 192H32c-17.673 0-32 14.327-32 32v256c0 17.673 14.327 32 32 32h96c17.673 0 32-14.327 32-32v-8.74c32.495 0 100.687 40.747 177.455 40.726 5.505.003 37.65.03 41.013 0 59.282.014 92.255-35.887 90.335-89.793 15.127-17.727 22.539-43.337 18.225-67.105 12.456-19.526 15.126-47.07 9.628-69.405zM32 480V224h96v256H32zm424.017-203.648C472 288 472 336 450.41 347.017c13.522 22.76 1.352 53.216-15.015 61.996 8.293 52.54-18.961 70.606-57.212 70.974-3.312.03-37.247 0-40.727 0-72.929 0-134.742-40.727-177.455-40.727V235.625c37.708 0 72.305-67.939 106.183-101.818 30.545-30.545 20.363-81.454 40.727-101.817 50.909 0 50.909 35.517 50.909 61.091 0 42.189-30.545 61.09-30.545 101.817h111.999c22.73 0 40.627 20.364 40.727 40.727.099 20.363-8.001 36.375-23.984 40.727zM104 432c0 13.255-10.745 24-24 24s-24-10.745-24-24 10.745-24 24-24 24 10.745 24 24z"></path></svg>';
        printf(
            '<div class="la-favorite-link"><a class="%1$s" href="javascript:;" rel="nofollow" data-favorite_id="%2$s"><i class="fa fa-thumbs-up">%4$s</i><span class="favorite_count">%3$s</span></a></div>',
            esc_attr($class),
            esc_attr($post_id),
            ($count ? esc_html($count) : ''),
            $svg_icon
        );
    }
}


if(!function_exists('camille_get_wishlist_url')){
    function camille_get_wishlist_url(){
        $wishlist_page_id = Camille()->settings()->get('wishlist_page', 0);
        return (!empty($wishlist_page_id) ? get_the_permalink($wishlist_page_id) : home_url('/'));
    }
}

if(!function_exists('camille_get_compare_url')){
    function camille_get_compare_url(){
        $compare_page_id = Camille()->settings()->get('compare_page', 0);
        return (!empty($compare_page_id) ? get_the_permalink($compare_page_id) : home_url('/'));
    }
}

if(!function_exists('camille_get_wc_attribute_for_compare')){
    function camille_get_wc_attribute_for_compare(){
        return array(
            'image'         => __( 'Image', 'camille' ),
            'title'         => __( 'Title', 'camille' ),
            'add-to-cart'   => __( 'Add to cart', 'camille' ),
            'price'         => __( 'Price', 'camille' ),
            'sku'           => __( 'Sku', 'camille' ),
            'description'   => __( 'Description', 'camille' ),
            'stock'         => __( 'Availability', 'camille' ),
            'weight'        => __( 'Weight', 'camille' ),
            'dimensions'    => __( 'Dimensions', 'camille' )
        );
    }
}

if(!function_exists('camille_get_wc_attribute_taxonomies')){
    function camille_get_wc_attribute_taxonomies( ){

        $attributes = array();

        if( function_exists( 'wc_get_attribute_taxonomies' ) && function_exists( 'wc_attribute_taxonomy_name' ) ) {
            $attribute_taxonomies = wc_get_attribute_taxonomies();
            if(!empty($attribute_taxonomies)){
                foreach( $attribute_taxonomies as $attribute ) {
                    $tax = wc_attribute_taxonomy_name( $attribute->attribute_name );
                    $attributes[$tax] = ucfirst( $attribute->attribute_name );
                }
            }
        }

        return $attributes;
    }
}

if(!function_exists('camille_protected_token_key')){
    function camille_protected_token_key( $key = '', $decode = false ) {
        $newkey = '';
        if(!empty($key)){
            $tmp = explode('.', $key);
            $tmp2 = array();
            foreach($tmp as $str){
                $_lg = strlen($str);
                if($_lg > 5){
                    $f_str = substr($str, 0, 3);
                    $e_str = substr($str, $_lg - 3);
                    $m_str = substr($str, 3, $_lg - 6);
                    if(!empty($m_str)){
                        $m_str = strrev($m_str);
                    }
                    if($decode){
                        $tmp2[] = strrev($f_str) . $m_str . strrev($e_str);
                    }
                    else{
                        $tmp2[] = strrev($e_str) . $m_str . strrev($f_str);
                    }
                }
                else{
                    $tmp2[] = $_lg > 0 ? strrev($str) : $str;
                }
            }
            $newkey = implode('.', $tmp2);
        }
        return $newkey;
    }
}