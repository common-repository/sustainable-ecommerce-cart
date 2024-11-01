<?php
use Rgbcode\Plugins\Netzero_SM\Classes\Constants;
?>

<footer class="rgbc-footer">
	<span class="rgbc-footer__title">
		<?php esc_html_e( 'Need Help?', 'rgbc_netzero_sm' ); ?>&nbsp;
	</span><?php esc_html_e( 'Check out the', 'rgbc_netzero_sm' ); ?>&nbsp;
	<a class="rgbc-footer__faq-link el-hover rgbc-link" href="#">
		<?php esc_html_e( 'FAQ', 'rgbc_netzero_sm' ); ?>&nbsp;
	</a><?php esc_html_e( 'or contact our support team on:', 'rgbc_netzero_sm' ); ?>
	<div class="rgbc-footer__email">
		<span class="rgbc-footer__item-title">
			<?php esc_html_e( 'EMAIL', 'rgbc_netzero_sm' ); ?>
		</span>
		<a class="rgbc-footer__email-link rgbc-link rgbc-link-yellow el-hover" href="mailto:<?php echo esc_attr( Constants::EMAIL ); ?>">
			<?php echo esc_html( Constants::EMAIL ); ?>
		</a>
	</div>
	<div class="rgbc-footer__phone">
		<span class="rgbc-footer__item-title">
			<?php esc_html_e( 'Whatsapp or Call', 'rgbc_netzero_sm' ); ?>
		</span>
		<a class="rgbc-footer__phone-link el-hover" href="tel:<?php echo esc_attr( Constants::PHONE ); ?>">
			<?php echo esc_html( Constants::PHONE ); ?>
		</a>
	</div>
</footer>
