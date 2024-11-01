<?php
use Rgbcode\Plugins\Netzero_SM\Classes\Constants;
use Rgbcode\Plugins\Netzero_SM\Classes\Helper;

$helper = Helper::get_instance();

$messages = $args['flash'][ Constants::FLASH_MESSAGES ] ?? [];
$messages = is_array( $messages ) ? $messages : [];

$field_errors = $args['flash'][ Constants::FIELDS_ERRORS ] ?? [];
$field_errors = is_array( $field_errors ) ? $field_errors : [];

$filled_fields = $args['flash'][ Constants::FIELDS_VALUES ] ?? [];
$filled_fields = is_array( $filled_fields ) ? $filled_fields : [];
?>

<div class="rgbc-content-wrapper rgbc-content-wrapper_install rgbc-reset">
	<div class="rgbc-install-layout rgbc-install-layout_install-2">
		<div class="rgbc-install-nav rgbc-install-nav_dark rgbc-adaptive-font-size">
			<div class="rgbc-install-nav__item rgbc-install-nav__item_active">1</div>
			<div class="rgbc-install-nav__item">2</div>
		</div>
		<div class="rgbc-developed rgbc-developed_dark"><span class="rgbc-developed__title"><?php esc_html_e( 'Developed by', 'rgbc_netzero_sm' ); ?></span>
			<div class="rgbc-developed__image"></div>
		</div>
		<div class="rgbc-install-layout__side rgbc-install-layout__side_left">
			<div class="rgbc-install-layout__logo"></div>
			<h1 class="rgbc-install-layout__title"><?php esc_html_e( 'Thanks for installing the Sustainable eCommerce Cart', 'rgbc_netzero_sm' ); ?></h1>
			<h2 class="rgbc-install-layout__subtitle">
				<?php
				echo sprintf(
					'%s&nbsp;<span>%s&nbsp;</span>%s',
					esc_html__( 'Your', 'rgbc_netzero_sm' ),
					esc_html__( 'free', 'rgbc_netzero_sm' ),
					esc_html__( 'all-in-one sustainable shopping experience for eCommerce:', 'rgbc_netzero_sm' )
				)
				?>
			</h2>
			<div class="rgbc-install-layout__install-list rgbc-adaptive-font-size">
				<div class="rgbc-install-list-item">
					<div class="rgbc-install-list-item__icon"><img class="rgbc-install-list-item__image" src="<?php echo esc_url( $helper->get_url( 'src/assets/images/install-list-1.svg' ) ); ?>"></div>
					<div class="rgbc-install-list-item__text-container">
						<h3 class="rgbc-install-list-item__title"><?php esc_html_e( 'Carbon Offset Widget', 'rgbc_netzero_sm' ); ?></h3>
						<p class="rgbc-install-list-item__description"><?php esc_html_e( 'Allow your customers to reduce the carbon footprint of their order', 'rgbc_netzero_sm' ); ?></p>
					</div>
				</div>
				<div class="rgbc-install-list-item">
					<div class="rgbc-install-list-item__icon"><img class="rgbc-install-list-item__image" src="<?php echo esc_url( $helper->get_url( 'src/assets/images/install-list-2.svg' ) ); ?>"></div>
					<div class="rgbc-install-list-item__text-container">
						<h3 class="rgbc-install-list-item__title"><?php esc_html_e( 'Sustainable eCommerce Badge', 'rgbc_netzero_sm' ); ?></h3>
						<p class="rgbc-install-list-item__description"><?php esc_html_e( 'Show your customers that your shop is more sustainable than your competitors', 'rgbc_netzero_sm' ); ?></p>
					</div>
				</div>
				<div class="rgbc-install-list-item">
					<div class="rgbc-install-list-item__icon"><img class="rgbc-install-list-item__image" src="<?php echo esc_url( $helper->get_url( 'src/assets/images/install-list-3.svg' ) ); ?>"></div>
					<div class="rgbc-install-list-item__text-container">
						<h3 class="rgbc-install-list-item__title"><?php esc_html_e( 'Sustainability Toolbox', 'rgbc_netzero_sm' ); ?></h3>
						<p class="rgbc-install-list-item__description"><?php esc_html_e( 'Benefit from a collection of social media posts ideas, sustainability events calendar, and other tools to support your brand', 'rgbc_netzero_sm' ); ?></p>
					</div>
				</div>
			</div>
		</div>
		<div class="rgbc-install-layout__side rgbc-install-layout__side_right">
			<div class="rgbc-install-form rgbc-adaptive-font-size">
				<?php
				load_template( RGBC_NETZERO_SM_DIR . '/src/templates/messages.php', false, [ 'messages' => $messages ] );
				?>
				<h2 class="rgbc-install-form__title"><?php esc_html_e( 'Create your account', 'rgbc_netzero_sm' ); ?></h2>
				<form method="POST" data-rgbc-registration-form="" class="rgbc-install-form__form">
					<input required class="rgbc-install-form__input <?php echo array_key_exists( 'first_name', $field_errors ) ? 'rgbc-input-error' : ''; ?>" type="text" name="first_name" placeholder="<?php esc_html_e( '*First name', 'rgbc_netzero_sm' ); ?>" value="<?php echo esc_attr( $filled_fields['first_name'] ?? '' ); ?>">
					<input required class="rgbc-install-form__input <?php echo array_key_exists( 'last_name', $field_errors ) ? 'rgbc-input-error' : ''; ?>" type="text" name="last_name" placeholder="<?php esc_html_e( '*Last name', 'rgbc_netzero_sm' ); ?>" value="<?php echo esc_attr( $filled_fields['last_name'] ?? '' ); ?>">
					<input required class="rgbc-install-form__input <?php echo array_key_exists( 'email', $field_errors ) ? 'rgbc-input-error' : ''; ?>" type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" name="email" placeholder="<?php esc_html_e( '*Email', 'rgbc_netzero_sm' ); ?>" value="<?php echo esc_attr( $filled_fields['email'] ?? '' ); ?>">
					<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( Constants::ADMIN_NONCE ) ); ?>">
					<label class="rgbc-install-form__terms-label">
						<input class="rgbc-install-form__checkbox <?php echo array_key_exists( 'terms', $field_errors ) ? 'rgbc-input-error' : ''; ?>" type="checkbox" name="terms" <?php echo ( $filled_fields['terms'] ?? false ) ? 'checked' : ''; ?>>
						<?php
						echo sprintf(
							'<span class="rgbc-install-form__terms-title">
                                %s&nbsp;
                                <a class="rgbc-install-form__terms-link" href="%s">
                                    %s
                                </a>and&nbsp;
                                <a class="rgbc-install-form__terms-link" href="%s">
                                    %s
                                </a>
                            </span>',
							esc_html__( 'I have read and agree to netzeroSM', 'rgbc_netzero_sm' ),
							esc_url( Helper::get_instance()->get_server_root_url() . '/terms' ),
							esc_html__( 'Terms of Service', 'rgbc_netzero_sm' ),
							esc_url( Helper::get_instance()->get_server_root_url() . '/privacy' ),
							esc_html__( 'Privacy Policy', 'rgbc_netzero_sm' )
						)
						?>
					</label>

<!--					<div class='rgbc-install-form__auth-error'>-->
<!--						<span class='rgbc-install-form__auth-error-message'>Only an authorized shop manager or administrator can register for an account.</span>-->
<!--					</div>-->

					<div class="rgbc-install-form__button">
						<button class="rgbc-install-button el-hover <?php echo array_key_exists( 'terms', $field_errors ) ? 'rgbc-install-button_terms-alert' : ''; ?>"> <!-- add .rgbc-install-button_terms-alert to show alert message -->
							<div class='rgbc-install-button__terms-alert'>
								<span class='rgbc-install-button__terms-alert-message'>Please approve the Terms of Service and Privacy Policy before submitting.</span>
							</div>
							<?php esc_html_e( 'Submit', 'rgbc_netzero_sm' ); ?>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
