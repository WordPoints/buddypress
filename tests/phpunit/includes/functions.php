<?php

/**
 * Utility functions used in PHPUnit testing.
 *
 * @package WordPoints_BuddyPress\Tests
 * @since 1.0.0
 */

/**
 * The module's tests directory.
 *
 * @since 1.0.0
 *
 * @type string
 */
define( 'WORDPOINTS_BP_TESTS_DIR', dirname( dirname( __FILE__ ) ) );

if ( ! getenv( 'BP_TESTS_DIR' ) ) {
	echo( 'BP_TESTS_DIR is not set.' . PHP_EOL );
	exit( 1 );
}

define( 'BP_TESTS_DIR', getenv( 'BP_TESTS_DIR' ) );

$loader = WordPoints_PHPUnit_Bootstrap_Loader::instance();
$loader->add_plugin( 'buddypress/bp-loader.php' );

/**
 * Remotely install BuddyPress for the PHPUnit tests.
 *
 * We have to take this additional step beyond the usual activation provided via
 * the loader above, because BuddyPress doesn't actually perform its install routine
 * upon activation. Instead, it lets its update function, `bp_version_updater()`,
 * perform installation as well. It is called `bp_setup_updater()` via the
 * `bp_admin_init` action. Because of that, installation isn't performed when
 * WordPress is loaded for the PHPUnit tests either, since they don't fire
 * `admin_init`.
 *
 * @since 1.0.0
 */
function wordpoints_bp_phpunit_tests_install_bp_remotely() {

	$multisite = (int) ( defined( 'WP_TESTS_MULTISITE' ) && WP_TESTS_MULTISITE );

	$loader = WordPoints_PHPUnit_Bootstrap_Loader::instance();

	system(
		WP_PHP_BINARY
		. ' ' . escapeshellarg( BP_TESTS_DIR . '/includes/install.php' )
		. ' ' . escapeshellarg( $loader->locate_wp_tests_config() )
		. ' ' . escapeshellarg( $loader->get_wp_tests_dir() )
		. ' ' . $multisite
	);
}
tests_add_filter(
	'muplugins_loaded'
	, 'wordpoints_bp_phpunit_tests_install_bp_remotely'
);

// EOF
