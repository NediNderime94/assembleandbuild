.site-loading .la-image-loading {
    opacity: 1;
    visibility: visible
}
.la-image-loading.spinner-custom .content {
    width: 100px;
    margin-top: -50px;
    height: 100px;
    margin-left: -50px;
    text-align: center
}
.la-image-loading.spinner-custom .content img {
    width: auto;
    margin: 0 auto
}
.site-loading #page.site {
    opacity: 0;
    transition: all .3s ease-in-out
}
#page.site {
    opacity: 1
}
.la-image-loading {
    opacity: 0;
    position: fixed;
    z-index: 999999;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    background: #fff;
    overflow: hidden;
    transition: all .3s ease-in-out;
    -webkit-transition: all .3s ease-in-out;
    visibility: hidden;
}
.la-image-loading .content {
    position: absolute;
    width: 50px;
    height: 50px;
    top: 50%;
    left: 50%;
    margin-left: -25px;
    margin-top: -25px;
}
.la-loader.spinner1 {
    width: 40px;
    height: 40px;
    margin: 5px;
    display: block;
    box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.15);
    -webkit-box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.15);
    -webkit-animation: la-rotateplane 1.2s infinite ease-in-out;
    animation: la-rotateplane 1.2s infinite ease-in-out;
    border-radius: 3px;
    -moz-border-radius: 3px;
    -webkit-border-radius: 3px;
}
.la-loader.spinner2 {
    width: 40px;
    height: 40px;
    margin: 5px;
    box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.15);
    -webkit-box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.15);
    border-radius: 100%;
    -webkit-animation: la-scaleout 1.0s infinite ease-in-out;
    animation: la-scaleout 1.0s infinite ease-in-out;
}
.la-loader.spinner3 {
    margin: 15px 0 0 -10px;
    width: 70px;
    text-align: center;
}
.la-loader.spinner3 [class*="bounce"] {
    width: 18px;
    height: 18px;
    box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.15);
    -webkit-box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.15);
    border-radius: 100%;
    display: inline-block;
    -webkit-animation: la-bouncedelay 1.4s infinite ease-in-out;
    animation: la-bouncedelay 1.4s infinite ease-in-out;
    -webkit-animation-fill-mode: both;
    animation-fill-mode: both;
}
.la-loader.spinner3 .bounce1 {
    -webkit-animation-delay: -.32s;
    animation-delay: -.32s;
}
.la-loader.spinner3 .bounce2 {
    -webkit-animation-delay: -.16s;
    animation-delay: -.16s;
}
.la-loader.spinner4 {
    margin: 5px;
    width: 40px;
    height: 40px;
    text-align: center;
    -webkit-animation: la-rotate 2.0s infinite linear;
    animation: la-rotate 2.0s infinite linear;
}
.la-loader.spinner4 [class*="dot"] {
    width: 60%;
    height: 60%;
    display: inline-block;
    position: absolute;
    top: 0;
    border-radius: 100%;
    -webkit-animation: la-bounce 2.0s infinite ease-in-out;
    animation: la-bounce 2.0s infinite ease-in-out;
    box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.15);
    -webkit-box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.15);
}
.la-loader.spinner4 .dot2 {
    top: auto;
    bottom: 0;
    -webkit-animation-delay: -1.0s;
    animation-delay: -1.0s;
}
.la-loader.spinner5 {
    margin: 5px;
    width: 40px;
    height: 40px;
}
.la-loader.spinner5 div {
    width: 33%;
    height: 33%;
    float: left;
    -webkit-animation: la-cubeGridScaleDelay 1.3s infinite ease-in-out;
    animation: la-cubeGridScaleDelay 1.3s infinite ease-in-out;
}
.la-loader.spinner5 div:nth-child(1), .la-loader.spinner5 div:nth-child(5), .la-loader.spinner5 div:nth-child(9) {
    -webkit-animation-delay: .2s;
    animation-delay: .2s;
}
.la-loader.spinner5 div:nth-child(2), .la-loader.spinner5 div:nth-child(6) {
    -webkit-animation-delay: .3s;
    animation-delay: .3s;
}
.la-loader.spinner5 div:nth-child(3) {
    -webkit-animation-delay: .4s;
    animation-delay: .4s;
}
.la-loader.spinner5 div:nth-child(4), .la-loader.spinner5 div:nth-child(8) {
    -webkit-animation-delay: .1s;
    animation-delay: .1s;
}
.la-loader.spinner5 div:nth-child(7) {
    -webkit-animation-delay: 0s;
    animation-delay: 0s;
}
@-webkit-keyframes la-rotateplane {
    0% {
        -webkit-transform: perspective(120px);
    }
    50% {
        -webkit-transform: perspective(120px) rotateY(180deg);
    }
    100% {
        -webkit-transform: perspective(120px) rotateY(180deg) rotateX(180deg);
    }
}
@keyframes la-rotateplane {
    0% {
        transform: perspective(120px) rotateX(0deg) rotateY(0deg);
    }
    50% {
        transform: perspective(120px) rotateX(-180.1deg) rotateY(0deg);
    }
    100% {
        transform: perspective(120px) rotateX(-180deg) rotateY(-179.9deg);
    }
}
@-webkit-keyframes la-scaleout {
    0% {
        -webkit-transform: scale(0);
    }
    100% {
        -webkit-transform: scale(1);
        opacity: 0;
    }
}
@keyframes la-scaleout {
    0% {
        transform: scale(0);
        -webkit-transform: scale(0);
    }
    100% {
        transform: scale(1);
        -webkit-transform: scale(1);
        opacity: 0;
    }
}
@-webkit-keyframes la-bouncedelay {
    0%, 80%, 100% {
        -webkit-transform: scale(0);
    }
    40% {
        -webkit-transform: scale(1);
    }
}
@keyframes la-bouncedelay {
    0%, 80%, 100% {
        transform: scale(0);
    }
    40% {
        transform: scale(1);
    }
}
@-webkit-keyframes la-rotate {
    100% {
        -webkit-transform: rotate(360deg);
    }
}
@keyframes la-rotate {
    100% {
        transform: rotate(360deg);
        -webkit-transform: rotate(360deg);
    }
}

