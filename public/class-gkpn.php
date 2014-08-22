<?php
/**
 * Plugin Name.
 *
 * @package   Plugin_Name
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 */

/**
 * Plugin class. This class should ideally be used to work with the
 * public-facing side of the WordPress site.
 *
 * If you're interested in introducing administrative or dashboard
 * functionality, then refer to `class-plugin-name-admin.php`
 *
 * @TODO: Rename this class to a proper name for your plugin.
 *
 * @package Plugin_Name
 * @author  Your Name <email@example.com>
 */
class GKPN {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	const VERSION = '1.0.0';

	/**
	 * Unique identifier for your plugin.
	 *
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'google-knowledge-phone-number';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		/* Define custom functionality.
		 * Refer To http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		 */
		add_action( 'wp_footer', array( $this, 'gkpn_get_settings_values' ) );

	}

	/**
	 * Return the plugin slug.
	 *
	 * @since    1.0.0
	 *
	 * @return    Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, basename( plugin_dir_path( dirname( __FILE__ ) ) ) . '/languages/' );

	}

	/**
	 * NOTE:  Actions are points in the execution of a page or process
	 *        lifecycle that WordPress fires.
	 *
	 *        Actions:    http://codex.wordpress.org/Plugin_API#Actions
	 *        Reference:  http://codex.wordpress.org/Plugin_API/Action_Reference
	 *
	 * @since    1.0.0
	 */
	public function gkpn_get_settings_values() {

        include_once( plugin_dir_path( realpath( dirname( __FILE__ ) ) ) . 'includes/class.settings-api.php' );

	    $settings_value = new WeDevs_Settings_API();

    /* Sections list for loop */
        $sections = array(
            'gkpn_customer_support' => 'customer support',
            'gkpn_technical_support' => 'technical support',
            'gkpn_billing_support' => 'billing support',
            'gkpn_bill_payment' => 'bill payment',
            'gkpn_sales' => 'sales',
            'gkpn_reservations' => 'reservations',
            'gkpn_credit_card_support' => 'credit card support',
            'gkpn_emergency' => 'emergency',
            'gkpn_baggage_tracking' => 'baggage tracking',
            'gkpn_roadside_assistance' => 'roadside assistance',
            'gkpn_package_tracking' => 'package tracking'
            );

    /* Properties list for loop */
        $properties = array(
            'area_served' => 'areaServed',
            'contact_option' => 'contactOption',
            'available_language' => 'availableLanguage'
        );

        $contact_types = '';
        $telephone = '';

        foreach ( $sections as $section => $section_value ) {

            $telephone = $settings_value->get_option( 'telephone', $section );

            if ( !empty( $telephone ) ) {
                $contact_types .= '{ "@type" : "ContactPoint",
                "contactType" : "' . $section_value . '",
                "telephone" : "' . $telephone . '",';
                
                foreach ( $properties as $key => $property ) {

                    $property_value = $settings_value->get_option( $key, $section );
                    if ( !empty( $property_value ) ) {
                        $contact_types .= '"' . $property . '" : ';
                        if( is_string( $property_value ) ) {
                            $property_value = explode( ',', $property_value );
                        }
                        
                        $values_count = count( $property_value );
                        if ( $values_count > 1 ) {
                            $contact_types .= '[';
                        }
                        foreach ( $property_value as $single_value ) {
                            $contact_types .= '"' . $single_value . '",';
                        }
                        $contact_types = rtrim( $contact_types, ',' );
                        if ( $values_count > 1 ) {
                            $contact_types .= ']';
                        }
                        $contact_types .= ',';
                    }
                }
                $contact_types = rtrim( $contact_types, ',' );
                $contact_types .= '},';
            }
        }

        $contact_types = rtrim( $contact_types, ',' );

		include_once( 'views/public.php' );

	}
}
