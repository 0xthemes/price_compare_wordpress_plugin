<?php

//Create Menu Page
add_action('admin_menu', 'register_cp_menu_page');
function register_cp_menu_page() {
    add_menu_page(
        esc_html__( 'Compare Payment', 'comparepayment' ),
        esc_html__( 'Compare Payment', 'comparepayment' ),
        'manage_options',
        'compare-payment',
        'cp_submenu_page_callback',
		CP_CORE_URL . 'assets/images/transaction.png'
	);
}

function cp_submenu_page_callback() {
	require_once( CP_CORE_DIR . 'compare-payment.php' );
}

function cp_form_values_save(){
	
}
add_action( 'wp_ajax_cp_values_save', 'cp_form_values_save' );


add_action( 'init', 'codex_compare_payments_init' );
function codex_compare_payments_init() {
	$cpt_labels = array( 
		'name' 					=> esc_html__( 'Payments Type', 'comparepayment' ),
		'singular_name' 		=> esc_html__( 'Payment', 'comparepayment' ),
		'add_new' 				=> esc_html__( 'Add New', 'comparepayment' ),
		'add_new_item' 			=> esc_html__( 'Add New Payment', 'comparepayment' ),
		'edit_item' 			=> esc_html__( 'Edit Payment', 'comparepayment' ),
		'new_item' 				=> esc_html__( 'New Payment', 'comparepayment' ),
		'all_items' 			=> esc_html__( 'Payments', 'comparepayment' ),
		'view_item' 			=> esc_html__( 'View Payment', 'comparepayment' ),
		'search_items' 			=> esc_html__( 'Search Payments', 'comparepayment' ),
		'not_found' 			=> esc_html__( 'No payments found', 'comparepayment' ),
		'not_found_in_trash' 	=> esc_html__( 'No payments found in Trash', 'comparepayment' ),
		'parent_item_colon' 	=> ''
	);
	
	$cpt_args = array(
		'labels' 				=> $cpt_labels,
		'public' 				=> true,
		'publicly_queryable' 	=> true,
		'show_ui' 				=> true,
		'show_in_menu'       	=> true,
		'query_var' 			=> true,
		'rewrite' 				=> array( 'slug' => 'compare-payments' ),
		'capability_type' 		=> 'post',
		'hierarchical' 			=> false,
		'has_archive' 			=> false,
		'exclude_from_search' 	=> true,
		'supports' 				=> array( 'title', 'thumbnail' )
	);
	
	register_post_type( 'compare-payments', $cpt_args );
}


add_action( 'add_meta_boxes', 'cp_meta_box_add' );
function cp_meta_box_add()
{
    add_meta_box( 'compare-payment-metabox', 'Compare Payment Metabox', 'compare_payment_metabox', 'compare-payments', 'normal', 'high' );
}

