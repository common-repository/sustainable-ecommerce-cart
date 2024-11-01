<?php

use Rgbcode\Plugins\Netzero_SM\Classes\Constants;
use Rgbcode\Plugins\Netzero_SM\Classes\Helper;

$helper   = Helper::get_instance();
$messages = $args['flash'][ Constants::FLASH_MESSAGES ] ?? [];
?>

<div class="rgbc-content-wrapper rgbc-reset">
	<?php
	load_template( RGBC_NETZERO_SM_DIR . '/src/templates/header.php' );
	?>
	<main class="rgbc-main">
		<div class="rgbc-main__wrapper">
			<div class="rgbc-title-section rgbc-title-section_fit">
				<h1 class="rgbc-title-section__title"><?php esc_html_e( 'Design', 'rgbc_netzero_sm' ); ?></h1>
			</div>
			<?php load_template( RGBC_NETZERO_SM_DIR . '/src/templates/messages.php', false, [ 'messages' => $messages ] ); ?>
			<form method="POST">
			<div class="rgbc-design">
					<div class="rgbc-design__side rgbc-design__side_left">
						<div class="rgbc-design__item rgbc-design__item_options">
							<div class="rgbc-design__title-container">
								<h2 class="rgbc-design__title"><?php esc_html_e( '1. Choose where to place the widget on the cart page', 'rgbc_netzero_sm' ); ?></h2>
							</div>
							<div class="rgbc-design__content-container">
								<input class="rgbc-design__option-input" type="radio" name="widget_place" value="<?php echo esc_attr( Constants::WIDGET_PLACE_A ); ?>" <?php echo $helper->get_widget_place() === Constants::WIDGET_PLACE_A ? 'checked' : ''; ?> id="design-option-1">
								<label class="rgbc-design__option" for="design-option-1">
									<div class="rgbc-design__option-image-container"><img class="rgbc-design__option-image" src="<?php echo esc_url( $helper->get_url( 'src/assets/images/option-1.svg' ) ); ?>" alt="<?php esc_html_e( 'option', 'rgbc_netzero_sm' ); ?>"></div>
									<div class="rgbc-design__option-text-container">
										<h3 class="rgbc-design__option-title"><?php esc_html_e( 'Option A (Recommended)', 'rgbc_netzero_sm' ); ?></h3>
										<p class="rgbc-design__option-description"><?php esc_html_e( 'Below the cart total', 'rgbc_netzero_sm' ); ?></p>
									</div>
								</label>
								<input class="rgbc-design__option-input" type="radio" name="widget_place" value="<?php echo esc_attr( Constants::WIDGET_PLACE_B ); ?>" <?php echo $helper->get_widget_place() === Constants::WIDGET_PLACE_B ? 'checked' : ''; ?> id="design-option-2">
								<label class="rgbc-design__option" for="design-option-2">
									<div class="rgbc-design__option-image-container"><img class="rgbc-design__option-image" src="<?php echo esc_url( $helper->get_url( 'src/assets/images/option-2.svg' ) ); ?>" alt="<?php esc_html_e( 'option', 'rgbc_netzero_sm' ); ?>"></div>
									<div class="rgbc-design__option-text-container">
										<h3 class="rgbc-design__option-title"><?php esc_html_e( 'Option B', 'rgbc_netzero_sm' ); ?></h3>
										<p class="rgbc-design__option-description"><?php esc_html_e( 'Below the cart', 'rgbc_netzero_sm' ); ?></p>
									</div>
								</label>
							</div>
						</div>
						<div class="rgbc-design__item rgbc-design__item_circles">
							<div class="rgbc-design__title-container">
								<h2 class="rgbc-design__title"><?php esc_html_e( '2. Choose color', 'rgbc_netzero_sm' ); ?></h2>
							</div>
							<div class="rgbc-design__content-container">
								<div class="rgbc-design__circles">
									<div class="rgbc-design__circle">
										<div class="rgbc-circle-radio">
											<input
													class="rgbc-circle-radio__input"
													type="radio"
													name="widget_color"
													value="<?php echo esc_attr( Constants::WIDGET_COLOR_WHITE ); ?>"
													id="design-color-1"
												<?php echo $helper->get_widget_color() === Constants::WIDGET_COLOR_WHITE ? 'checked' : ''; ?>>
											<label class="rgbc-circle-radio__label" for="design-color-1">
												<div class="rgbc-circle-radio__inner rgbc-circle-radio__inner_white"></div>
											</label>
										</div>
									</div>
									<div class="rgbc-design__circle">
										<div class="rgbc-circle-radio">
											<input
													class="rgbc-circle-radio__input"
													type="radio"
													name="widget_color"
													value="<?php echo esc_attr( Constants::WIDGET_COLOR_DARK ); ?>"
													id="design-color-2"
												<?php echo $helper->get_widget_color() === Constants::WIDGET_COLOR_DARK ? 'checked' : ''; ?>>
											<label class="rgbc-circle-radio__label" for="design-color-2">
												<div class="rgbc-circle-radio__inner rgbc-circle-radio__inner_black"></div>
											</label>
										</div>
									</div>
									<div class="rgbc-design__circle">
										<div class="rgbc-circle-radio">
											<input
													class="rgbc-circle-radio__input"
													type="radio"
													name="widget_color"
													value="<?php echo esc_attr( Constants::WIDGET_COLOR_GREEN ); ?>"
													id="design-color-3"
												<?php echo $helper->get_widget_color() === Constants::WIDGET_COLOR_GREEN ? 'checked' : ''; ?>>
											<label class="rgbc-circle-radio__label" for="design-color-3">
												<div class="rgbc-circle-radio__inner rgbc-circle-radio__inner_green"></div>
											</label>
										</div>
									</div>
									<div class="rgbc-design__circle">
										<div class="rgbc-circle-radio">
											<input
													class="rgbc-circle-radio__input"
													type="radio"
													name="widget_color"
													value="<?php echo esc_attr( Constants::WIDGET_COLOR_GRAY ); ?>"
													id="design-color-4"
												<?php echo $helper->get_widget_color() === Constants::WIDGET_COLOR_GRAY ? 'checked' : ''; ?>>
											<label class="rgbc-circle-radio__label" for="design-color-4">
												<div class="rgbc-circle-radio__inner rgbc-circle-radio__inner_gray"></div>
											</label>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php
						$country_list = [
							[
								'value' => 'us_US',
								'image' => 'united-states.svg',
								'text'  => esc_html__( 'US', 'rgbc_netzero_sm' ),
							],
							[
								'value' => 'en_GB',
								'image' => 'united-kingdom.svg',
								'text'  => esc_html__( 'UK', 'rgbc_netzero_sm' ),
							],
							[
								'value' => 'it_IT',
								'image' => 'italy.svg',
								'text'  => esc_html__( 'IT', 'rgbc_netzero_sm' ),
							],
							[
								'value' => 'de_DE',
								'image' => 'germany.svg',
								'text'  => esc_html__( 'DE', 'rgbc_netzero_sm' ),
							],
							[
								'value' => 'fr_FR',
								'image' => 'france.svg',
								'text'  => esc_html__( 'FR', 'rgbc_netzero_sm' ),
							],
							[
								'value' => 'pt_PT',
								'image' => 'portugal.svg',
								'text'  => esc_html__( 'PT', 'rgbc_netzero_sm' ),
							],
							[
								'value' => 'es_ES',
								'image' => 'spain.svg',
								'text'  => esc_html__( 'ES', 'rgbc_netzero_sm' ),
							],
						];

						?>
						<div class="rgbc-design__item rgbc-design__item_circles rgbc-design__item_lang">
							<div class="rgbc-design__title-container">
								<h2 class="rgbc-design__title"><?php esc_html_e( '3. The language will be detected automatically', 'rgbc_netzero_sm' ); ?></h2>
								<p class="rgbc-design__languages-description"><?php esc_html_e( 'These languages are available', 'rgbc_netzero_sm' ); ?></p>
							</div>
							<div class="rgbc-design__content-container">
								<div class="rgbc-design__circles">
									<?php
									foreach ( $country_list as $k => $v ) {
										$value = $v['value'] ?? '';
										$image = $v['image'] ?? '';
										$text  = $v['text'] ?? '';
										if ( ! Helper::get_instance()->translate_exists( $value ) && $value !== 'us_US' ) {
											continue;
										}
										?>
										<div class="rgbc-design__circle">
											<div class="rgbc-circle-radio circle-radio_country">
												<!--<input class="rgbc-circle-radio__input" type="radio" name="country" value="<?php /*echo esc_attr( $value ); */ ?>" id="design-country-<?php /*echo esc_attr( $k ); */ ?>" checked>--> <?php //phpcs:ignore ?>
												<label class="rgbc-circle-radio__label" for="design-country-<?php echo esc_attr( $k ); ?>">
													<div class="rgbc-circle-radio__inner" style="background-image: url(<?php echo esc_url( $helper->get_url( "src/assets/images/$image" ) ); ?>);"></div>
													<h4 class="rgbc-circle-radio__title"><?php echo esc_html( $text ); ?></h4>
												</label>
											</div>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
						<div class="rgbc-design__lower-side rgbc-design__lower-side_left">
							<?php
							echo sprintf(
								'<p class="rgbc-design__lower-side-text">%s&nbsp;<a class="rgbc-design__lower-side-link el-hover" href="%s">%s</a>&nbsp;%s</p>',
								esc_html__( 'Can’t find a style you like?', 'rgbc_netzero_sm' ),
								esc_attr( 'mailto:' . Constants::EMAIL ),
								esc_html__( 'Contact us', 'rgbc_netzero_sm' ),
								esc_html__( 'for customization.', 'rgbc_netzero_sm' )
							);
							?>
							<button class="rgbc-install-button el-hover"><?php esc_html_e( 'Save Changes', 'rgbc_netzero_sm' ); ?></button>
						</div>
					</div>
				<div class="rgbc-design__side rgbc-design__side_right">
					<h2 class="rgbc-design__preview-title"><?php esc_html_e( 'Preview of the widget on a default WooCommerce Cart', 'rgbc_netzero_sm' ); ?></h2>
					<div class="rgbc-design__image-container js-rgbc-design-image-container">
						<div class="rgbc-design__image-wrapper">
							<img class="rgbc-design__image js-rgbc-design-image" src="<?php echo esc_url( $helper->get_url( 'src/assets/images/cart-preview/widget_place_a_white.png' ) ); ?>">
						</div>
					</div>
					<div class="rgbc-design__lower-side rgbc-design__lower-side_right">
						<?php
						echo sprintf(
							'<p class="rgbc-design__lower-side-text"><strong class="rgbc-design__lower-side-strong">%s&nbsp;</strong>%s</p>',
							esc_html__( 'Important!', 'rgbc_netzero_sm' ),
							esc_html__( 'besides adding the widget, nothing else will change on your cart.', 'rgbc_netzero_sm' )
						)
						?>

					</div>
				</div>
					<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( Constants::ADMIN_NONCE ) ); ?>">
			</div>
			</form>
		</div>
	</main>
	<?php
	load_template( RGBC_NETZERO_SM_DIR . '/src/templates/footer.php' );
	?>
</div>
