<?php

use Rgbcode\Plugins\Netzero_SM\Classes\Constants;
use Rgbcode\Plugins\Netzero_SM\Classes\Helper;

$helper   = Helper::get_instance();
$messages = $args['flash'][ Constants::FLASH_MESSAGES ] ?? [];
$messages = is_array( $messages ) ? $messages : [];
?>

<div class="rgbc-content-wrapper rgbc-reset">
	<?php
	load_template( RGBC_NETZERO_SM_DIR . '/src/templates/header.php' );
	?>
	<main class="rgbc-main">
		<div class="rgbc-main__wrapper">
			<div class="rgbc-title-section rgbc-title-section_main">
				<h1 class="rgbc-title-section__title"><?php esc_html_e( 'Settings', 'rgbc_netzero_sm' ); ?></h1>
			</div>
			<div class="rgbc-settings">
				<div class="rgbc-settings__wrapper rgbc-content-container">
					<?php load_template( RGBC_NETZERO_SM_DIR . '/src/templates/messages.php', false, [ 'messages' => $messages ] ); ?>
					<form method="POST">
						<div class="rgbc-settings__block">
							<div class="rgbc-settings__inner">
								<div class="rgbc-settings__left-side">
									<h2 class="rgbc-settings__title"><?php esc_html_e( 'Enable widget', 'rgbc_netzero_sm' ); ?></h2>
									<p class="rgbc-settings__description">
									<?php
									esc_html_e(
										'You can disable the widget without deactivating the plugin. Useful for troubleshooting and support issues.',
										'rgbc_netzero_sm'
									);
									?>
									</p>
								</div>
								<div class="rgbc-settings__right-side">
									<label class="rgbc-checkbox">
										<input
												class="rgbc-checkbox__input"
												type="checkbox"
												name="widget_is_enabled"
												data-rgbc-netzero-sm-widget-switcher=""
											<?php echo Helper::get_instance()->widget_is_enabled() ? 'checked' : ''; ?>
											<?php echo $helper->user_is_registered() && $helper->email_is_verified() ? '' : 'disabled'; ?>><span
												class="rgbc-checkbox__line"></span>
									</label>
								</div>
							</div>
							<?php if ( ! $helper->user_is_registered() ) { ?>
							<div class="rgbc-settings__error">
								<div class="rgbc-error-message">
								<?php
									esc_html_e(
										'You must verify your email address to enable the widget.',
										'rgbc_netzero_sm'
									);
								?>
								</div>
							</div>
							<?php } ?>
						</div>
					<div class="rgbc-settings__block">
						<div class="rgbc-settings__inner">
							<div class="rgbc-settings__left-side">
								<h2 class="rgbc-settings__title">
								<?php
									esc_html_e(
										'Widget location',
										'rgbc_netzero_sm'
									);
									?>
								</h2>
								<p class="rgbc-settings__description">
								<?php
									esc_html_e(
										'Choose where the widget will appear. We recommend enabling all the options for a bigger impact.',
										'rgbc_netzero_sm'
									);
									?>
								</p>
							</div>
							<div class="rgbc-settings__right-side">
								<div class="rgbc-settings__checkbox-item"><span class="rgbc-settings__checkbox-title">
								<?php
										esc_html_e(
											'Cart page',
											'rgbc_netzero_sm'
										);
										?>
										</span>
									<label class="rgbc-checkbox">
										<input
												class="rgbc-checkbox__input"
												type="checkbox"
												name="widget_is_enabled_on_cart_page"
												data-rgbc-netzero-sm-location-switcher=""
											<?php echo get_option( Constants::OPTION_WIDGET_IS_ENABLED_ON_CART ) ? 'checked' : ''; ?>
											<?php echo $helper->user_is_registered() && $helper->email_is_verified() ? '' : 'disabled'; ?>><span
												class="rgbc-checkbox__line"></span>
									</label>
								</div>
								<div class="rgbc-settings__checkbox-item"><span class="rgbc-settings__checkbox-title">
								<?php
										esc_html_e(
											'Mini Cart',
											'rgbc_netzero_sm'
										);
										?>
										</span>
									<label class="rgbc-checkbox">
										<input
												class="rgbc-checkbox__input"
												type="checkbox"
												name="widget_is_enabled_on_mini_cart"
												data-rgbc-netzero-sm-location-switcher=""
											<?php echo get_option( Constants::OPTION_WIDGET_IS_ENABLED_ON_MINI_CART ) ? 'checked' : ''; ?>
											<?php echo $helper->user_is_registered() && $helper->email_is_verified() ? '' : 'disabled'; ?>><span
												class="rgbc-checkbox__line"></span>
									</label>
								</div>
								<div class="rgbc-settings__checkbox-item"><span class="rgbc-settings__checkbox-title">
								<?php
										esc_html_e(
											'Checkout',
											'rgbc_netzero_sm'
										);
										?>
										</span>
									<label class="rgbc-checkbox">
										<input
												class="rgbc-checkbox__input"
												type="checkbox"
												name="widget_is_enabled_on_checkout"
												data-rgbc-netzero-sm-location-switcher=""
											<?php echo get_option( Constants::OPTION_WIDGET_IS_ENABLED_ON_CHECKOUT ) ? 'checked' : ''; ?>
											<?php echo $helper->user_is_registered() && $helper->email_is_verified() ? '' : 'disabled'; ?>><span
												class="rgbc-checkbox__line"></span>
									</label>
								</div>
							</div>
						</div>
					</div>
					<!--<div class="rgbc-settings__block">
						<div class="rgbc-settings__inner">
							<div class="rgbc-settings__left-side">
								<h2 class="rgbc-settings__title">Regenerate the carbon reduction product</h2>
								<p class="rgbc-settings__description">Use this option ONLY if you've deleted the carbon
									reduction product from your product lists.</p>
							</div>
							<div class="rgbc-settings__right-side">
								<button class="rgbc-button el-hover">Regenerate</button>
							</div>
						</div>
					</div>-->
						<div class="rgbc-install-form__button">
							<button class="rgbc-install-button el-hover"><?php esc_html_e( 'Save Changes', 'rgbc_netzero_sm' ); ?></button>
						</div>
						<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( Constants::ADMIN_NONCE ) ); ?>">
					</form>
				</div>
			</div>
		</div>
	</main>
	<?php
	load_template( RGBC_NETZERO_SM_DIR . '/src/templates/footer.php' );
	?>
</div>
