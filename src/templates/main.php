<?php

use Rgbcode\Plugins\Netzero_SM\Classes\Constants;
use Rgbcode\Plugins\Netzero_SM\Classes\Helper;

$helper       = Helper::get_instance();
$messages     = $args['flash'][ Constants::FLASH_MESSAGES ] ?? [];
$field_errors = $args['flash'][ Constants::FIELDS_ERRORS ] ?? [];

$total_stat = $args['total_stat'] ?? [];
$total_stat = is_array( $total_stat ) ? $total_stat : [];

$monthly_stat = $args['monthly_stat'] ?? [];
$monthly_stat = is_array( $monthly_stat ) ? $monthly_stat : [];

$last_month_stat = $args['last_month_stat'] ?? [];
$last_month_stat = is_array( $last_month_stat ) ? $last_month_stat : [];

$units_is_imperial = (bool) ( $args['units_is_imperial'] ?? false );

$total_friendly_orders = (int) ( $total_stat['friendly_orders'] ?? 0 );
$total_carbon_reduces  = $units_is_imperial ? (int) ( $total_stat['carbon_reduced_imperial'] ?? 0 ) : (int) ( $total_stat['carbon_reduced'] ?? 0 );
$total_neutral_orders  = (float) ( $total_stat['carbon_neutral_orders'] ?? 0 );

$monthly_friendly_orders = (int) ( $monthly_stat['friendly_orders'] ?? 0 );
$monthly_carbon_reduces  = $units_is_imperial ? (int) ( $monthly_stat['carbon_reduced_imperial'] ?? 0 ) : (int) ( $monthly_stat['carbon_reduced'] ?? 0 );
$monthly_neutral_orders  = (float) ( $monthly_stat['carbon_neutral_orders'] ?? 0 );

$last_month_friendly_orders = (int) ( $last_month_stat['friendly_orders'] ?? 0 );
$last_month_carbon_reduces  = $units_is_imperial ? (int) ( $last_month_stat['carbon_reduced_imperial'] ?? 0 ) : (int) ( $last_month_stat['carbon_reduced'] ?? 0 );
$last_month_neutral_orders  = (float) ( $last_month_stat['carbon_neutral_orders'] ?? 0 );

$trees_absorbing = (int) ( $total_stat['trees_absorbing'] ?? 0 );
$volume_of_fuel  = $units_is_imperial ? (int) ( $total_stat['liters_of_fuel_imperial'] ?? 0 ) : (int) ( $total_stat['liters_of_fuel'] ?? 0 );
$hours_of_flight = (int) ( $total_stat['hours_of_flight'] ?? 0 );

$weight_unit = $units_is_imperial ? esc_html__( 'lbs.', 'rgbc_netzero_sm' ) : esc_html__( 'Kg', 'rgbc_netzero_sm' );
$volume_unit = $units_is_imperial ? esc_html__( 'gallons', 'rgbc_netzero_sm' ) : esc_html__( 'liters', 'rgbc_netzero_sm' );
?>

