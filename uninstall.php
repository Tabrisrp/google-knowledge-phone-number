<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package   Google Knowledge Phone Number
 * @author    Remy Perona <remperona@gmail.com>
 * @license   GPL-2.0+
 * @link      http://remyperona.fr
 * @copyright 2014 Remy Perona
 */

// If uninstall not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

global $wpdb;

if ( is_multisite() ) {

	$blogs = $wpdb->get_results( "SELECT blog_id FROM {$wpdb->blogs}", ARRAY_A );
		delete_option('gkpn_customer_support');
		delete_option('gkpn_technical_support');
		delete_option('gkpn_billing_support');
		delete_option('gkpn_bill_payment');
		delete_option('gkpn_sales');
		delete_option('gkpn_reservations');
		delete_option('gkpn_credit_card_support');
		delete_option('gkpn_emergency');
		delete_option('gkpn_baggage_tracking');
		delete_option('gkpn_roadside_assistance');
		delete_option('gkpn_package_tracking');

	if ( $blogs ) {

	 	foreach ( $blogs as $blog ) {
			switch_to_blog( $blog['blog_id'] );
			delete_option('gkpn_customer_support');
		    delete_option('gkpn_technical_support');
		    delete_option('gkpn_billing_support');
		    delete_option('gkpn_bill_payment');
		    delete_option('gkpn_sales');
		    delete_option('gkpn_reservations');
		    delete_option('gkpn_credit_card_support');
		    delete_option('gkpn_emergency');
		    delete_option('gkpn_baggage_tracking');
		    delete_option('gkpn_roadside_assistance');
		    delete_option('gkpn_package_tracking');

			//info: optimize table
			$GLOBALS['wpdb']->query("OPTIMIZE TABLE `" .$GLOBALS['wpdb']->prefix."options`");
			restore_current_blog();
		}
	}

} else {
	delete_option('gkpn_customer_support');
    delete_option('gkpn_technical_support');
    delete_option('gkpn_billing_support');
    delete_option('gkpn_bill_payment');
    delete_option('gkpn_sales');
    delete_option('gkpn_reservations');
    delete_option('gkpn_credit_card_support');
    delete_option('gkpn_emergency');
    delete_option('gkpn_baggage_tracking');
    delete_option('gkpn_roadside_assistance');
    delete_option('gkpn_package_tracking');

	//info: optimize table
	$GLOBALS['wpdb']->query("OPTIMIZE TABLE `" .$GLOBALS['wpdb']->prefix."options`");
}