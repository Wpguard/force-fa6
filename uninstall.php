<?php
/**
 * Uninstall handler for Force Font Awesome 6
 *
 * This file is executed when the plugin is deleted via the WordPress plugins screen.
 *
 * It must not be accessible directly.
 */

// If uninstall not called from WordPress, exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// No persistent options stored by the plugin at this time.
// If you add options in the future, remove them here, e.g.:
// delete_option( 'ff6_some_option' );