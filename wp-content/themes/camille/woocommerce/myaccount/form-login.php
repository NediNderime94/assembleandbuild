<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php wc_print_notices(); ?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>
<div class="la-myaccount-page">
	<div class="la-tabs" id="la_tabs_customer_login">
		<ul class="la_tab_control">
			<li><a href="#la_tab--login"><?php echo esc_html_x( 'Login', 'front-view', 'camille' ); ?></a></li>
			<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
			<li><a href="#la_tab--register"><?php echo esc_html_x( 'Register', 'front-view', 'camille' ); ?></a></li>
			<?php endif; ?>
		</ul>
		<div id="la_tab--login" class="la-tab-panel">
			<form class="woocomerce-form woocommerce-form-login login" method="post">

				<?php do_action( 'woocommerce_login_form_start' ); ?>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="username"><?php echo esc_html_x( 'Username or email address', 'front-view', 'camille' ); ?> <span class="required">*</span></label>
					<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
				</p>
				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="password"><?php echo esc_html_x( 'Password', 'front-view', 'camille' ); ?> <span class="required">*</span></label>
					<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" />
				</p>

				<?php do_action( 'woocommerce_login_form' ); ?>

				<p class="form-row">
					<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
					<input type="submit" class="woocommerce-Button button" name="login" value="<?php echo esc_attr_x( 'Login', 'front-view', 'camille' ); ?>" />
				</p>
				<div class="form-row la-checkbox">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" />
					<label for="rememberme" class="woocommerce-form__label woocommerce-form__label-for-checkbox inline"><span><?php echo esc_html_x( 'Remember me', 'front-view', 'camille' ); ?></span></label>
					<div class="woocommerce-LostPassword lost_password">
						<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php echo esc_html_x( 'Lost your password?', 'front-view', 'camille' ); ?></a>
					</div>
				</div>
				<?php do_action( 'woocommerce_login_form_end' ); ?>
				<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
				<p class="form-row">
					<label><?php echo esc_html_x("You don't have account ?", 'front-view', 'camille') ?></label>
					<a class="btn-create-account" href="#la_tab--register"><?php echo esc_html_x('Create account now', 'front-view', 'camille') ?></a>
				</p>
				<?php endif; ?>
			</form>
		</div>
	<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

		<div id="la_tab--register" class="la-tab-panel">

			<form method="post" class="register">

				<?php do_action( 'woocommerce_register_form_start' ); ?>

				<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<label for="reg_username"><?php echo esc_html_x( 'Username', 'front-view', 'camille' ); ?> <span class="required">*</span></label>
						<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
					</p>

				<?php endif; ?>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="reg_email"><?php echo esc_html_x( 'Email address', 'front-view', 'camille' ); ?> <span class="required">*</span></label>
					<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" />
				</p>

				<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<label for="reg_password"><?php echo esc_html_x( 'Password', 'front-view', 'camille' ); ?> <span class="required">*</span></label>
						<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" />
					</p>

				<?php endif; ?>

				<?php do_action( 'woocommerce_register_form' ); ?>

				<p class="woocomerce-FormRow form-row">
					<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
					<input type="submit" class="woocommerce-Button button" name="register" value="<?php echo esc_attr_x( 'Register', 'front-view', 'camille' ); ?>" />
				</p>

				<?php do_action( 'woocommerce_register_form_end' ); ?>

			</form>

		</div>
	<?php endif; ?>
	</div>
</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
