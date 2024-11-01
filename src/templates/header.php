<?php

use Rgbcode\Plugins\Netzero_SM\Classes\Constants;
use Rgbcode\Plugins\Netzero_SM\Classes\Helper;

$helper = Helper::get_instance();
?>

<header class="rgbc-header">
	<nav class="rgbc-header__nav">
		<ul class="rgbc-header__nav-list">
			<li class="rgbc-header__nav-item <?php echo $helper->page_is_active( Constants::ACTION_MAIN ) || ! isset( $_GET['action'] ) ? 'rgbc-header__nav-item_active' : '';// phpcs:ignore WordPress.Security.NonceVerification ?>">
				<a class="rgbc-header__nav-link" href=<?php echo esc_url( $helper->get_page_link( Constants::ACTION_MAIN ) ); ?>><?php esc_html_e( 'Dashboard', 'rgbc_netzero_sm' ); ?></a>
			</li>
			<li class="rgbc-header__nav-item <?php echo $helper->page_is_active( Constants::ACTION_SETTINGS ) ? 'rgbc-header__nav-item_active' : ''; ?>">
				<a class="rgbc-header__nav-link" href="<?php echo esc_url( $helper->get_page_link( Constants::ACTION_SETTINGS ) ); ?>"><?php esc_html_e( 'Settings', 'rgbc_netzero_sm' ); ?></a>
			</li>
			<li class="rgbc-header__nav-item <?php echo $helper->page_is_active( Constants::ACTION_DESIGN ) ? 'rgbc-header__nav-item_active' : ''; ?>">
				<a class="rgbc-header__nav-link" href="<?php echo esc_url( $helper->get_page_link( Constants::ACTION_DESIGN ) ); ?>"><?php esc_html_e( 'Design', 'rgbc_netzero_sm' ); ?></a>
			</li>
			<li class="rgbc-header__nav-item <?php echo $helper->page_is_active( Constants::ACTION_ACCOUNT ) ? 'rgbc-header__nav-item_active' : ''; ?>">
				<a class="rgbc-header__nav-link" href="<?php echo esc_url( $helper->get_page_link( Constants::ACTION_ACCOUNT ) ); ?>"><?php esc_html_e( 'Account', 'rgbc_netzero_sm' ); ?></a>
			</li>
			<li class="rgbc-header__nav-item <?php echo $helper->page_is_active( Constants::ACTION_JOURNEY ) ? 'rgbc-header__nav-item_active' : ''; ?>">
				<a class="rgbc-header__nav-link" href="<?php echo esc_url( $helper->get_page_link( Constants::ACTION_JOURNEY ) ); ?>"><?php esc_html_e( 'My green journey', 'rgbc_netzero_sm' ); ?></a>
			</li>
			<li class="rgbc-header__nav-item <?php echo $helper->page_is_active( Constants::ACTION_START ) ? 'rgbc-header__nav-item_active' : ''; ?>">
				<a class="rgbc-header__nav-link" href="<?php echo esc_url( $helper->get_page_link( Constants::ACTION_START ) ); ?>"><?php esc_html_e( 'Getting started', 'rgbc_netzero_sm' ); ?></a>
			</li>
		</ul>
	</nav>
	<?php if ( ! $helper->email_is_verified() ) { ?>
	<div class="rgbc-header__error">
		<div class="rgbc-error-message"><?php esc_html_e( 'You must verify your email address to enable the Sustainable eCommerce cart.', 'rgbc_netzero_sm' ); ?></div>
	</div>
	<?php } ?>
	<div class="rgbc-header__logo">
		<img class="rgbc-header__logo-image" src="<?php echo esc_url( $helper->get_url( 'src/assets/images/logo.svg' ) ); ?>" alt="NetZero">
	</div>

	<?php if ( ! $helper->email_is_verified() ) { ?>
		<div class="rgbc-header__resend-email">
			<button data-rgbc-resend-email-btn="" class="rgbc-install-button rgbc-install-button_resend_email el-hover"><?php echo esc_html__( 'Re-send verification email', 'rgbc_netzero_sm' ); ?></button>
		</div>
	<?php } ?>
</header>
