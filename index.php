<?php 
/*
	Plugin Name: Compare Payment
	Plugin URI: http://zozothemes.com/
	Description: This is online transaction payment compare plugin.
	Version: 1.0
	Author: zozothemes
	Author URI: http://zozothemes.com/
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'CP_CORE_DIR', plugin_dir_path( __FILE__ ) );
define('CP_CORE_URL', plugin_dir_url( __FILE__ ) );

load_plugin_textdomain( 'comparepayment', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

//Plugin Function 
require_once( CP_CORE_DIR . 'function.php' );

function cp_core_scripts_method() {

	wp_enqueue_style( 'bootstrap', plugins_url( '/assets/css/bootstrap.min.css', __FILE__ ), array(), '4.1.3' );
	wp_enqueue_style( 'rangeslider', plugins_url( '/assets/css/rangeslider.css', __FILE__ ), array(), '1.0' );
	wp_enqueue_style( 'compare-payment', plugins_url( '/assets/css/style.css', __FILE__ ), array(), '1.0' );

	wp_enqueue_script( 'rangeslider', plugins_url( '/assets/js/rangeslider.min.js', __FILE__ ), array( 'jquery' ), '1.0' );
	wp_enqueue_script( 'compare-payment', plugins_url( '/assets/js/custom.js', __FILE__ ), array( 'jquery' ), '1.0' );

}
add_action( 'wp_enqueue_scripts', 'cp_core_scripts_method' );

function cp_core_admin_scripts_method() { 
	wp_enqueue_style( 'compare-payment-admin', plugins_url( '/admin/assets/css/cp-admin-style.css', __FILE__ ), array(), '1.0' );
}
add_action( 'admin_enqueue_scripts', 'cp_core_admin_scripts_method' );
