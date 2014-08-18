<?php
/**
 * Google Knowledge Panels company's phone numbers for WordPress
 *
 * 
 * 
 *
 * @package   google-knowledge-phone-number
 * @author    Rémy Perona <remperona@gmail.com>
 * @license   GPL-2.0+
 * @link      http://remyperona.fr
 * @copyright 2014 Rémy Perona
 *
 * @wordpress-plugin
 * Plugin Name:       Google Knowledge Company's Phone Number
 * Plugin URI:        
 * Description:       Add JSON-LD markup in your WordPress website, to display your company's phone number(s) on Google Knowledge Panels
 * Version:           1.0.0
 * Author:            Rémy Perona
 * Author URI:        http://remyperona.fr
 * Text Domain:       google-knowledge-phone-number
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/Tabrisrp/google-knowledge-phone-number/
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/
require_once( plugin_dir_path( __FILE__ ) . 'public/class-gkpn.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 */
register_activation_hook( __FILE__, array( 'GKPN', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'GKPN', 'deactivate' ) );

add_action( 'plugins_loaded', array( 'GKPN', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/gkpn-admin.php' );
	add_action( 'plugins_loaded', array( 'GKPN_Admin', 'get_instance' ) );

}
