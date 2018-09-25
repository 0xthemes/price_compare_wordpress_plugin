<?php

echo '<h2 class="fonts-page-title">'. esc_html__( 'Compare Payment.', 'comparepayment' ) .'</h2>';

if ( isset( $_POST['cp-form-save'] ) ) {
	
	$payment_currency = isset( $_POST['payment_currency'] ) ? $_POST['payment_currency'] : '';
	$range_min = isset( $_POST['range_min'] ) ? $_POST['range_min'] : '';
	$range_max = isset( $_POST['range_max'] ) ? $_POST['range_max'] : '';
	$range_step = isset( $_POST['range_step'] ) ? $_POST['range_step'] : '';
	$range_value = isset( $_POST['range_value'] ) ? $_POST['range_value'] : '';
	
	$cp_arr = array(
		'payment_currency' => esc_attr( $payment_currency ),
		'range_min' => esc_attr( $range_min ),
		'range_max' => esc_attr( $range_max ),
		'range_step' => esc_attr( $range_step ),
		'range_value' => esc_attr( $range_value )
	);
	
	update_option('compare_payment_values', $cp_arr );
}


?>
<div class="compare-payment-admin-wrap">
	
	<?php
		$cp_values = get_option( 'compare_payment_values' );
		$payment_currency = isset( $cp_values['payment_currency'] ) ? $cp_values['payment_currency'] : '';
		$range_min = isset( $cp_values['range_min'] ) ? $cp_values['range_min'] : '';
		$range_max = isset( $cp_values['range_max'] ) ? $cp_values['range_max'] : '';
		$range_step = isset( $cp_values['range_step'] ) ? $cp_values['range_step'] : '';
		$range_value = isset( $cp_values['range_value'] ) ? $cp_values['range_value'] : '';
	?>
	
	<form class="compare-payment-form" action="#" method="post" enctype="multipart/form-data">
		<div class="form-group">
			<label for="payment_currency"><?php esc_html_e( 'Payment Currency', 'comparepayment' ); ?></label>
			<input class="form-control" type="text" name="payment_currency" value="<?php echo esc_attr( $payment_currency ); ?>" placeholder="$">
		</div>
		<div class="form-group">
			<label for="range_min"><?php esc_html_e( 'Range Slider Minimum Value', 'comparepayment' ); ?></label>
			<input class="form-control" type="text" name="range_min" value="<?php echo esc_attr( $range_min ); ?>" placeholder="1">
		</div>
		<div class="form-group">
			<label for="range_max"><?php esc_html_e( 'Range Slider Maximum Value', 'comparepayment' ); ?></label>
			<input class="form-control" type="text" name="range_max" value="<?php echo esc_attr( $range_max ); ?>" placeholder="200">
		</div>
		<div class="form-group">
			<label for="range_step"><?php esc_html_e( 'Range Step Value', 'comparepayment' ); ?></label>
			<input class="form-control" type="text" name="range_step" value="<?php echo esc_attr( $range_step ); ?>" placeholder="1">
		</div>
		<div class="form-group">
			<label for="range_value"><?php esc_html_e( 'Range Default Value', 'comparepayment' ); ?></label>
			<input class="form-control" type="text" name="range_value" value="<?php echo esc_attr( $range_value ); ?>" placeholder="100">
		</div>
		<div class="form-group">
			<input type="submit" class="btn btn-primary cp-form-save" name="cp-form-save" value="<?php esc_html_e( 'Save', 'comparepayment' ); ?> " />
		</div>
	</form>
	
</div>