<?php
use Rgbcode\Plugins\Netzero_SM\Classes\Constants;
?>
<div class="rgbc-content-wrapper rgbc-reset">
	<?php
	load_template( RGBC_NETZERO_SM_DIR . '/src/templates/header.php' );
	?>
	<main class="rgbc-main rgbc-main_black">
		<div class="rgbc-main__wrapper rgbc-main__wrapper_suspended">
			<div class="rgbc-site-suspended">
				<div class="rgbc-site-suspended__wrapper rgbc-content-container">
<?php
echo sprintf(
	'<h1 class="rgbc-site-suspended__title">%s</h1>
<div class="rgbc-site-suspended__description">
<p class="rgbc-site-suspended__paragraph">%s</p>
<p class="rgbc-site-suspended__paragraph">%s</p>
<p class="rgbc-site-suspended__paragraph">%s</p>
</div>
<div class="rgbc-site-suspended__thanks">
<p class="rgbc-site-suspended__paragraph">%s</p>
<p class="rgbc-site-suspended__paragraph">%s</p>
</div>',
	esc_html__( 'Hello', 'rgbc_netzero_sm' ),
	esc_html__( 'This account has been suspended due to violating our Terms of Service.', 'rgbc_netzero_sm' ),
	esc_html__( 'Please get in touch with our support team to unlock your account.', 'rgbc_netzero_sm' ),
	esc_html__( 'We are sorry for the inconvenience.', 'rgbc_netzero_sm' ),
	esc_html__( 'Thanks,', 'rgbc_netzero_sm' ),
	esc_html__( 'The netzeroSM team', 'rgbc_netzero_sm' )
);
?>
					<div class='rgbc-site-suspended__contacts'>
						<div class="rgbc-site-suspended__email">
							<span class="rgbc-site-suspended__item-title">
								<?php esc_html_e( 'EMAIL', 'rgbc_netzero_sm' ); ?>
							</span>
							<a class="rgbc-site-suspended__email-link rgbc-link rgbc-link-yellow el-hover" href="mailto:<?php echo esc_attr( Constants::EMAIL ); ?>">
								<?php echo esc_html( Constants::EMAIL ); ?>
							</a>
						</div>
						<div class="rgbc-site-suspended__phone">
							<span class="rgbc-site-suspended__item-title">
								<?php esc_html_e( 'Whatsapp or Call', 'rgbc_netzero_sm' ); ?>
							</span>
							<a class="rgbc-site-suspended__phone-link el-hover" href="tel:<?php echo esc_attr( Constants::PHONE ); ?>">
								<?php echo esc_html( Constants::PHONE ); ?>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
	<?php
	load_template( RGBC_NETZERO_SM_DIR . '/src/templates/footer.php' );
	?>
</div>
