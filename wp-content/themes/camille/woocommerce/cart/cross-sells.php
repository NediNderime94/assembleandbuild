<?php
/**
 * Cross-sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cross-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if(Camille()->settings()->get('crosssell_products', 'off') != 'on'){
	return;
}


if ( $cross_sells ) : ?>
<?php

	global $post;

	$product_cols = shortcode_atts(
		array('xlg'=> 1, 'lg'=> 1,'md'=> 1,'sm'=> 1,'xs'=> 1, 'mb' => 1),
		Camille()->settings()->get('crosssell_products_columns')
	);
	$design 		= Camille()->settings()->get('shop_catalog_grid_style', '1');
	$loopCssClass 	= array('products','grid-items', 'la-slick-slider js-el');
	$loopCssClass[] = 'products-grid';
	$loopCssClass[] = 'grid-space-default';
	$loopCssClass[] = 'products-grid-' . $design;
	$slide_configs 	= Camille_Helper::get_slick_slider_config(array_merge(array('arrows' => true), $product_cols));

	$title = Camille()->settings()->get('crosssell_product_title') ? Camille()->settings()->get('crosssell_product_title') : _x( 'You may be interested in&hellip;', 'front-view', 'camille' );
	$sub_title = Camille()->settings()->get('crosssell_product_subtitle') ? Camille()->settings()->get('crosssell_product_subtitle') : '';

?>
<div class="custom-product-wrap cross-sells">
	<div class="custom-product-ul">
		<div class="row block_heading">
			<div class="col-xs-12">
				<h2 class="block_heading--title"><span><?php echo esc_html($title); ?></span></h2>
				<?php if(!empty($sub_title)): ?><div class="block_heading--subtitle"><?php echo esc_html($sub_title); ?></div><?php endif; ?>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<ul class="<?php echo esc_attr(implode(' ', $loopCssClass)) ?>" data-la_component="AutoCarousel" data-slider_config="<?php echo esc_attr($slide_configs)?>">
					<?php foreach ( $cross_sells as $cross_sell ) : ?>

						<?php
						$post_object = get_post( $cross_sell->get_id() );

						$post = $post_object;
						setup_postdata($post);

						wc_get_template_part( 'content', 'product' ); ?>

					<?php endforeach; ?>

				</ul>
			</div>
		</div>
	</div>
</div>

<?php endif;

wp_reset_postdata();