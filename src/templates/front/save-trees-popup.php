<?php
use Rgbcode\Plugins\Netzero_SM\Classes\Constants;
use Rgbcode\Plugins\Netzero_SM\Classes\Helper;

$helper = Helper::get_instance();

$css_file_path = glob( RGBC_NETZERO_SM_DIR . '/build/widget/widget.min.*.css' );
$css_file_path = $css_file_path ? $css_file_path[0] : false;
$css_file_url  = RGBC_NETZERO_SM_URL . '/build/widget/' . basename( $css_file_path );
?>
<netzero-widget-popup></netzero-widget-popup>

<template id="netzero-widget-popup" data-css-file-url="<?php echo esc_url( $css_file_url ); ?>">
<div class="rgbc-widget-popup rgbc-widget__popup js-rgbc-widget-popup-wrapper <?php echo is_rtl() ? 'rtl' : ''; ?>">
	<div class="rgbc-widget-popup__popup">
		<div class="rgbc-widget-popup__close js-rgbc-widget-close el-hover"><svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M0 15.0001C0 6.71585 6.71573 0.00012207 15 0.00012207C23.2843 0.00012207 30 6.71585 30 15.0001C30 23.2844 23.2843 30.0001 15 30.0001C6.71573 30.0001 0 23.2844 0 15.0001ZM20.293 21.7073L15.0001 16.4144L9.70718 21.7073L8.29297 20.2931L13.5859 15.0002L8.29297 9.7073L9.70718 8.29309L15.0001 13.586L20.293 8.29309L21.7072 9.7073L16.4143 15.0002L21.7072 20.2931L20.293 21.7073Z" fill="#09CC62"/>
			</svg>
		</div>
		<div class="rgbc-widget-popup__title-container">
			<div class="rgbc-widget-popup__title-icon"><svg width="61" height="58" viewBox="0 0 61 58" fill="none" xmlns="http://www.w3.org/2000/svg">
					<g clip-path="url(#clip0_425_1159)">
						<path d="M45.7299 40.0353C46.0412 40.0603 46.3312 40.0727 46.6134 40.0727C53.5943 40.0727 59.2737 34.3411 59.2737 27.296C59.2737 20.2509 53.5943 14.5192 46.6134 14.5192C45.8277 14.5192 45.0476 14.593 44.28 14.7381C43.7978 7.48989 37.8015 1.74243 30.5001 1.74243C23.1988 1.74243 17.2025 7.48989 16.7202 14.7381C15.9527 14.593 15.1726 14.5192 14.3869 14.5192C7.406 14.5192 1.72656 20.2509 1.72656 27.296C1.72656 34.3411 7.406 40.0727 14.3869 40.0727C14.669 40.0727 14.9591 40.0603 15.2704 40.0353H45.7299Z" stroke="#09CC62" stroke-width="3" stroke-miterlimit="10"/>
						<path d="M23.1875 32.693L30.5 41.1255" stroke="#09CC62" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M37.8125 32.693L30.5 41.1255V56.2579" stroke="#09CC62" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M37.8126 56.2578H23.1875" stroke="#09CC62" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
					</g>
					<defs>
						<clipPath id="clip0_425_1159">
							<rect width="61" height="58" fill="white"/>
						</clipPath>
					</defs>
				</svg>
			</div>
			<h2 class="rgbc-widget-popup__title"><?php esc_html_e( 'You can make a difference!', 'rgbc_netzero_sm' ); ?></h2>
			<p class="rgbc-widget-popup__description"><?php esc_html_e( 'Every purchase has a climate impact due to production & shipping.', 'rgbc_netzero_sm' ); ?></p>
		</div>
		<div class="rgbc-widget-popup__body">
			<p class="rgbc-widget-popup__body-title"><?php esc_html_e( 'You can significantly reduce the carbon footprint of this order by adding a certified carbon offset to your cart. Together we can:', 'rgbc_netzero_sm' ); ?>
				<span class="rgbc-widget-popup__body-title-mobile">
						<?php esc_html_e( 'Protect existing forests', 'rgbc_netzero_sm' ); ?>,
						<?php esc_html_e( 'Plant new forests', 'rgbc_netzero_sm' ); ?>,
						<?php esc_html_e( 'Promote clean energy', 'rgbc_netzero_sm' ); ?>
					</span>
			</p>
			<div class="rgbc-widget-popup__advantages">
				<div class="rgbc-widget-popup__advantage">
					<div class="rgbc-widget-popup__advantage-bg"><img class="rgbc-widget-popup__advantage-image" src="<?php echo esc_url( $helper->get_url( 'src/assets/images/widget-adv-1.png' ) ); ?>"></div>
					<h3 class="rgbc-widget-popup__advantage-title"><?php esc_html_e( 'Protect existing forests', 'rgbc_netzero_sm' ); ?></h3>
				</div>
				<div class="rgbc-widget-popup__advantage">
					<div class="rgbc-widget-popup__advantage-bg"><img class="rgbc-widget-popup__advantage-image" src="<?php echo esc_url( $helper->get_url( 'src/assets/images/widget-adv-2.png' ) ); ?>"></div>
					<h3 class="rgbc-widget-popup__advantage-title"><?php esc_html_e( 'Plant new forests', 'rgbc_netzero_sm' ); ?></h3>
				</div>
				<div class="rgbc-widget-popup__advantage">
					<div class="rgbc-widget-popup__advantage-bg"><img class="rgbc-widget-popup__advantage-image" src="<?php echo esc_url( $helper->get_url( 'src/assets/images/widget-adv-3.png' ) ); ?>"></div>
					<h3 class="rgbc-widget-popup__advantage-title"><?php esc_html_e( 'Promote clean energy', 'rgbc_netzero_sm' ); ?></h3>
				</div>
			</div>
			<div class="rgbc-widget-popup__button-container">
				<p class="rgbc-widget-popup__button-title"><?php esc_html_e( 'Join thousands of climate-conscious shoppers acting for a better future', 'rgbc_netzero_sm' ); ?></p>
				<button class="rgbc-widget-popup__button js-rgbc-widget-close el-hover"><?php echo esc_html__( 'Close', 'rgbc_netzero_sm' ); ?></button>
			</div>
		</div>
		<div class="rgbc-widget-popup__footer">
			<div class="rgbc-widget-popup__footer-title">
				<?php
				echo sprintf(
					'%s&nbsp;<a target="_blank" class="rgbc-widget-popup__footer-link el-hover" href="%s">%s</a>&nbsp;%s',
					esc_html__( 'You can', 'rgbc_netzero_sm' ),
					esc_url( Constants::SITE_URL . '/carbon-offset-projects' ),
					esc_html__( 'read more', 'rgbc_netzero_sm' ),
					esc_html__( 'about the projects supported by', 'rgbc_netzero_sm' )
				)
				?>
			</div>
			<div class="rgbc-widget-popup__footer-logo"><svg width="97" height="18" viewBox="0 0 97 18" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M11.8888 9.15091V17.2297H9.60998V9.28261C9.60998 7.12479 8.379 5.91433 6.36235 5.91433C4.26692 5.91433 2.56448 7.15108 2.56448 10.2562V17.2297H0.285645V4.07219H2.56448V5.96689C3.53357 4.41445 4.97412 3.73022 6.80736 3.73022C9.87187 3.73022 11.8888 5.78262 11.8888 9.15091Z" fill="#EAEAEA"/>
					<path d="M19.9919 15.4138C21.799 15.4138 23.1087 14.5719 23.7633 13.4928L25.7017 14.5982C24.5493 16.3877 22.5585 17.5716 19.9393 17.5716C15.7225 17.5716 12.9199 14.5982 12.9199 10.6511C12.9199 6.75625 15.6964 3.73022 19.7823 3.73022C23.7371 3.73022 26.304 6.99309 26.304 10.6774C26.304 11.0193 26.2779 11.3616 26.2255 11.7035H15.2511C15.6964 14.0719 17.5561 15.4138 19.9919 15.4138ZM15.2511 9.70372H23.999C23.6063 7.09851 21.7466 5.88804 19.7823 5.88804C17.3203 5.88804 15.6176 7.4142 15.2511 9.70372Z" fill="#EAEAEA"/>
					<path d="M27.2412 4.07216V1.07241L29.5198 0.388184V4.07216H33.0034V6.28283H29.5198V13.4139C29.5198 15.4138 30.6723 15.2824 33.0034 15.1769V17.2296C29.0747 17.7559 27.2412 16.7034 27.2412 13.4139V4.07216Z" fill="#EAEAEA"/>
					<path d="M44.2049 15.0456V17.2297H34.1211V15.7036L40.8001 6.25636H34.383V4.07227H43.943V5.59871L37.2379 15.0456H44.2049H44.2049Z" fill="#EAEAEA"/>
					<path d="M51.6481 15.4138C53.4552 15.4138 54.765 14.5719 55.4195 13.4928L57.358 14.5982C56.2055 16.3877 54.2147 17.5716 51.5955 17.5716C47.3788 17.5716 44.5762 14.5982 44.5762 10.6511C44.5762 6.75625 47.3526 3.73022 51.4385 3.73022C55.3934 3.73022 57.9603 6.99309 57.9603 10.6774C57.9603 11.0193 57.9341 11.3616 57.8818 11.7035H46.9073C47.3526 14.0719 49.2123 15.4138 51.6481 15.4138ZM46.9073 9.70372H55.6553C55.2626 7.09851 53.4029 5.88804 51.4385 5.88804C48.9766 5.88804 47.2739 7.4142 46.9073 9.70372Z" fill="#EAEAEA"/>
					<path d="M65.3721 3.83545V6.2301C63.4077 6.15126 61.2862 7.15117 61.2862 10.2563V17.2297H59.0073V4.07229H61.2862V6.28296C62.1242 4.44083 63.722 3.83545 65.3721 3.83545Z" fill="#EAEAEA"/>
					<path class="rgbc-path-green" d="M77.9681 6.68832C78.743 7.80327 79.1942 9.16317 79.1942 10.651C79.1942 14.5479 76.1015 17.571 72.2774 17.571C71.5242 17.571 70.8001 17.4541 70.1234 17.2347C67.9875 16.5475 66.3211 14.8513 65.6807 12.6725C65.4915 12.0365 65.3896 11.3565 65.3896 10.651C65.3896 6.75778 68.4569 3.73096 72.2774 3.73096C73.4854 3.73096 74.6242 4.03436 75.6139 4.57174L74.2749 4.84957L74.0457 6.30083C73.5036 6.08514 72.9105 5.96818 72.2774 5.96818C69.6868 5.96818 67.671 7.99338 67.671 10.651C67.671 11.0202 67.7074 11.3748 67.7838 11.7148C68.1586 13.4622 69.4539 14.7891 71.1458 15.2022C71.506 15.29 71.8844 15.3338 72.2774 15.3338C74.8971 15.3338 76.9165 13.3086 76.9165 10.651C76.9165 9.80656 76.7091 9.02426 76.3453 8.35162L76.2798 8.42473L76.0324 9.99664L74.0312 9.68226L74.4169 7.233L74.5005 6.7066L74.5296 6.52748L74.5478 6.39222L74.7371 5.22974L75.3556 5.11276L76.0214 4.98482L76.2252 4.94825L76.9384 4.813L79.1397 4.39625L79.5181 6.39588L77.9681 6.68832H77.9681Z" fill="#09CC62"/>
					<path d="M79.8984 15.2721L81.1503 14.6189C81.3309 15.4413 81.9208 16.0097 83.0644 16.0097C84.0635 16.0097 84.6655 15.5744 84.7979 14.9454C84.9785 14.1352 84.1599 13.8326 83.1848 13.5062C81.9328 13.0828 80.705 12.4298 81.006 10.809C81.2828 9.24888 82.6912 8.57153 84.0034 8.57153C85.424 8.57153 86.3628 9.33361 86.748 10.4222L85.5322 11.0631C85.2795 10.3978 84.822 9.91403 83.8951 9.91403C83.1487 9.91403 82.5348 10.2769 82.4024 10.9059C82.2338 11.7041 83.0042 12.0186 83.9673 12.3571C85.0869 12.7563 86.5434 13.3006 86.2064 15.0784C85.9295 16.6024 84.6053 17.3522 82.9682 17.3522C81.2708 17.3522 80.2114 16.5418 79.8984 15.2721V15.2721Z" fill="#EAEAEA"/>
					<path d="M94.9487 17.195H93.5644L94.6238 11.1718L91.3013 15.4171H91.1327L89.339 11.0509L88.2677 17.195H86.8833L88.3639 8.72876H89.8206L91.554 13.0224L94.8525 8.72876H96.4294L94.9487 17.195Z" fill="#EAEAEA"/>
				</svg>
			</div>
		</div>
	</div>
</div>
</template>