@-webkit-keyframes la-bounce {
    0%, 100% {
        -webkit-transform: scale(0);
    }
    50% {
        -webkit-transform: scale(1);
    }
}

@keyframes la-bounce {
    0%, 100% {
        transform: scale(0);
    }
    50% {
        transform: scale(1);
    }
}

@-webkit-keyframes la-cubeGridScaleDelay {
    0% {
        -webkit-transform: scale3d(1, 1, 1);
    }
    35% {
        -webkit-transform: scale3d(0, 0, 1);
    }
    70% {
        -webkit-transform: scale3d(1, 1, 1);
    }
    100% {
        -webkit-transform: scale3d(1, 1, 1);
    }
}

@keyframes la-cubeGridScaleDelay {
    0% {
        transform: scale3d(1, 1, 1);
    }
    35% {
        transform: scale3d(0, 0, 1);
    }
    70% {
        transform: scale3d(1, 1, 1);
    }
    100% {
        transform: scale3d(1, 1, 1);
    }
}

.la-loader.spinner1, .la-loader.spinner2, .la-loader.spinner3 [class*="bounce"], .la-loader.spinner4 [class*="dot"], .la-loader.spinner5 div{
    background-color: <?php echo esc_attr( Camille()->settings()->get("primary_color","#35d56a") ) ?>;
}

<?php
$current_context = Camille()->get_current_context();

$page_title_bar_func = 'get';
if(Camille()->settings()->get_setting_by_context('page_title_bar_style', 'no') == 'yes'){
    $page_title_bar_func = 'get_setting_by_context';
}

$page_title_font_size = Camille()->settings()->get_setting_by_context('page_title_font_size', Camille()->settings()->get('page_title_font_size'));

if(function_exists('wc') && (is_shop() || is_product() || is_product_taxonomy())){
    if( 'on' == Camille()->settings()->get('woo_override_page_title_bar', 'off') ) {
        $page_title_bar_func = 'get_setting_by_context';
    }
}

