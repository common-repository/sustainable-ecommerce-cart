<?php
use Rgbcode\Plugins\Netzero_SM\Classes\Helper;

$helper = Helper::get_instance();

$fee            = $args['fee'] ?? 0;
$is_enabled     = $args['is_enabled'] ?? false;
$is_checkout    = $args['is_checkout'] ?? false;
$classes        = $args['classes'] ?? [];
$classes        = is_array( $classes ) ? $classes : [];
$widget_classes = $args['widget_classes'] ?? [];
$widget_classes = is_array( $widget_classes ) ? $widget_classes : [];
$widget_color   = $helper->get_widget_color();

$css_file_path = glob( RGBC_NETZERO_SM_DIR . '/build/widget/widget.min.*.css' );
$css_file_path = $css_file_path ? $css_file_path[0] : false;
$css_file_url  = RGBC_NETZERO_SM_URL . '/build/widget/' . basename( $css_file_path );
$widget_id     = md5( uniqid( 'netzero', true ) );
?>

<netzero-widget style="display: none;" data-widget-id="<?php echo esc_attr( $widget_id ); ?>"></netzero-widget>

<template id="<?php echo esc_attr( $widget_id ); ?>" data-css-file-url="<?php echo esc_url( $css_file_url ); ?>">
	<div class="rgbc-widget-container rgbc-reset <?php echo esc_attr( implode( ' ', $classes ) ); ?> <?php echo is_rtl() ? 'rtl' : ''; ?>">
		<div class='rgbc-widget-wrapper'>
			<div class="rgbc-widget <?php echo esc_attr( implode( ' ', $widget_classes ) ); ?> <?php echo esc_attr( $widget_color ? "rgbc-widget_$widget_color" : '' ); ?>">
				<div class="rgbc-widget__icon">
					<svg width="61" height="58" viewBox="0 0 61 58" fill="none" xmlns="http://www.w3.org/2000/svg">
						<g clip-path="url(#clip0_469_861)">
							<path d="M45.7298 40.0352C46.0411 40.0602 46.3311 40.0726 46.6132 40.0726C53.5942 40.0726 59.2736 34.341 59.2736 27.2958C59.2736 20.2507 53.5942 14.5191 46.6132 14.5191C45.8276 14.5191 45.0475 14.5928 44.2799 14.738C43.7977 7.48976 37.8014 1.74231 30.5 1.74231C23.1987 1.74231 17.2024 7.48976 16.7201 14.738C15.9526 14.5928 15.1724 14.5191 14.3868 14.5191C7.40587 14.5191 1.72644 20.2507 1.72644 27.2958C1.72644 34.341 7.40587 40.0726 14.3868 40.0726C14.6689 40.0726 14.9589 40.0602 15.2703 40.0352H45.7298Z" stroke="#09CC62" stroke-width="3" stroke-miterlimit="10"/>
							<path d="M23.1874 32.6929L30.5 41.1254" stroke="#09CC62" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M37.8125 32.6929L30.5 41.1254V56.2578" stroke="#09CC62" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M37.8125 56.2577H23.1874" stroke="#09CC62" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
						</g>
						<defs>
							<clipPath id="clip0_469_861">
								<rect width="61" height="58" fill="white"/>
							</clipPath>
						</defs>
					</svg>
				</div>
				<div class="rgbc-widget__left-side">
					<div class="rgbc-widget__title-container">
						<h3 class="rgbc-widget__title"><?php esc_html_e( 'Make This Order More Sustainable!', 'rgbc_netzero_sm' ); ?></h3>
						<div class="rgbc-widget__logo-container"><span class="rgbc-widget__logo-title"><?php esc_html_e( 'Powered by', 'rgbc_netzero_sm' ); ?></span>
							<div class="rgbc-widget__logo"><svg width="75" height="14" viewBox="0 0 75 14" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M9.02469 7.45058V13.7341H7.25226V7.55302C7.25226 5.87472 6.29483 4.93324 4.72632 4.93324C3.09655 4.93324 1.77243 5.89516 1.77243 8.31029V13.7341H0V3.50047H1.77243V4.97413C2.52616 3.76668 3.64659 3.2345 5.07244 3.2345C7.45595 3.2345 9.02469 4.8308 9.02469 7.45058Z" fill="#0B2027"/>
									<path d="M15.3268 12.3217C16.7323 12.3217 17.751 11.6669 18.2601 10.8276L19.7678 11.6873C18.8715 13.0792 17.3231 14 15.2859 14C12.0062 14 9.82642 11.6873 9.82642 8.61737C9.82642 5.58807 11.9859 3.2345 15.1638 3.2345C18.2398 3.2345 20.2363 5.77228 20.2363 8.63782C20.2363 8.90379 20.2159 9.17 20.1752 9.43597H11.6395C11.9859 11.278 13.4323 12.3217 15.3268 12.3217ZM11.6395 7.88055H18.4435C18.1381 5.85427 16.6916 4.9128 15.1638 4.9128C13.249 4.9128 11.9246 6.09981 11.6395 7.88055Z" fill="#0B2027"/>
									<path d="M20.9653 3.50044V1.16731L22.7375 0.635132V3.50044H25.447V5.21986H22.7375V10.7663C22.7375 12.3217 23.6339 12.2195 25.447 12.1375V13.734C22.3914 14.1433 20.9653 13.3247 20.9653 10.7663V3.50044Z" fill="#0B2027"/>
									<path d="M34.1594 12.0353V13.7341H26.3164V12.5471L31.5112 5.19923H26.5201V3.50049H33.9557V4.68772L28.7406 12.0353H34.1594H34.1594Z" fill="#0B2027"/>
									<path d="M39.9487 12.3217C41.3542 12.3217 42.3729 11.6669 42.882 10.8276L44.3897 11.6873C43.4933 13.0792 41.9449 14 39.9078 14C36.6281 14 34.4483 11.6873 34.4483 8.61737C34.4483 5.58807 36.6078 3.2345 39.7857 3.2345C42.8617 3.2345 44.8581 5.77228 44.8581 8.63782C44.8581 8.90379 44.8378 9.17 44.7971 9.43597H36.2614C36.6078 11.278 38.0542 12.3217 39.9487 12.3217ZM36.2614 7.88055H43.0654C42.76 5.85427 41.3135 4.9128 39.7857 4.9128C37.8709 4.9128 36.5465 6.09981 36.2614 7.88055Z" fill="#0B2027"/>
									<path d="M50.6228 3.31628V5.17879C49.095 5.11747 47.4449 5.89518 47.4449 8.31031V13.7341H45.6725V3.50049H47.4449V5.21991C48.0967 3.78714 49.3394 3.31628 50.6228 3.31628Z" fill="#0B2027"/>
									<path class="rgbc-path-green" d="M60.4197 5.53516C61.0225 6.40234 61.3734 7.46004 61.3734 8.61724C61.3734 11.6481 58.9679 13.9995 55.9936 13.9995C55.4078 13.9995 54.8446 13.9085 54.3183 13.7379C52.6571 13.2034 51.361 11.8841 50.8629 10.1895C50.7157 9.69482 50.6365 9.16598 50.6365 8.61724C50.6365 5.58918 53.0221 3.23499 55.9936 3.23499C56.9332 3.23499 57.8189 3.47096 58.5887 3.88893L57.5473 4.10502L57.369 5.23378C56.9473 5.06602 56.486 4.97505 55.9936 4.97505C53.9787 4.97505 52.4109 6.5502 52.4109 8.61724C52.4109 8.9044 52.4392 9.1802 52.4986 9.44462C52.7901 10.8037 53.7976 11.8358 55.1135 12.1571C55.3937 12.2253 55.688 12.2594 55.9936 12.2594C58.0312 12.2594 59.6018 10.6843 59.6018 8.61724C59.6018 7.96045 59.4405 7.352 59.1575 6.82883L59.1066 6.8857L58.9141 8.10829L57.3577 7.86377L57.6576 5.9588L57.7227 5.54937L57.7454 5.41006L57.7595 5.30486L57.9067 4.40071L58.3878 4.30972L58.9056 4.21021L59.0641 4.18177L59.6188 4.07657L61.3309 3.75244L61.6252 5.3077L60.4197 5.53516H60.4197Z" fill="#09CC62"/>
									<path d="M61.9209 12.2115L62.8946 11.7035C63.0351 12.3431 63.4938 12.7853 64.3833 12.7853C65.1604 12.7853 65.6286 12.4466 65.7316 11.9574C65.872 11.3273 65.2354 11.092 64.477 10.838C63.5032 10.5087 62.5482 10.0009 62.7823 8.74022C62.9976 7.52683 64.0931 7 65.1136 7C66.2185 7 66.9488 7.59273 67.2484 8.43937L66.3027 8.93791C66.1061 8.4204 65.7503 8.04416 65.0294 8.04416C64.4489 8.04416 63.9714 8.32638 63.8684 8.8156C63.7373 9.43644 64.3365 9.68106 65.0856 9.9443C65.9563 10.2548 67.0892 10.6781 66.8271 12.0609C66.6117 13.2462 65.5818 13.8294 64.3085 13.8294C62.9883 13.8294 62.1643 13.1991 61.9209 12.2115V12.2115Z" fill="#0B2027"/>
									<path d="M73.6267 13.7071H72.55L73.374 9.02245L70.7898 12.3243H70.6588L69.2636 8.92843L68.4304 13.7071H67.3536L68.5052 7.12231H69.6382L70.9864 10.4618L73.5519 7.12231H74.7784L73.6267 13.7071Z" fill="#0B2027"/>
								</svg>
							</div>
						</div>
					</div>
					<div class="rgbc-widget__description-container">
						<div class="rgbc-widget__description-icon el-hover">
							<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M9.1739 14.95C8.8977 14.95 8.6739 14.7261 8.6739 14.45V8.58643C8.6739 8.31023 8.8977 8.08643 9.1739 8.08643H10.8202C11.0963 8.08643 11.3202 8.31023 11.3202 8.58643V14.45C11.3202 14.4673 11.3193 14.4843 11.3176 14.5011C11.292 14.7533 11.079 14.95 10.8202 14.95H9.1739Z" fill="#0B2027"/>
								<path d="M9.99699 6.81933C9.63909 6.81933 9.33219 6.70108 9.07659 6.46457C8.82089 6.22807 8.69299 5.94362 8.69299 5.61123C8.69299 5.27885 8.82089 4.9944 9.07659 4.75789C9.33219 4.52139 9.63909 4.40314 9.99699 4.40314C10.3582 4.40314 10.665 4.52139 10.9175 4.75789C11.1731 4.9944 11.301 5.27885 11.301 5.61123C11.301 5.94362 11.1731 6.22807 10.9175 6.46457C10.665 6.70108 10.3582 6.81933 9.99699 6.81933Z" fill="#0B2027"/>
								<path fill-rule="evenodd" clip-rule="evenodd" d="M20 10C20 15.5228 15.5228 20 10 20C4.47715 20 0 15.5228 0 10C0 4.47715 4.47715 0 10 0C15.5228 0 20 4.47715 20 10ZM17.5 10C17.5 14.1421 14.1421 17.5 10 17.5C5.85787 17.5 2.5 14.1421 2.5 10C2.5 5.85787 5.85787 2.5 10 2.5C14.1421 2.5 17.5 5.85787 17.5 10Z" fill="#0B2027"/>
							</svg>
						</div>
						<div class="rgbc-widget__description">
							<p class="rgbc-widget__description-paragraph"><?php esc_html_e( 'By contributing, you reduce the carbon footprint of this order caused by shipping and manufacturing. Support the highest standard of carbon offset projects in the fight against climate change.', 'rgbc_netzero_sm' ); ?></p>
							<button type="button" class="rgbc-widget__description-link js-rgbc-widget-link el-hover"><?php esc_html_e( 'Learn More', 'rgbc_netzero_sm' ); ?></button>
						</div>
					</div>
				</div>
				<div class='rgbc-widget__right-side'>
					<div class="rgbc-widget__price-container">
                        <span class="rgbc-widget__price"><?php echo wc_price( $fee ); //phpcs:ignore ?></span>
					</div>
					<div class="rgbc-widget__checkbox-container">
						<label class="rgbc-widget-checkbox">
							<input autocomplete="off" <?php echo $is_enabled ? 'checked' : ''; ?> data-netzero-sm-widget-checkbox="" class="rgbc-widget-checkbox__input" type="checkbox">
							<div class="rgbc-widget-checkbox__line">
								<div class="rgbc-widget-checkbox__handle"></div>
							</div>
						</label>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
