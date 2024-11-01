<?php
$deactivation_reason_list = [
	[
		'label' => esc_html__( 'The plugin is not functioning.', 'rgbc_netzero_sm' ),
		'value' => 'The plugin is not functioning.',
	],
	[
		'label' => esc_html__( 'Design and customization issues.', 'rgbc_netzero_sm' ),
		'value' => 'Design and customization issues.',
	],
	[
		'label' => esc_html__( 'The plugin creates technical issues on my website.', 'rgbc_netzero_sm' ),
		'value' => 'The plugin creates technical issues on my website.',
	],
	[
		'label' => esc_html__( 'Your support team didn\'t help me / didn\'t respond to me.', 'rgbc_netzero_sm' ),
		'value' => 'Your support team didn\'t help me / didn\'t respond to me.',
	],
	[
		'label' => esc_html__( 'I found a better alternative.', 'rgbc_netzero_sm' ),
		'value' => 'I found a better alternative.',
	],
	[
		'label' => esc_html__( 'Temporary deactivation. I\'ll reactivate it soon.', 'rgbc_netzero_sm' ),
		'value' => 'Temporary deactivation. I\'ll reactivate it soon.',
	],
	[
		'label' => esc_html__( 'Other', 'rgbc_netzero_sm' ),
		'value' => 'Other',
	],
];
?>

<div id="netzero-sm-deactivation-modal" class="netzero-sm-deactivation-modal__overlay">
	<div class="netzero-sm-deactivation-modal__modal">
		<h2><?php echo esc_html__( 'Deactivating the Sustainable eCommerce Cart - Survey', 'rgbc_netzero_sm' ); ?></h2>
		<p>
			<?php
			echo esc_html__(
				'We would appreciate it if you could take a moment for this one-question survey and let us know why you are deactivating the plugin. 
				This is an optional survey, but your feedback means a lot to us. You can choose multiple answers:',
				'rgbc_netzero_sm'
			);
			?>
		</p>
		<ul>
			<?php
			foreach ( $deactivation_reason_list as $k => $v ) {
				?>
				<li>
					<input data-nezero-sm-deactivation-reason="<?php echo esc_attr( $v['value'] ?? '' ); ?>" id="netzero-sm-deactivation-reason-<?php echo esc_attr( $k ); ?>" type="checkbox">
					<label for="netzero-sm-deactivation-reason-<?php echo esc_attr( $k ); ?>"><?php echo esc_html( $v['label'] ?? '' ); ?></label>
				</li>
			<?php } ?>
		</ul>
		<div class="netzero-sm-deactivation-modal__buttons_group">
			<button class="button action" data-netzero-sm-stay-active=""><?php echo esc_html__( 'Stay Active', 'rgbc_netzero_sm' ); ?></button>
			<button class="button action" data-netzero-sm-submit-deactivate=""><?php echo esc_html__( 'Submit & Deactivate', 'rgbc_netzero_sm' ); ?></button>
		</div>
	</div>
</div>
