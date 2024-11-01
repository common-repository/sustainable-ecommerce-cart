<?php

use Rgbcode\Plugins\Netzero_SM\Classes\Constants;
use Rgbcode\Plugins\Netzero_SM\Classes\Helper;

$helper = Helper::get_instance();
?>

<div class="rgbc-content-wrapper rgbc-reset">
	<?php
	load_template( RGBC_NETZERO_SM_DIR . '/src/templates/header.php' );
	?>
	<main class="rgbc-main">
		<div class="rgbc-main__wrapper">
			<div class="rgbc-title-section rgbc-title-section_fit">
				<h1 class="rgbc-title-section__title"><?php esc_html_e( 'Getting started', 'rgbc_netzero_sm' ); ?></h1>
				<p class="rgbc-title-section__description"><?php esc_html_e( 'We created a short checklist to help you set up and get the most from the Sustainable eCommerce Cart. You can always come back to this page by clicking the link at the top.', 'rgbc_netzero_sm' ); ?></p>
			</div>
			<div class="rgbc-start">
				<div class="rgbc-start__wrapper rgbc-content-container">
					<div class="rgbc-start__item">
						<div class="rgbc-start__num-container"><span class="rgbc-start__num">1</span></div>
						<div class="rgbc-start__title-container">
							<h2 class="rgbc-start__title"><?php esc_html_e( 'Confirm your email address', 'rgbc_netzero_sm' ); ?></h2>
							<p class="rgbc-start__description"><?php esc_html_e( 'Open your inbox and confirm your email address by clicking the link.', 'rgbc_netzero_sm' ); ?></p>
						</div>
					</div>
					<div class="rgbc-start__item">
						<div class="rgbc-start__num-container"><span class="rgbc-start__num">2</span></div>
						<div class="rgbc-start__title-container">
							<h2 class="rgbc-start__title"><?php esc_html_e( 'Customise the widget design', 'rgbc_netzero_sm' ); ?></h2>
							<p class="rgbc-start__description"><?php esc_html_e( 'Enter the design tab and choose your favorite widget style. You can change it any time.', 'rgbc_netzero_sm' ); ?></p>
						</div>
						<div class="rgbc-start__link-container"><a class="rgbc-start__link el-hover" href="<?php echo esc_url( $helper->get_page_link( Constants::ACTION_DESIGN ) ); ?>"><?php esc_html_e( 'Design', 'rgbc_netzero_sm' ); ?></a></div>
					</div>
					<div class="rgbc-start__item">
						<div class="rgbc-start__num-container"><span class="rgbc-start__num">3</span></div>
						<div class="rgbc-start__title-container">
							<h2 class="rgbc-start__title"><?php esc_html_e( 'Enable the widget', 'rgbc_netzero_sm' ); ?></h2>
							<p class="rgbc-start__description"><?php esc_html_e( 'Go into the settings tab and check that the widget is enabled.', 'rgbc_netzero_sm' ); ?></p>
						</div>
						<div class="rgbc-start__link-container"><a class="rgbc-start__link el-hover" href="<?php echo esc_url( $helper->get_page_link( Constants::ACTION_SETTINGS ) ); ?>"><?php esc_html_e( 'Settings', 'rgbc_netzero_sm' ); ?></a></div>
					</div>
					<div class="rgbc-start__item">
						<div class="rgbc-start__num-container"><span class="rgbc-start__num">4</span></div>
						<div class="rgbc-start__title-container">
							<h2 class="rgbc-start__title"><?php esc_html_e( 'Check the cart page', 'rgbc_netzero_sm' ); ?></h2>
							<p class="rgbc-start__description"><?php esc_html_e( 'Check the widget exist and that everything works and looks good in the cart.', 'rgbc_netzero_sm' ); ?></p>
						</div>
						<div class="rgbc-start__link-container"><a class="rgbc-start__link el-hover" href="<?php echo esc_url( wc_get_cart_url() ); ?>"><?php esc_html_e( 'Cart page', 'rgbc_netzero_sm' ); ?></a></div>
					</div>
					<div class="rgbc-start__item">
						<div class="rgbc-start__num-container"><span class="rgbc-start__num">5</span></div>
						<div class="rgbc-start__title-container">
							<h2 class="rgbc-start__title"><?php esc_html_e( 'Check the checkout page', 'rgbc_netzero_sm' ); ?></h2>
							<p class="rgbc-start__description"><?php esc_html_e( 'Check the widget exist and that everything works and looks good in the checkout page.', 'rgbc_netzero_sm' ); ?></p>
						</div>
						<div class="rgbc-start__link-container"><a class="rgbc-start__link el-hover" href="<?php echo esc_url( wc_get_checkout_url() ); ?>"><?php esc_html_e( 'Checkout page', 'rgbc_netzero_sm' ); ?></a></div>
					</div>
					<div class="rgbc-start__item">
						<div class="rgbc-start__num-container"><span class="rgbc-start__num">6</span></div>
						<div class="rgbc-start__title-container">
							<h2 class="rgbc-start__title"><?php esc_html_e( 'Explore your benefits', 'rgbc_netzero_sm' ); ?></h2>
							<p class="rgbc-start__description"><?php esc_html_e( 'Get into the My Green Journey tab and start communicate your positive branding.', 'rgbc_netzero_sm' ); ?></p>
						</div>
						<div class="rgbc-start__link-container"><a class="rgbc-start__link el-hover" href="<?php echo esc_url( $helper->get_page_link( Constants::ACTION_JOURNEY ) ); ?>"><?php esc_html_e( 'My Green Journey', 'rgbc_netzero_sm' ); ?></a></div>
					</div>
					<div class="rgbc-start__item">
						<div class="rgbc-start__num-container"><span class="rgbc-start__num">7</span></div>
						<div class="rgbc-start__title-container">
							<h2 class="rgbc-start__title"><?php esc_html_e( 'Explore the dashboard', 'rgbc_netzero_sm' ); ?></h2>
							<p class="rgbc-start__description"><?php esc_html_e( 'On the dashboard you can easily track your positive impact. It will be your default page from now on.', 'rgbc_netzero_sm' ); ?></p>
						</div>
						<div class="rgbc-start__link-container"><a class="rgbc-start__link el-hover" href="<?php echo esc_url( $helper->get_page_link( Constants::ACTION_MAIN ) ); ?>"><?php esc_html_e( 'Dashboard', 'rgbc_netzero_sm' ); ?></a></div>
					</div>
				</div>
			</div>
		</div>
	</main>
	<?php
	load_template( RGBC_NETZERO_SM_DIR . '/src/templates/footer.php' );
	?>
</div>
