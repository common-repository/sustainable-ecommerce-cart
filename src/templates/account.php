<?php

use Rgbcode\Plugins\Netzero_SM\Classes\Helper;

$helper = Helper::get_instance();

$this_month_stat = $args['this_month_stat'] ?? [];
$this_month_stat = is_array( $this_month_stat ) ? $this_month_stat : [];

$last_month_stat = $args['last_month_stat'] ?? [];
$last_month_stat = is_array( $last_month_stat ) ? $last_month_stat : [];

$this_year_stat = $args['this_year_stat'] ?? [];
$this_year_stat = is_array( $this_year_stat ) ? $this_year_stat : [];

$this_month_donation_sum = ( $this_month_stat['donations_sum'] ?? 0 );
$last_month_donation_sum = ( $last_month_stat['donations_sum'] ?? 0 );
$this_year_donation_sum  = ( $this_year_stat['donations_sum'] ?? 0 );

?>

<div class="rgbc-content-wrapper rgbc-reset">
	<?php
	load_template( RGBC_NETZERO_SM_DIR . '/src/templates/header.php' );
	?>
	<main class="rgbc-main">
		<div class="rgbc-main__wrapper">
			<div class="rgbc-title-section rgbc-title-section_fit rgbc-title-section_note">
				<h1 class="rgbc-title-section__title"><?php esc_html_e( 'Financial Overview & Billing Information', 'rgbc_netzero_sm' ); ?></h1>
				<p class="rgbc-title-section__description"><?php esc_html_e( 'Here you can see the amount of money your customers paid for carbon offset contribution. At the end of each month, we send you an invoice for the same amount of carbon offset contribution you collected during the last month.', 'rgbc_netzero_sm' ); ?></p>
				<div class="rgbc-title-section__table-container">
					<h2 class="rgbc-title-section__table-title"><?php esc_html_e( 'Your customers have paid', 'rgbc_netzero_sm' ); ?></h2>
					<div class="rgbc-title-section__table">
						<div class="rgbc-title-section__table-item">
							<h3 class="rgbc-title-section__table-item-value"><?php echo esc_attr( "\$$this_month_donation_sum" ); ?></h3>
							<h4 class="rgbc-title-section__table-item-title"><?php esc_html_e( 'This month', 'rgbc_netzero_sm' ); ?></h4>
						</div>
						<div class="rgbc-title-section__table-item">
							<h3 class="rgbc-title-section__table-item-value"><?php echo esc_attr( "\$$last_month_donation_sum" ); ?></h3>
							<h4 class="rgbc-title-section__table-item-title"><?php esc_html_e( 'Last month', 'rgbc_netzero_sm' ); ?></h4>
						</div>
						<div class="rgbc-title-section__table-item">
							<h3 class="rgbc-title-section__table-item-value"><?php echo esc_attr( "\$$this_year_donation_sum" ); ?></h3>
							<h4 class="rgbc-title-section__table-item-title"><?php esc_html_e( 'This year', 'rgbc_netzero_sm' ); ?></h4>
						</div>
					</div>
					<h2 class="rgbc-title-section__table-title"><?php esc_html_e( 'for carbon offset contributions.', 'rgbc_netzero_sm' ); ?></h2>
				</div>
				<div class='rgbc-title-section__note'>
					<?php esc_html_e( '** These figures represent a reasonable estimation of the carbon offset contributions. Small differences can occur due to servers delays and multi-currency calculation. The final amount(s) will be presented on your monthly invoice.', 'rgbc_netzero_sm' ); ?>
				</div>
			</div>
			<div class="rgbc-account">
				<div class="rgbc-account__title-container">
					<h2 class="rgbc-account__title"><?php esc_html_e( 'Choose your favorite payment method', 'rgbc_netzero_sm' ); ?></h2>
					<p class="rgbc-account__description"><?php esc_html_e( 'Complete your payment by the 10th of each month for the entire balance of the previous month. Check your invoice for detailed instructions. We accept the following payment methods:', 'rgbc_netzero_sm' ); ?></p>
				</div>
				<div class="rgbc-account__items">
					<div class="rgbc-account__item">
						<div class="rgbc-account__item-icon"><img class="rgbc-account__item-image" src="<?php echo esc_url( $helper->get_url( 'src/assets/images/paypal.svg' ) ); ?>"></div>
						<h3 class="rgbc-account__item-title"><?php esc_html_e( 'PayPal', 'rgbc_netzero_sm' ); ?></h3>
						<div class="rgbc-account__item-content"><a class="rgbc-account__item-phone el-hover" href="#">billing@netzerosm.com</a></div>
					</div>
					<div class="rgbc-account__item">
						<div class="rgbc-account__item-icon"><img class="rgbc-account__item-image" src="<?php echo esc_url( $helper->get_url( 'src/assets/images/terminal.svg' ) ); ?>"></div>
						<h3 class="rgbc-account__item-title"><?php esc_html_e( 'Bank transfer', 'rgbc_netzero_sm' ); ?></h3>
						<div class="rgbc-account__item-content">
							<div class="rgbc-account__item-text"><?php esc_html_e( 'Name:', 'rgbc_netzero_sm' ); ?> NET ZERO SM LTD</div>
							<div class="rgbc-account__item-text"><?php esc_html_e( 'Iban:', 'rgbc_netzero_sm' ); ?> IL170108000000012612345</div>
						</div>
					</div>
					<div class="rgbc-account__item">
						<div class="rgbc-account__item-icon"><img class="rgbc-account__item-image" src="<?php echo esc_url( $helper->get_url( 'src/assets/images/wallet.svg' ) ); ?>"></div>
						<h3 class="rgbc-account__item-title"><?php esc_html_e( 'Credit card', 'rgbc_netzero_sm' ); ?></h3>
						<div class="rgbc-account__item-content"><a class="rgbc-account__item-link el-hover" href="#"><?php esc_html_e( 'Click here', 'rgbc_netzero_sm' ); ?></a></div>
					</div>
				</div>
				<div class="rgbc-account__lower-side">
					<p class="rgbc-account__lower-side-text"><?php esc_html_e( 'For your reciept, please send us payment confirmation to:', 'rgbc_netzero_sm' ); ?>&nbsp;<a class="rgbc-account__lower-side-link rgbc-link el-hover" href="mailto:billing@netzerosm.com">billing@netzerosm.com</a></p>
				</div>
			</div>
		</div>
	</main>
	<?php
	load_template( RGBC_NETZERO_SM_DIR . '/src/templates/footer.php' );
	?>
</div>