function compare_payment_metabox()
{
    // $post is already set, and contains an object: the WordPress post
    global $post;
    $values = get_post_custom( $post->ID );
	
	$cp_own = get_post_meta( $post->ID, 'cp_own', true );
	$cp_trans_fee = get_post_meta( $post->ID, 'cp_trans_fee', true );
	$cp_trans_additoinal_fee = get_post_meta( $post->ID, 'cp_trans_additoinal_fee', true );
	$cp_min_trans_fee = get_post_meta( $post->ID, 'cp_min_trans_fee', true );
	$cp_card_body = get_post_meta( $post->ID, 'cp_card_body', true );
	$cp_card_bottom = get_post_meta( $post->ID, 'cp_card_bottom', true );
     
    // We'll use this nonce field later on when saving.
    wp_nonce_field( 'cp_meta_box_nonce', 'meta_box_nonce' );
    ?>
	
	<div class="form-group">
		<label for="cp_own"><?php esc_html_e( 'Is This Your Own Payment Method', 'comparepayment' ); ?></label>
		<select class="form-control" name="cp_own" id="cp_own">
			<option value="no" <?php selected( $cp_own, 'no' ); ?>><?php esc_html_e( 'No', 'comparepayment' ); ?></option>
			<option value="yes" <?php selected( $cp_own, 'yes' ); ?>><?php esc_html_e( 'Yes', 'comparepayment' ); ?></option>
		</select>
	</div>
	
	<div class="form-group">
        <label for="cp_trans_fee"><?php esc_html_e( 'Transaction Fee', 'comparepayment' ); ?></label>
        <input class="form-control" type="text" name="cp_trans_fee" id="cp_trans_fee" value="<?php echo esc_html( $cp_trans_fee ); ?>" />
		<span><?php esc_html_e( 'Enter payment gateway transaction fees. Don\'t mention currency. Example: 2.9', 'comparepayment' ); ?></span>
    </div>
	
	<div class="form-group">
        <label for="cp_trans_additoinal_fee"><?php esc_html_e( 'Additional Fee', 'comparepayment' ); ?></label>
        <input class="form-control" type="text" name="cp_trans_additoinal_fee" id="cp_trans_additoinal_fee" value="<?php echo esc_html( $cp_trans_additoinal_fee ); ?>" />
		<span><?php esc_html_e( 'Enter payment gateway transaction additional fees. Don\'t mention currency. Example: 0.3', 'comparepayment' ); ?></span>
    </div>
	
	<div class="form-group">
        <label for="cp_min_trans_fee"><?php esc_html_e( 'Minimum Transaction Fee', 'comparepayment' ); ?></label>
        <input class="form-control" type="text" name="cp_min_trans_fee" id="cp_min_trans_fee" value="<?php echo esc_html( $cp_min_trans_fee ); ?>" />
		<span><?php esc_html_e( 'Enter your minimum transaction fees. Don\'t mention currency. Example: 0.03', 'comparepayment' ); ?></span>
    </div>
	
	<div class="form-group">
        <label for="cp_card_body"><?php esc_html_e( 'Card Body Text', 'comparepayment' ); ?></label>
        <input class="form-control" type="text" name="cp_card_body" id="cp_card_body" value="<?php echo esc_html( $cp_card_body ); ?>" />
		<span><?php esc_html_e( 'Example: YOU PAY', 'comparepayment' ); ?></span>
    </div>
	
	<div class="form-group">
        <label for="cp_card_bottom"><?php esc_html_e( 'Card Bottom Text', 'comparepayment' ); ?></label>
        <input class="form-control" type="text" name="cp_card_bottom" id="cp_card_bottom" value="<?php echo esc_html( $cp_card_bottom ); ?>" />
		<span><?php esc_html_e( 'Example: 2.9% + 30&#162;', 'comparepayment' ); ?></span>
    </div>
	
    <?php    
}

add_action( 'save_post', 'cp_meta_box_save' );
function cp_meta_box_save( $post_id )
{
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
     
    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'cp_meta_box_nonce' ) ) return;
     
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post' ) ) return;
	
	if( isset( $_POST['cp_own'] ) )
        update_post_meta( $post_id, 'cp_own', esc_html( $_POST['cp_own'] ) );
		
	if( isset( $_POST['cp_trans_fee'] ) )
        update_post_meta( $post_id, 'cp_trans_fee', esc_html( $_POST['cp_trans_fee'] ) );
		
	if( isset( $_POST['cp_trans_additoinal_fee'] ) )
        update_post_meta( $post_id, 'cp_trans_additoinal_fee', esc_html( $_POST['cp_trans_additoinal_fee'] ) );
	
	if( isset( $_POST['cp_min_trans_fee'] ) )
        update_post_meta( $post_id, 'cp_min_trans_fee', esc_html( $_POST['cp_min_trans_fee'] ) );
		
	if( isset( $_POST['cp_card_body'] ) )
        update_post_meta( $post_id, 'cp_card_body', esc_html( $_POST['cp_card_body'] ) );
		
	if( isset( $_POST['cp_card_bottom'] ) )
        update_post_meta( $post_id, 'cp_card_bottom', esc_html( $_POST['cp_card_bottom'] ) );
}