<div class="rgbc-content-wrapper rgbc-reset">
	<?php
	load_template( RGBC_NETZERO_SM_DIR . '/src/templates/header.php' );
	?>
	<main class="rgbc-main rgbc-main_black">
		<div class="rgbc-main__wrapper">
			<?php load_template( RGBC_NETZERO_SM_DIR . '/src/templates/messages.php', false, [ 'messages' => $messages ] ); ?>
			<div class="rgbc-title-section rgbc-title-section_image">
				<h1 class="rgbc-title-section__title"><?php esc_html_e( 'Thanks for being a true climate hero', 'rgbc_netzero_sm' ); ?></h1>
			</div>
			<div class="rgbc-dashboard">
				<div class="rgbc-dashboard__wrapper">
					<div class="rgbc-dashboard__table-container">
						<h2 class="rgbc-dashboard__table-title"><?php esc_html_e( 'Carbon Offset Contribution', 'rgbc_netzero_sm' ); ?></h2>
						<div class="rgbc-dashboard__table">
							<div class="rgbc-dashboard__table-row">
								<div class="rgbc-dashboard__table-item rgbc-dashboard__table-item_title"><span><?php esc_html_e( 'This Month', 'rgbc_netzero_sm' ); ?></span></div>
								<div class="rgbc-dashboard__table-item rgbc-dashboard__table-item_num"><span><?php echo (int) $monthly_friendly_orders; ?></span></div>
								<div class="rgbc-dashboard__table-item rgbc-dashboard__table-item_num"><span><?php echo (int) $monthly_carbon_reduces; ?> <?php echo esc_html( $weight_unit ); ?></span></div>
								<div class="rgbc-dashboard__table-item rgbc-dashboard__table-item_num"><span><?php echo (float) $monthly_neutral_orders; ?></span></div>
							</div>
							<div class="rgbc-dashboard__table-row">
								<div class="rgbc-dashboard__table-item rgbc-dashboard__table-item_title"><span><?php esc_html_e( 'Last Month', 'rgbc_netzero_sm' ); ?></span></div>
								<div class="rgbc-dashboard__table-item rgbc-dashboard__table-item_num"><span><?php echo (int) $last_month_friendly_orders; ?></span></div>
								<div class="rgbc-dashboard__table-item rgbc-dashboard__table-item_num"><span><?php echo (int) $last_month_carbon_reduces; ?> <?php echo esc_html( $weight_unit ); ?></span></div>
								<div class="rgbc-dashboard__table-item rgbc-dashboard__table-item_num"><span><?php echo (float) $last_month_neutral_orders; ?></span></div>
							</div>
							<div class="rgbc-dashboard__table-row">
								<div class="rgbc-dashboard__table-item rgbc-dashboard__table-item_title"><span><?php esc_html_e( 'Total', 'rgbc_netzero_sm' ); ?></span></div>
								<div class="rgbc-dashboard__table-item rgbc-dashboard__table-item_num"><span><?php echo (int) $total_friendly_orders; ?></span></div>
								<div class="rgbc-dashboard__table-item rgbc-dashboard__table-item_num"><span><?php echo (int) $total_carbon_reduces; ?> <?php echo esc_html( $weight_unit ); ?></span></div>
								<div class="rgbc-dashboard__table-item rgbc-dashboard__table-item_num"><span><?php echo (float) $total_neutral_orders; ?></span></div>
							</div>
							<div class="rgbc-dashboard__table-row">
								<div class="rgbc-dashboard__table-item rgbc-dashboard__table-item_text"><span><?php esc_html_e( 'Climate Friendly Orders', 'rgbc_netzero_sm' ); ?></span></div>
								<div class="rgbc-dashboard__table-item rgbc-dashboard__table-item_text"><span><?php esc_html_e( 'Carbon Dioxide Compensated', 'rgbc_netzero_sm' ); ?></span></div>
								<div class="rgbc-dashboard__table-item rgbc-dashboard__table-item_text"><span><?php esc_html_e( '% of Climate Friendly Orders', 'rgbc_netzero_sm' ); ?></span></div>
							</div>
						</div>
					</div>
					<hr>
					<div class="rgbc-dashboard__advantages-container">
						<div class="rgbc-dashboard__advantages-title">
							<?php
							echo sprintf(
								'%s<span class="rgbc-dashboard__advantages-title-num">%d %s</span>%s',
								esc_html__( 'Since you joined, you and your customers have funded', 'rgbc_netzero_sm' ),
								(int) $total_carbon_reduces,
								esc_attr( $weight_unit ),
								esc_html__( 'of carbon reduction. That’s like:', 'rgbc_netzero_sm' )
							)
							?>
							</div>
						<div class="rgbc-dashboard__advantages">
							<div class="rgbc-dashboard__advantage">
								<div class="rgbc-dashboard__advantage-icon"><img class="rgbc-dashboard__advantage-image" src="<?php echo esc_url( $helper->get_url( 'src/assets/images/spruce.svg' ) ); ?>" alt="<?php esc_html_e( 'spruce', 'rgbc_netzero_sm' ); ?>"></div>
								<div class="rgbc-dashboard__advantage-text">
									<h3 class="rgbc-dashboard__advantage-title"><?php echo (int) $trees_absorbing; ?></h3><span class="rgbc-dashboard__advantage-description"><?php esc_html_e( 'trees absorbing CO2 for a year', 'rgbc_netzero_sm' ); ?></span>
								</div>
							</div>
							<div class="rgbc-dashboard__advantage">
								<div class="rgbc-dashboard__advantage-icon"><img class="rgbc-dashboard__advantage-image" src="<?php echo esc_url( $helper->get_url( 'src/assets/images/car.svg' ) ); ?>" alt="<?php esc_html_e( 'car', 'rgbc_netzero_sm' ); ?>"></div>
								<div class="rgbc-dashboard__advantage-text">
									<h3 class="rgbc-dashboard__advantage-title"><?php echo (int) $volume_of_fuel; ?></h3><span class="rgbc-dashboard__advantage-description"><?php echo esc_html( $volume_unit ); ?><?php esc_html_e( ' of fuel consumption', 'rgbc_netzero_sm' ); ?></span>
								</div>
							</div>
							<div class="rgbc-dashboard__advantage">
								<div class="rgbc-dashboard__advantage-icon"><img class="rgbc-dashboard__advantage-image" src="<?php echo esc_url( $helper->get_url( 'src/assets/images/plane.svg' ) ); ?>" alt="<?php esc_html_e( 'plane', 'rgbc_netzero_sm' ); ?>"></div>
								<div class="rgbc-dashboard__advantage-text">
									<h3 class="rgbc-dashboard__advantage-title"><?php echo (int) $hours_of_flight; ?></h3><span class="rgbc-dashboard__advantage-description"><?php esc_html_e( 'hours of flight', 'rgbc_netzero_sm' ); ?></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="rgbc-prefooter">
			<div class="rgbc-prefooter__units"><span class="rgbc-prefooter__units-title"><?php esc_html_e( 'Units:', 'rgbc_netzero_sm' ); ?></span>
				<div class="rgbc-prefooter__units-checkbox-container"><span class="rgbc-prefooter__unit"><?php esc_html_e( 'Imperial', 'rgbc_netzero_sm' ); ?></span>
					<div class="rgbc-prefooter__unit-checkbox">
						<label class="rgbc-checkbox">
							<input <?php echo ! $units_is_imperial ? 'checked' : ''; ?> data-rgbc-netzero-sm-units-switcher="" class="rgbc-checkbox__input" type="checkbox" name="units"><span class="rgbc-checkbox__line"></span>
						</label>
					</div><span class="rgbc-prefooter__unit"><?php esc_html_e( 'Metric', 'rgbc_netzero_sm' ); ?></span>
				</div>
			</div>
			<div class="rgbc-prefooter__state">
				<ul class="rgbc-prefooter__state-list">
					<li class="rgbc-prefooter__state-item rgbc-prefooter__state-item_<?php echo $helper->widget_is_enabled() ? 'green' : 'red'; ?>"><?php esc_html_e( 'Widget Enabled', 'rgbc_netzero_sm' ); ?></li>
					<li class="rgbc-prefooter__state-item rgbc-prefooter__state-item_green"><?php esc_html_e( 'Carbon offset product exist', 'rgbc_netzero_sm' ); ?></li>
					<li class="rgbc-prefooter__state-item rgbc-prefooter__state-item_green"><?php esc_html_e( 'Version is up to date', 'rgbc_netzero_sm' ); ?></li>
					<li class="rgbc-prefooter__state-item rgbc-prefooter__state-item_<?php echo $helper->email_is_verified() ? 'green' : 'red'; ?>"><?php esc_html_e( 'Email verified', 'rgbc_netzero_sm' ); ?></li>
				</ul>
			</div>
		</div>
	</main>
	<?php
		load_template( RGBC_NETZERO_SM_DIR . '/src/templates/footer.php' );
	?>
</div>