$page_title_bar_bg = Camille()->settings()->$page_title_bar_func('page_title_bar_background');
$page_title_bar_heading_color = Camille()->settings()->$page_title_bar_func('page_title_bar_heading_color', '#252634');
$page_title_bar_text_color = Camille()->settings()->$page_title_bar_func('page_title_bar_text_color', '#8a8a8a');
$page_title_bar_link_color = Camille()->settings()->$page_title_bar_func('page_title_bar_link_color', '#8a8a8a');
$page_title_bar_link_hover_color = Camille()->settings()->$page_title_bar_func('page_title_bar_link_hover_color', '#343538');
$page_title_bar_spacing = Camille()->settings()->$page_title_bar_func('page_title_bar_spacing');
$page_title_bar_spacing_tablet = Camille()->settings()->$page_title_bar_func('page_title_bar_spacing_tablet');
$page_title_bar_spacing_mobile = Camille()->settings()->$page_title_bar_func('page_title_bar_spacing_mobile');

$page_title_bar_bg = shortcode_atts(array(
    'image' => '',
    'repeat' => 'repeat',
    'position' => 'left top',
    'attachment' => 'scroll',
    'size' => '',
    'color' => ''
), $page_title_bar_bg);


$page_title_bar_spacing = shortcode_atts(array(
    'bottom' => 25,
    'top'    => 25
), $page_title_bar_spacing );

$page_title_bar_spacing_tablet = shortcode_atts(array(
    'bottom' => 25,
    'top'    => 25
), $page_title_bar_spacing_tablet );

$page_title_bar_spacing_mobile = shortcode_atts(array(
    'bottom' => 25,
    'top'    => 25
), $page_title_bar_spacing_mobile );

?>
.section-page-header{
    color: <?php echo esc_attr($page_title_bar_text_color); ?>;
    <?php Camille_Helper::render_background_atts($page_title_bar_bg);?>
}
.section-page-header .page-title{
    color: <?php echo esc_attr($page_title_bar_heading_color); ?>;
<?php
if(!empty($page_title_font_size['lg'])){
    printf('font-size: %s', esc_attr($page_title_font_size['lg']));
}
?>
}
.section-page-header a{
    color: <?php echo esc_attr($page_title_bar_link_color); ?>;
}
.section-page-header a:hover{
    color: <?php echo esc_attr($page_title_bar_link_hover_color); ?>;
}
.section-page-header .page-header-inner{
    padding-top: <?php echo absint($page_title_bar_spacing_mobile['top']) ?>px;
    padding-bottom: <?php echo absint($page_title_bar_spacing_mobile['bottom']) ?>px;
}
@media(min-width: 768px){
    .section-page-header .page-header-inner{
        padding-top: <?php echo absint($page_title_bar_spacing_tablet['top']) ?>px;
        padding-bottom: <?php echo absint($page_title_bar_spacing_tablet['bottom']) ?>px;
    }
}
@media(min-width: 992px){
    .section-page-header .page-header-inner{
        padding-top: <?php echo absint($page_title_bar_spacing['top']) ?>px;
        padding-bottom: <?php echo absint($page_title_bar_spacing['bottom']) ?>px;
    }
}

<?php
if(!empty($page_title_font_size['xlg'])){
    printf('@media screen and (min-width:1824px){.section-page-header .page-title{font-size: %s}}', esc_attr($page_title_font_size['xlg']));
}
if(!empty($page_title_font_size['md'])){
    printf('@media screen and (max-width:1199px){.section-page-header .page-title{font-size: %s}}', esc_attr($page_title_font_size['md']));
}
if(!empty($page_title_font_size['sm'])){
    printf('@media screen and (max-width:991px){.section-page-header .page-title{font-size: %s}}', esc_attr($page_title_font_size['sm']));
}
if(!empty($page_title_font_size['xs'])){
    printf('@media screen and (max-width:767px){.section-page-header .page-title{font-size: %s}}', esc_attr($page_title_font_size['xs']));
}
if(!empty($page_title_font_size['mb'])){
    printf('@media screen and (max-width:479px){.section-page-header .page-title{font-size: %s}}', esc_attr($page_title_font_size['mb']));
}
?>


