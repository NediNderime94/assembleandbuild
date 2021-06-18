<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

?>

<?php
/**
 * woocommerce_before_single_product hook.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form();
	return;
}

$product_design = Camille()->settings()->get('woocommerce_product_page_design', 1);
$site_layout = Camille()->layout()->get_site_layout();
$cssclass_left = 'col-xs-12 col-sm-6 col-md-5 p-left product-main-image';
$cssclass_right = 'col-xs-12 col-sm-6 col-md-7 p-right product--summary';

if($product_design == 2){
	$cssclass_left = 'col-xs-12 col-sm-6 col-md-6 p-left product-main-image';
	$cssclass_right = 'col-xs-12 col-sm-6 col-md-6 p-right product--summary';
}

$class = 'la-p-single-wrap la-p-single-'. $product_design;

?>

<div id="product-<?php the_ID(); ?>" <?php function_exists('wc_product_class') ? wc_product_class( $class, $product ) : post_class($class); ?>>

	<div class="row la-single-product-page vc_row"<?php if($site_layout == 'col-1c'): ?> data-vc-full-width="true" data-vc-stretch-content="false"<?php endif;?>>
		<div class="<?php echo esc_attr($cssclass_left) ?>">
			<div class="p---large">
				<?php
				/**
				 * woocommerce_before_single_product_summary hook.
				 *
				 * @hooked woocommerce_show_product_sale_flash - 10
				 * @hooked woocommerce_show_product_images - 20
				 */
				do_action( 'woocommerce_before_single_product_summary' );

				?>
			</div>
		</div><!-- .product--images -->
		<div class="<?php echo esc_attr($cssclass_right) ?>">
			<div class="la-custom-pright">
				<div class="summary entry-summary">

					<?php
					/**
					 * woocommerce_single_product_summary hook.
					 *
					 * @hooked woocommerce_template_single_title - 5
					 * @hooked woocommerce_template_single_rating - 10
					 * @hooked woocommerce_template_single_price - 10
					 * @hooked woocommerce_template_single_excerpt - 20
					 * @hooked woocommerce_template_single_add_to_cart - 30
					 * @hooked woocommerce_template_single_meta - 50
					 */
					do_action( 'woocommerce_single_product_summary' );
					?>
				</div>

				<?php woocommerce_template_single_sharing(); ?>

			</div>
		</div><!-- .product-summary -->
	</div>
	<?php if($site_layout == 'col-1c'): ?>
		<div class="vc_row-full-width vc_clearfix"></div>
	<?php endif;?>
	<div class="row">
		<div class="col-xs-12">
			<?php
			/**
			 * woocommerce_after_single_product_summary hook.
			 *
			 * @hooked woocommerce_output_product_data_tabs - 10
			 * @hooked woocommerce_upsell_display - 15
			 * @hooked woocommerce_output_related_products - 20
			 */
			do_action( 'woocommerce_after_single_product_summary' );
			?>
		</div>
	</div>

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
