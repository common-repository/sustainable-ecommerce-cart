<?php
$messages = $args['messages'] ?? [];
$messages = is_array( $messages ) ? $messages : [];

?>

<?php if ( $messages ) { ?>
	<div class="rgbc-messages">
		<ul>
			<?php
			foreach ( $messages as $message ) {
				if ( ! is_array( $message ) ) {
					continue;
				}
				?>
				<li class="rgbc-message-<?php echo esc_attr( $message['type'] ?? 'default' ); ?>"><?php echo esc_html( $message['message'] ?? '' ); ?></li>
			<?php } ?>
		</ul>
	</div>
<?php } ?>
