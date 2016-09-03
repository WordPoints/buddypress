<?php

/**
 * Bootstrap for the PHPUnit tests.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * The BuddyPress factories for use in the unit tests.
 *
 * @since 1.0.0
 */
require_once( BP_TESTS_DIR . '/includes/factory.php' );

// Autoload the PHPUnit helper classes.
WordPoints_Dev_Lib_PHPUnit_Class_Autoloader::register_dir(
	dirname( dirname( __FILE__ ) ) . '/classes/'
	, 'WordPoints_BP_PHPUnit_'
);

// EOF