<?php
$main_space = Camille()->settings()->get_setting_by_context('main_space');
if(!empty($main_space) && is_array($main_space)){
$main_space = shortcode_atts(array(
    'top' => '',
    'bottom' => ''
), $main_space);
echo '.site-main{';

if($main_space['top'] != ''){
    echo  'padding-top:' . absint($main_space['top']) . 'px;';
}
if($main_space['bottom'] != ''){
    echo  'padding-bottom:' . absint($main_space['bottom']) . 'px';
}
echo '}';
echo '.single-product .site-main{';
    if($main_space['top'] != ''){
        echo  'padding-top:' . absint($main_space['top']) . 'px;';
    }
    echo '}';
}

$font_source = Camille()->settings()->get('font_source', 1);

$body_font_family = '';
$heading_font_family = '';
$highlight_font_family = '';

switch ($font_source) {
    case '1':
    $_s_main_font = (array) Camille()->settings()->get('main_font');
    $_s_secondary_font = (array) Camille()->settings()->get('secondary_font');
    $_s_highlight_font = (array) Camille()->settings()->get('highlight_font');

    if(!empty($_s_main_font['family'])){
        $body_font_family = '"' . $_s_main_font['family'] . '", "Helvetica Neue", Arial, sans-serif';
    }
    if(!empty($_s_secondary_font['family'])){
        $heading_font_family = '"' . $_s_secondary_font['family'] . '", "Helvetica Neue", Arial, sans-serif';
    }
    if(!empty($_s_highlight_font['family'])){
        $highlight_font_family = '"' . $_s_highlight_font['family'] . '", "Helvetica Neue", Arial, sans-serif';
        if($_s_highlight_font['family'] == 'Playfair Display'){
            $highlight_font_family .= '; font-style: italic';
        }
    }

    break;

    case '2':
    $body_font_family = Camille()->settings()->get('main_google_font_face');
    $heading_font_family = Camille()->settings()->get('secondary_google_font_face');
    $highlight_font_family = Camille()->settings()->get('highlight_google_font_face');
    break;

    case '3':
    $body_font_family = Camille()->settings()->get('main_typekit_font_face');
    $heading_font_family = Camille()->settings()->get('secondary_typekit_font_face');
    $highlight_font_family = Camille()->settings()->get('highlight_typekit_font_face');
    break;
}

$body_background = shortcode_atts(array(
    'image' => '',
    'repeat' => 'repeat',
    'position' => 'left top',
    'attachment' => 'scroll',
    'size' => '',
    'color' => '#fff'
), Camille()->settings()->get('body_background'));

$header_background = shortcode_atts(array(
    'image' => '',
    'repeat' => 'repeat',
    'position' => 'left top',
    'attachment' => 'scroll',
    'size' => '',
    'color' => '#fff'
), Camille()->settings()->get('header_background'));

$transparency_header_background = shortcode_atts(array(
    'image' => '',
    'repeat' => 'repeat',
    'position' => 'left top',
    'attachment' => 'scroll',
    'size' => '',
    'color' => 'rgba(0,0,0,0)'
), Camille()->settings()->get('transparency_header_background'));

$footer_background = shortcode_atts(array(
    'image' => '',
    'repeat' => 'repeat',
    'position' => 'left top',
    'attachment' => 'scroll',
    'size' => '',
    'color' => '#fff'
), Camille()->settings()->get('footer_background'));

$body_boxed = Camille()->settings()->get('body_boxed', 'no');
$body_boxed_background = shortcode_atts(array(
    'image' => '',
    'repeat' => 'repeat',
    'position' => 'left top',
    'attachment' => 'scroll',
    'size' => '',
    'color' => ''
), Camille()->settings()->get('body_boxed_background'));

