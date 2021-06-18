<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$footer_layout = Camille()->layout()->get_footer_layout();
$number_col = absint(substr(ltrim($footer_layout),0,1));

$footer_copyright = Camille()->settings()->get('footer_copyright');

$class_column_mapping = array(
    '1col' => array(
        'col-xs-12'
    ),
    '2col48' => array(
        'col-xs-12 col-sm-4',
        'col-xs-12 col-sm-8'
    ),
    '2col66' => array(
        'col-xs-12 col-sm-6',
        'col-xs-12 col-sm-6'
    ),
    '3col444' => array(
        'col-xs-12 col-sm-6 col-md-4',
        'col-xs-12 col-sm-6 col-md-4',
        'col-xs-12 col-sm-6 col-md-4'
    ),
    '3col363' => array(
        'col-xs-12 col-sm-3 col-md-3',
        'col-xs-12 col-sm-6 col-md-6',
        'col-xs-12 col-sm-3 col-md-3'
    ),
    '4col3333' => array(
        'col-xs-12 col-sm-6 col-md-3',
        'col-xs-12 col-sm-6 col-md-3',
        'col-xs-12 col-sm-6 col-md-3',
        'col-xs-12 col-sm-6 col-md-3'
    ),
    '5col32223' => array(
        'col-xs-12 col-sm-6 col-md-3',
        'col-xs-12 col-sm-3 col-md-2',
        'col-xs-12 col-sm-3 col-md-2',
        'col-xs-12 col-sm-6 col-md-2 hidden-sm',
        'col-xs-12 col-sm-6 col-md-3 hidden-sm'
    )
);

if($number_col < 1) $number_col = 1;
?>
<footer id="colophon" class="site-footer la-footer-<?php echo esc_attr($footer_layout)?>">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <?php
                for ( $i = 1; $i <= $number_col; $i++ ){
                    echo '<div class="footer-column footer-column-'.esc_attr($i).' ' . esc_attr($class_column_mapping[$footer_layout][$i-1]). '"><div class="footer-column-inner">';
                    dynamic_sidebar( apply_filters('camille/filter/footer_column_'. $i, 'f-col-'. $i, $footer_layout));
                    echo '</div></div>';
                }
                ?>
            </div>
        </div>
    </div>
    <?php if(Camille()->settings()->get('enable_footer_copyright','no') == 'yes' && !empty($footer_copyright)): ?>
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-inner">
                    <?php echo Camille_Helper::remove_js_autop( $footer_copyright );?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</footer>
<!-- #colophon -->