// compare_payment shortcode
function compare_payment_func( $atts ) {
	$cp_atts = shortcode_atts( array(
		'compare_posts' => '',
		'cols' => '3'
	), $atts );
	
	extract( $cp_atts );
	
	$compare_posts = isset( $compare_posts ) ? $compare_posts : '';
	$cols = isset( $cols ) && $cols != '' ? absint( $cols ) : '3';
	$cols = $cols ? absint( 12/$cols ) : '4';
	
	$post_in = '';
	if( !empty( $compare_posts ) ){
		$compare_posts = preg_replace('/\s+/', '', $compare_posts);
		$post_in = explode( ",", $compare_posts );		
	}
	
	$cp_values = get_option( 'compare_payment_values' );
	$payment_currency = isset( $cp_values['payment_currency'] ) ? $cp_values['payment_currency'] : '';
	$range_min = isset( $cp_values['range_min'] ) ? $cp_values['range_min'] : '';
	$range_max = isset( $cp_values['range_max'] ) ? $cp_values['range_max'] : '';
	$range_step = isset( $cp_values['range_step'] ) ? $cp_values['range_step'] : '';
	$range_value = isset( $cp_values['range_value'] ) ? $cp_values['range_value'] : '';
	
	$output = '';
	$output .= '<div class="compare-wrap">
		<div class="compare-inner-wrap row">
			<div class="compare-ranger-text col-md-2 align-self-center text-center">
				<span>'. esc_html__( 'Minmum', 'comparepayment' ) .'</span>
				<h6>'. esc_html( $range_min ) .'</h6>
			</div>
			<div class="compare-rage-slider mb-5 mt-5 col-md-8">
				<input class="range-slider" type="range" min="'. esc_html( $range_min ) .'" max="'. esc_html( $range_max ) .'" step="'. esc_html( $range_step ) .'" value="'. esc_html( $range_value ) .'">
			</div>
			<div class="compare-ranger-text col-md-2 align-self-center text-center">
				<span>'. esc_html__( 'Maximum', 'comparepayment' ) .'</span>
				<h6>'. esc_html__( 'Unlimited', 'comparepayment' ) .'</h6>
			</div>
		</div><!-- .compare-inner-wrap -->';
	
	$args = array(
		'post_type'	=> 'compare-payments',
		'post__in'	=> $post_in,
		'orderby' => 'post__in'
	);
	
	$payment_out = '';
	
	
	
	// The Query
	$the_query = new WP_Query( $args );	
	
	//$cp_array = array( 'cp_count' => $the_query->found_posts );
	$cp_array = array();

	// The Loop
	if ( $the_query->have_posts() ) {
		
		$payment_out .= '<div class="compare-others-wrap"><div class="row">';
		
		while ( $the_query->have_posts() ) {
			$the_query->the_post();

			$post_id = get_the_ID();
			$featured_img_url = get_the_post_thumbnail_url(); 
			$post_title = get_the_title();
			
			$cp_own = get_post_meta( $post_id, 'cp_own', true );
			$cp_trans_fee = get_post_meta( $post_id, 'cp_trans_fee', true );
			$cp_trans_additoinal_fee = get_post_meta( $post_id, 'cp_trans_additoinal_fee', true );
			$cp_min_trans_fee = get_post_meta( $post_id, 'cp_min_trans_fee', true );
			$cp_card_body = get_post_meta( $post_id, 'cp_card_body', true );
			$cp_card_bottom = get_post_meta( $post_id, 'cp_card_bottom', true );
			
			$cp_array['compare-payment-post-'. esc_attr( $post_id )] = array(
				'title' => esc_html( $post_title ),
				'compare_trans' => $cp_own,
				'trans_fee' => $cp_trans_fee,
				'additional_fee' => $cp_trans_additoinal_fee,
				'min_trans_fee' => $cp_min_trans_fee
			);
			
			$payment_out .= '<div class="col-md-'. esc_attr( $cols ) .'">
				<div id="compare-payment-post-'. esc_attr( $post_id ) .'" class="card compare-payment text-center compare-'. esc_attr( sanitize_title( $post_title ) ) .'" data-percent="'. esc_attr( $cp_trans_fee ) .'" data-additional="'. esc_attr( $cp_trans_additoinal_fee ) .'" data-min="'. esc_attr( $cp_min_trans_fee ) .'">
					<img class="card-img-top m-auto mt-3" src="'. esc_url( $featured_img_url ) .'" alt="'. esc_attr( $post_title ) .'">
					<div class="card-body">
						<h5 class="card-title">'. esc_html( $cp_card_body ) .'</h5>
						<div class="card-text payment-val"><span>'. esc_html( $payment_currency ) .'</span> <h4 class="payment-val-update"></h4></div>
						<p class="card-bottom">'. esc_html( $cp_card_bottom ) .'</p>
						'. ( $cp_own == 'yes' ? '<div class="cheap-cal-wrap"></div>' : '' ) .'
					</div>
				</div>
			</div>';
		}
		
			$payment_out .= '</div>';
			$payment_out .= '<input type="hidden" class="compare-payment-hidden-json" value="'. htmlspecialchars( json_encode( $cp_array ), ENT_QUOTES, 'UTF-8' ) .'"/>';
		$payment_out .= '</div>';
		
		/* Restore original Post Data */
		wp_reset_postdata();
	}
		
		$output .= $payment_out;
	$output .= '</div>';

	return $output;
}
add_shortcode( 'compare_payment', 'compare_payment_func' );