$body_font_size = Camille()->settings()->get('body_font_size', 16);
$body_font_size = str_replace('px', '', $body_font_size);
$body_max_width = Camille()->settings()->get('body_max_width', 1230);
$body_max_width = str_replace('px', '', $body_max_width);
?>
body.camille-body{
    font-size: <?php echo esc_attr($body_font_size) ?>px;
    <?php Camille_Helper::render_background_atts($body_background);?>
}
body.camille-body.body-boxed #page.site{
    width: <?php echo esc_attr($body_max_width) ?>px;
    max-width: 100%;
    margin-left: auto;
    margin-right: auto;
    <?php Camille_Helper::render_background_atts($body_boxed_background);?>
}
body.camille-body.body-boxed .site-header .site-header-inner > .container{
    width: <?php echo esc_attr($body_max_width) ?>px;
}
#masthead_aside,
.site-header .site-header-inner{
    <?php Camille_Helper::render_background_atts($header_background);?>
}
.enable-header-transparency .site-header:not(.is-sticky) .site-header-inner{
    <?php Camille_Helper::render_background_atts($transparency_header_background);?>
}

.footer-top{
    <?php Camille_Helper::render_background_atts($footer_background);?>
    <?php Camille_Helper::render_canvas_space(Camille()->settings()->get('footer_space'));?>
}
<?php

$popup_background =  shortcode_atts(array(
    'image' => '',
    'repeat' => 'repeat',
    'position' => 'left top',
    'attachment' => 'scroll',
    'size' => '',
    'color' => ''
), Camille()->settings()->get('popup_background'));

?>
.open-newsletter-popup .lightcase-inlineWrap{
    <?php Camille_Helper::render_background_atts($popup_background);?>
}

<?php if( Camille()->settings()->get('catalog_mode', 'off') == 'on'){
    if( Camille()->settings()->get('catalog_mode_price', 'off') == 'on'){
        ?>
        .woocommerce .product-price,
        .woocommerce span.price,
        .woocommerce div.price,
        .woocommerce p.price{
            display: none !important;
        }
        <?php
    }
}
?>

<?php
$normal_header_height = str_replace('px', '', Camille()->settings()->get('header_height', 100));
$sticky_header_height = str_replace('px', '', Camille()->settings()->get('header_sticky_height', 80));

$header_sm_height = str_replace('px', '', Camille()->settings()->get('header_sm_height', 100));
$header_sm_sticky_height = str_replace('px', '', Camille()->settings()->get('header_sm_sticky_height', 80));

$header_mb_height = str_replace('px', '', Camille()->settings()->get('header_mb_height', 70));
$header_mb_sticky_height = str_replace('px', '', Camille()->settings()->get('header_mb_sticky_height', 70));


?>


/****************************************** Header Height ******************************************/

.site-header .site-branding a{
    height: <?php echo esc_attr($normal_header_height) ?>px;
    line-height: <?php echo esc_attr($normal_header_height) ?>px;
}
.site-header .header-component-inner{
    padding-top: <?php echo esc_attr(($normal_header_height-40)/2) ?>px;
    padding-bottom: <?php echo esc_attr(($normal_header_height-40)/2) ?>px;
}

.site-header .header-main .la_com_action--dropdownmenu .menu,
.site-header .mega-menu > li > .popup{
    margin-top: <?php echo esc_attr((($normal_header_height-40)/2) + 20) ?>px;
}
.site-header .header-main .la_com_action--dropdownmenu:hover .menu,
.site-header .mega-menu > li:hover > .popup{
    margin-top: <?php echo esc_attr((($normal_header_height-40)/2)) ?>px;
}

.site-header.is-sticky .site-branding a{
    height: <?php echo esc_attr($sticky_header_height) ?>px;
    line-height: <?php echo esc_attr($sticky_header_height) ?>px;
}
.site-header.is-sticky .header-component-inner{
    padding-top: <?php echo esc_attr(($sticky_header_height-40)/2) ?>px;
    padding-bottom: <?php echo esc_attr(($sticky_header_height-40)/2) ?>px;
}
.site-header.is-sticky .header-main .la_com_action--dropdownmenu .menu,
.site-header.is-sticky .mega-menu > li > .popup{
    margin-top: <?php echo esc_attr((($sticky_header_height-40)/2) + 20) ?>px;
}
.site-header.is-sticky .header-main .la_com_action--dropdownmenu:hover .menu,
.site-header.is-sticky .mega-menu > li:hover > .popup{
    margin-top: <?php echo esc_attr((($sticky_header_height-40)/2)) ?>px;
}

