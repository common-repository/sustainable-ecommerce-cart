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
			<div class="rgbc-title-section rgbc-title-section_fit rgbc-title-section_journey">
				<h1 class="rgbc-title-section__title"><?php esc_html_e( 'My Green Journey', 'rgbc_netzero_sm' ); ?></h1>
				<p class="rgbc-title-section__description"><?php esc_html_e( 'We know you\'re busy, so we made these tools to simplify your climate journey. Show the world that you are a climate-friendly brand.', 'rgbc_netzero_sm' ); ?></p>
			</div>
			<div class="rgbc-journey">
				<div class="rgbc-journey__wrapper rgbc-content-container">
					<div class="rgbc-journey__item">
						<div class="rgbc-journey__text-container">
							<h2 class="rgbc-journey__title"><?php esc_html_e( 'Sustainable ecommerce badge', 'rgbc_netzero_sm' ); ?></h2>
							<p class="rgbc-journey__description"><?php esc_html_e( 'Easily share with your website visitors that you are a climate-friendly shop.', 'rgbc_netzero_sm' ); ?></p>
						</div>
						<div class="rgbc-journey__content-container">
							<div class="rgbc-journey__content-item">
								<div class="rgbc-journey__content-color rgbc-journey__content-color_green"></div><a target="_blank" class="rgbc-button el-hover" href="<?php echo esc_url( Constants::SITE_URL . '/badges' ); ?>" download><?php esc_html_e( 'Download', 'rgbc_netzero_sm' ); ?></a>
								<!-- <p class="rgbc-journey__content-description"><?php esc_html_e( 'or use WordPress code:', 'rgbc_netzero_sm' ); ?>
								<div class="rgbc-journey__content-code">xxx</div>
								</p>-->
							</div>
							<div class="rgbc-journey__content-item">
								<div class="rgbc-journey__content-color rgbc-journey__content-color_black"></div><a target="_blank" class="rgbc-button el-hover" href="<?php echo esc_url( Constants::SITE_URL . '/badges' ); ?>" download><?php esc_html_e( 'Download', 'rgbc_netzero_sm' ); ?></a>
								<!--<p class="rgbc-journey__content-description"><?php esc_html_e( 'or use WordPress code:', 'rgbc_netzero_sm' ); ?>
								<div class="rgbc-journey__content-code">xxx</div>
								</p>
								-->
							</div>
						</div>
					</div>
					<div class="rgbc-journey__item">
						<div class="rgbc-journey__text-container">
							<h2 class="rgbc-journey__title"><?php esc_html_e( 'Sustainability calendar', 'rgbc_netzero_sm' ); ?></h2>
							<p class="rgbc-journey__description"><?php esc_html_e( 'Engage with the growing market of climate-conscious customers. Keep track of sustainability and climate events with our handy yearly calendar.', 'rgbc_netzero_sm' ); ?></p>
						</div>
						<div class="rgbc-journey__content-container">
							<div class="rgbc-journey__content-item">
								<div class="rgbc-journey__content-icon"><img class="rgbc-journey__content-image" src="<?php echo esc_url( $helper->get_url( 'src/assets/images/journey-1.svg' ) ); ?>"></div>
							</div>
							<div class="rgbc-journey__content-item">
								<a target="_blank" class="rgbc-button el-hover" href="<?php echo esc_url( Constants::SITE_URL . '/sustainability-calendar' ); ?>" target='_blank'><?php esc_html_e( 'Download', 'rgbc_netzero_sm' ); ?></a>
							</div>
						</div>
					</div>
					<div class="rgbc-journey__item">
						<div class="rgbc-journey__text-container">
							<h2 class="rgbc-journey__title"><?php esc_html_e( 'Content ideas about sustainability', 'rgbc_netzero_sm' ); ?></h2>
							<p class="rgbc-journey__description"><?php esc_html_e( 'Get inspired by this collection of ideas for social media and blog posts about climate and sustainability.', 'rgbc_netzero_sm' ); ?></p>
						</div>
						<div class="rgbc-journey__content-container">
							<div class="rgbc-journey__content-item">
								<div class="rgbc-journey__content-icon"><img class="rgbc-journey__content-image" src="<?php echo esc_url( $helper->get_url( 'src/assets/images/journey-2.svg' ) ); ?>"></div>
							</div>
							<div class="rgbc-journey__content-item">
								<a target="_blank" class="rgbc-button el-hover" href="<?php echo esc_url( Constants::SITE_URL . '/sustainability-social-posts-ideas' ); ?>" target='_blank'><?php esc_html_e( 'Show me', 'rgbc_netzero_sm' ); ?></a>
							</div>
						</div>
					</div>
					<div class="rgbc-journey__item">
						<div class="rgbc-journey__text-container">
							<h2 class="rgbc-journey__title"><?php esc_html_e( 'Premium Features', 'rgbc_netzero_sm' ); ?></h2>
							<p class="rgbc-journey__description"><?php esc_html_e( 'We can assist you with custom solutions to support your brand. Here are some of our premium services: make all your shipping climate neutral, real-time climate impact calculator, and custom sustainability statement. Contact us for more information.', 'rgbc_netzero_sm' ); ?></p>
						</div>
						<div class="rgbc-journey__content-container">
							<div class="rgbc-journey__content-item">
								<div class="rgbc-journey__content-icon"><img class="rgbc-journey__content-image" src="<?php echo esc_url( $helper->get_url( 'src/assets/images/journey-3.svg' ) ); ?>"></div>
							</div>
							<div class="rgbc-journey__content-item">
								<a class="rgbc-button el-hover" href="mailto:premium@netzerosm.com"><?php esc_html_e( 'Contact Us', 'rgbc_netzero_sm' ); ?></a>
							</div>
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
