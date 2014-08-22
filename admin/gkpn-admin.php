<?php
/**
 * Google Knowledge Phone Number
 *
 * @package   GKPN_Admin
 * @author    Remy Perona <remperona@gmail.com>
 * @license   GPL-2.0+
 * @link      http://remyperona.fr
 * @copyright 2014 Rémy Perona
 */

/**
 * Plugin class. This class should ideally be used to work with the
 * administrative side of the WordPress site.
 *
 * If you're interested in introducing public-facing
 * functionality, then refer to `class-plugin-name.php`
 *
 * @TODO: Rename this class to a proper name for your plugin.
 *
 * @package GKPN_admin
 * @author  Remy Perona <remperona@gmail.com>
 */
class GKPN_Admin {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		/*
		 * - Uncomment following lines if the admin class should only be available for super admins
		 */
		/* if( ! is_super_admin() ) {
			return;
		} */

		/*
		 * Call $plugin_slug from public plugin class.
		 *
		 *
		 */
		$plugin = GKPN::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();

		// Add the options page and menu item.
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

		// Add an action link pointing to the options page.
		$plugin_basename = plugin_basename( plugin_dir_path( realpath( dirname( __FILE__ ) ) ) . $this->plugin_slug . '.php' );
		add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );

		/*
		 * Define custom functionality.
		 *
		 * Read more about actions and filters:
		 * http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		 */
		add_action( 'admin_init', array( $this, 'register_gkpn_settings' ) );

	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		/*
		 *
		 * - Uncomment following lines if the admin class should only be available for super admins
		 */
		/* if( ! is_super_admin() ) {
			return;
		} */

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		/*
		 * Add a settings page for this plugin to the Settings menu.
		 *
		 * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
		 *
		 *        Administration Menus: http://codex.wordpress.org/Administration_Menus
		 *
		 */
		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'Google Knowledge Phone Number', $this->plugin_slug ),
			__( 'Google Knowledge Phone Number', $this->plugin_slug ),
			'manage_options',
			$this->plugin_slug,
			array( $this, 'display_plugin_admin_page' )
		);

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {
		include_once( 'views/admin.php' );
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	public function add_action_links( $links ) {

		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_slug ) . '">' . __( 'Settings', $this->plugin_slug ) . '</a>'
			),
			$links
		);

	}

	public function register_gkpn_settings() {

	    include_once( plugin_dir_path( realpath( dirname( __FILE__ ) ) ) . 'includes/class.settings-api.php' );

		$sections = array(
		    array(
		        'id' => 'gkpn_customer_support',
		        'title' => __( 'Customer Support', $this->plugin_slug )
            ),
            array(
                'id' => 'gkpn_technical_support',
                'title' => __( 'Technical Support', $this->plugin_slug )
            ),
            array(
                'id' => 'gkpn_billing_support',
                'title' => __( 'Billing Support', $this->plugin_slug )
            ),
            array(
                'id' => 'gkpn_bill_payment',
                'title' => __( 'Bill Payment', $this->plugin_slug )
            ),
            array(
                'id' => 'gkpn_sales',
                'title' => __( 'Sales', $this->plugin_slug )
            ),
            array(
                'id' => 'gkpn_reservations',
                'title' => __( 'Reservations', $this->plugin_slug )
            ),
            array(
                'id' => 'gkpn_credit_card_support',
                'title' => __( 'Credit Card Support', $this->plugin_slug )
            ),
            array(
                'id' => 'gkpn_emergency',
                'title' => __( 'Emergency', $this->plugin_slug )
            ),
            array(
                'id' => 'gkpn_baggage_tracking',
                'title' => __( 'Baggage Tracking', $this->plugin_slug )
            ),
            array(
                'id' => 'gkpn_roadside_assistance',
                'title' => __( 'Roadside Assistance', $this->plugin_slug )
            ),
            array(
                'id' => 'gkpn_package_tracking',
                'title' => __( 'Package Tracking', $this->plugin_slug )
            ),
        );

        $fields_settings = array(
                array(
                    'name' => 'telephone',
                    'label' => __( 'Phone number', $this->plugin_slug ),
                    'desc' => __( 'Required. An internationalized version of the phone number, starting with the "+" symbol and country code', $this->plugin_slug ),
                    'type' => 'text',
                ),
                array(
                    'name' => 'area_served',
                    'label' => __( 'Area Served', $this->plugin_slug ),
                    'desc' => sprintf( __( 'Optional. The geographical region served by the number, specified as a schema.org/AdministrativeArea. Countries may be specified concisely using just their <a href="%s">standard ISO-3166</a> two-letter code, separated by a comma. If omitted, the number is assumed to be global.', $this->plugin_slug ), 'http://en.wikipedia.org/wiki/ISO_3166-1_alpha-2#Officially_assigned_code_elements' ),
                    'type' => 'text',
                ),
                array(
                    'name' => 'contact_option',
                    'label' => __( 'Contact Option', $this->plugin_slug ),
                    'desc' => __( 'Optional. Phone number details', $this->plugin_slug ),
                    'type' => 'multicheck',
                    'options' => array(
                        'TollFree' => __( 'Toll Free', $this->plugin_slug ),
                        'HearingImpairedSupported' => __( 'Support for hearing impaired', $this->plugin_slug)
                    )
                ),
                array(
                    'name' => 'available_language',
                    'label' => __( 'Available Languages', $this->plugin_slug ),
                    'desc' => __( 'Optional details about the language spoken. Languages may be specified by their common English name, separated by a comma. If omitted, the language defaults to English.', $this->plugin_slug ),
                    'type' => 'text'
                )
            );

        $fields = array();
        foreach ( $sections as $section ) {
            $fields[$section['id']] = $fields_settings;
        }

        $settings_api = WeDevs_Settings_API::get_instance();;

        //set sections and fields
        $settings_api->set_sections( $sections );
        $settings_api->set_fields( $fields );

        //initialize them
        $settings_api->admin_init();
    }
}