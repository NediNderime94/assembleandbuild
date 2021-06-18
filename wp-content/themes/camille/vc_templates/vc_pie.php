<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $el_class
 * @var $value
 * @var $units
 * @var $color
 * @var $custom_color
 * @var $label_value
 * @var $css
 * Shortcode class
 * @var $this WPBakeryShortCode_Vc_Pie
 */
$title = $el_class = $value = $units = $color = $custom_color = $label_value = $css = '';
$style = '';
$atts = $this->convertOldColorsToNew( $atts );
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$colors = array(
	'blue' => '#5472d2',
	'turquoise' => '#00c1cf',
	'pink' => '#fe6c61',
	'violet' => '#8d6dc4',
	'peacoc' => '#4cadc9',
	'chino' => '#cec2ab',
	'mulled-wine' => '#50485b',
	'vista-blue' => '#75d69c',
	'orange' => '#f7be68',
	'sky' => '#5aa1e3',
	'green' => '#6dab3c',
	'juicy-pink' => '#f4524d',
	'sandy-brown' => '#f79468',
	'purple' => '#b97ebb',
	'black' => '#2a2a2a',
	'grey' => '#ebebeb',
	'white' => '#ffffff',
);

if ( 'custom' === $color ) {
	$color = $custom_color;
} else {
	$color = isset( $colors[ $color ] ) ? $colors[ $color ] : '';
}

if ( ! $color ) {
	$color = $colors['grey'];
}

$class_to_filter = 'la-circle-progress wpb_content_element js-el';
$class_to_filter .= ' la-progress-'. $style;
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );
?>
<div data-la_component="PieChart" data-empty-fill="rgba(0,0,0,1)" data-stroke="5" class="<?php echo esc_attr( $css_class ); ?>" data-pie-value="<?php echo esc_attr( $value ) ?>" data-pie-label-value="<?php echo esc_attr( $label_value ); ?>" data-pie-units="<?php echo esc_attr( $units ) ?>" data-pie-color="<?php echo esc_attr( $color ); ?>">
	<div class="la-circle-wrap">
		<div class="la-circle-wrapper">
			<span class="sc-cp-v"><?php echo esc_attr( $value . $units ) ?></span>
			<?php if($style == 1): ?>
				<span class="sc-cp-t"><?php echo esc_html($label_value) ;?></span>
			<?php endif; ?>
		</div>
		<div class="sc-cp-canvas"></div>
	</div>
	<?php if($style == 2): ?>
		<span class="sc-cp-t"><?php echo esc_html($label_value) ;?></span>
	<?php endif; ?>
</div>