/****************************************** ./Header Height ******************************************/


/****************************************** Small Desktop Header Height ******************************************/

@media(max-width: 1300px) and (min-width: 992px){
    .site-header .site-branding a{
        height: <?php echo esc_attr($header_sm_height) ?>px;
        line-height: <?php echo esc_attr($header_sm_height) ?>px;
    }
    .site-header .header-component-inner{
        padding-top: <?php echo esc_attr(($header_sm_height-40)/2) ?>px;
        padding-bottom: <?php echo esc_attr(($header_sm_height-40)/2) ?>px;
    }

    .site-header .header-main .la_com_action--dropdownmenu .menu,
    .site-header .mega-menu > li > .popup{
        margin-top: <?php echo esc_attr((($header_sm_height-40)/2) + 20) ?>px;
    }
    .site-header .header-main .la_com_action--dropdownmenu:hover .menu,
    .site-header .mega-menu > li:hover > .popup{
        margin-top: <?php echo esc_attr((($header_sm_height-40)/2)) ?>px;
    }

    .site-header.is-sticky .site-branding a{
        height: <?php echo esc_attr($header_sm_sticky_height) ?>px;
        line-height: <?php echo esc_attr($header_sm_sticky_height) ?>px;
    }
    .site-header.is-sticky .header-component-inner{
        padding-top: <?php echo esc_attr(($header_sm_sticky_height-40)/2) ?>px;
        padding-bottom: <?php echo esc_attr(($header_sm_sticky_height-40)/2) ?>px;
    }
    .site-header.is-sticky .header-main .la_com_action--dropdownmenu .menu,
    .site-header.is-sticky .mega-menu > li > .popup{
        margin-top: <?php echo esc_attr((($header_sm_sticky_height-40)/2) + 20) ?>px;
    }
    .site-header.is-sticky .header-main .la_com_action--dropdownmenu:hover .menu,
    .site-header.is-sticky .mega-menu > li:hover > .popup{
        margin-top: <?php echo esc_attr((($header_sm_sticky_height-40)/2)) ?>px;
    }
}

/****************************************** ./Small Desktop Header Height ******************************************/


/****************************************** ./Mobile Header Height ******************************************/
@media(max-width: 991px){

    .site-header-mobile .site-branding a{
        height: <?php echo esc_attr($header_mb_height) ?>px;
        line-height: <?php echo esc_attr($header_mb_height) ?>px;
    }
    .site-header-mobile .header-component-inner{
        padding-top: <?php echo esc_attr(($header_mb_height-40)/2) ?>px;
        padding-bottom: <?php echo esc_attr(($header_mb_height-40)/2) ?>px;
    }

    .site-header-mobile.is-sticky .site-branding a{
        height: <?php echo esc_attr($header_mb_sticky_height) ?>px;
        line-height: <?php echo esc_attr($header_mb_sticky_height) ?>px;
    }
    .site-header-mobile.is-sticky .header-component-inner{
        padding-top: <?php echo esc_attr(($header_mb_sticky_height-40)/2) ?>px;
        padding-bottom: <?php echo esc_attr(($header_mb_sticky_height-40)/2) ?>px;
    }
}
/****************************************** ./Mobile Header Height ******************************************/

.header-v6 #header_aside,
.header-v5 #masthead_aside{
<?php Camille_Helper::render_background_atts($header_background);?>
}
.header-v6.enable-header-transparency #header_aside,
.header-v5.enable-header-transparency #masthead_aside{
<?php Camille_Helper::render_background_atts($transparency_header_background);?>
}

<?php
$logo_height = str_replace('px', '', Camille()->settings()->get('logo_height', ''));
$logo_mobile_height = str_replace('px', '', Camille()->settings()->get('logo_mobile_height', ''));
?>
<?php if(!empty($logo_height)): ?>
.site-header .site-branding img{
    width: <?php echo esc_attr($logo_height) ?>px;
}
<?php endif;?>

<?php if(!empty($logo_mobile_height)): ?>
.site-header-mobile .site-branding img{
    width: <?php echo esc_attr($logo_mobile_height) ?>px;
}
<?php endif;?>