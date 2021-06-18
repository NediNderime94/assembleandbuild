<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/*
 * Template loop-end
 */
global $camille_loop;
$camille_loop = array();
$blog_pagination_type = Camille()->settings()->get('blog_pagination_type', 'pagination');
?>
    </div>
<!-- ./end-main-loop -->
<?php if($blog_pagination_type == 'load_more'): ?>
    <div class="blog-main-loop__btn-loadmore">
        <a href="javascript:;" class="btn btn-color-gray btn-align-center btn-size-md btn-style-outline">
            <span><?php echo esc_html_x('Load more posts', 'front-view', 'camille'); ?></span>
        </a>
    </div>
<?php endif; ?>
