<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   google-knowledge-phone-number
 * @author    Remy Perona <remperona@gmail.com>
 * @license   GPL-2.0+
 * @link      http://remyperona.fr
 * @copyright 2014 Remy Perona
 */
?>

<div class="wrap">
<h2><?php _e( 'Google Knowledge Phone Number', $this->plugin_slug ); ?></h2>
<?php $settings_api = WeDevs_Settings_API::get_instance(); ?>
<p><?php _e( 'You can fill only the desired tab(s) data and leave the others blank. You have to save every tab individually for your changes to take effect.', $this->plugin_slug ); ?></p>
<?php
    $settings_api->show_navigation();
    $settings_api->show_forms();
?>
</div>
