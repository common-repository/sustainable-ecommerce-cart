<?php
$field_errors = $args['field_errors'] ?? [];
$field_errors = is_array( $field_errors ) ? $field_errors : [];
?>

<?php if ( $field_errors ) { ?>
	<div class="rgbc-field-error">
		<ul>
			<?php foreach ( $field_errors as $error_ ) { ?>
				<li class="rgbc-field-error__item"><?php echo esc_html( $error_ ); ?></li>
			<?php } ?>
		</ul>
	</div>
<?php } ?>
