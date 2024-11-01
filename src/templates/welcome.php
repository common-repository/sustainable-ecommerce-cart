<?php
use Rgbcode\Plugins\Netzero_SM\Classes\Constants;
?>
<div class="rgbc-content-wrapper rgbc-content-wrapper_install rgbc-reset">
	<div class="rgbc-install-layout rgbc-install-layout_install-1">
		<div class="rgbc-install-nav rgbc-adaptive-font-size">
			<div class="rgbc-install-nav__item rgbc-install-nav__item_active"></div>
			<div class="rgbc-install-nav__item">2</div>
		</div>
		<div class="rgbc-developed"><span class="rgbc-developed__title"><?php esc_html_e( 'Developed by', 'rgbc_netzero_sm' ); ?></span>
			<div class="rgbc-developed__image"></div>
		</div>
		<div class="rgbc-install-layout__side rgbc-install-layout__side_left rgbc-adaptive-font-size">
			<div class="rgbc-install-layout__text-container">
				<h1 class="rgbc-install-layout__title"><?php esc_html_e( 'How it works', 'rgbc_netzero_sm' ); ?></h1>
				<h2 class="rgbc-install-layout__subtitle">
					<?php
					echo sprintf(
						'%s&nbsp;<span>%s&nbsp;</span>%s</h2>',
						esc_html__( 'Our plugin is', 'rgbc_netzero_sm' ),
						esc_html__( '100% FREE', 'rgbc_netzero_sm' ),
						esc_html__( 'for you!', 'rgbc_netzero_sm' )
					)
					?>
				<div class="rgbc-install-layout__description">
					<p><?php esc_html_e( 'You recive the carbon offset payments from your customers as if it was another product sold by you.', 'rgbc_netzero_sm' ); ?></p>
					<p><?php esc_html_e( 'At the end of each month, we collect the exact same amount from you, and use it to fund certified carbon offset projects.', 'rgbc_netzero_sm' ); ?></p>
				</div>
				<div class="rgbc-install-layout__list-container">
					<h3 class="rgbc-install-layout__list-title"><?php esc_html_e( 'Together we will:', 'rgbc_netzero_sm' ); ?></h3>
					<ul class="rgbc-install-layout__list">
						<li class="rgbc-install-layout__list-item"><?php esc_html_e( 'Prevent deforestation', 'rgbc_netzero_sm' ); ?></li>
						<li class="rgbc-install-layout__list-item"><?php esc_html_e( 'Plant new forests', 'rgbc_netzero_sm' ); ?></li>
						<li class="rgbc-install-layout__list-item"><?php esc_html_e( 'Accelerate the global transition toward clean energy.', 'rgbc_netzero_sm' ); ?></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="rgbc-install-layout__side rgbc-install-layout__side_right">
			<div class="rgbc-install-steps">
				<div class="rgbc-install-step rgbc-install-step_first">
					<div class="rgbc-install-step__icon"></div>
					<div class="rgbc-install-step__text-container rgbc-adaptive-font-size">
						<p class="rgbc-install-step__paragraph"><?php esc_html_e( '1. Customers choose to buy carbon offset', 'rgbc_netzero_sm' ); ?></p>
					</div>
				</div>
				<div class="rgbc-install-step rgbc-install-step_second">
					<div class="rgbc-install-step__icon"></div>
					<div class="rgbc-install-step__text-container rgbc-adaptive-font-size">
						<p class="rgbc-install-step__paragraph"><?php esc_html_e( '2. You collect carbon offset contribution just like any other product', 'rgbc_netzero_sm' ); ?></p>
					</div>
				</div>
				<div class="rgbc-install-step rgbc-install-step_third">
					<div class="rgbc-install-step__icon"></div>
					<div class="rgbc-install-step__text-container rgbc-adaptive-font-size">
						<p class="rgbc-install-step__paragraph"><?php esc_html_e( '3. Once a month, your contribution funds carbon offset projects via netzeroSM.', 'rgbc_netzero_sm' ); ?></p>
					</div>
				</div>
			</div>
			<div class="rgbc-install-layout__button rgbc-adaptive-font-size">
				<a class="rgbc-install-button el-hover" href="<?php echo esc_url( add_query_arg( [ 'action' => Constants::ACTION_MAIN ], esc_url_raw( $_SERVER['REQUEST_URI'] ) ) ); ?>">
					<?php esc_html_e( 'Let\'s start', 'rgbc_netzero_sm' ); ?>
				</a>
			</div>
		</div>
	</div>
</div>
