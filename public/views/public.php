<?php
/**
 * Represents the view for the public-facing component of the plugin.
 *
 * This typically includes any information, if any, that is rendered to the
 * frontend of the theme when the plugin is activated.
 *
 * @package   Google Knowledge Phone Number
 * @author    Remy Perona <remperona@gmail.com>
 * @license   GPL-2.0+
 * @link      http://remyperona.fr
 * @copyright 2014 Remy Perona
 */
?>
<?php if ( is_front_page() ) : ?>
<script type="application/ld+json">
{ "@context" : "http://schema.org",
  "@type" : "Organization",
  "url" : "<?php echo home_url( '/' ); ?>",
  "contactPoint" : [
    <?php echo $contact_types; ?>
] }
</script>
<?php endif; ?>