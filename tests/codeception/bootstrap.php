<?php

/**
 * This is global bootstrap for autoloading for the codeception tests.
 *
 * @package WordPoints_BP\Codeception
 * @since 1.3.0
 */

/**
 * The dev-lib's main Codeception bootstrap.
 *
 * @since 1.3.0
 */
require_once __DIR__ . '/../../dev-lib/wpcept/bootstrap.php';

$loader = WordPoints_PHPUnit_Bootstrap_Loader::instance();
$loader->add_plugin( 'buddypress/bp-loader.php' );

$loader->add_action(
	'after_load_wordpress'
	, function () {
		system(
			WP_PHP_BINARY
			. ' ' . escapeshellarg( getenv( 'BP_TESTS_DIR' ) . '/includes/install.php' )
			. ' ' . escapeshellarg( getenv( 'WP_TESTS_DIR' ) . '/../../wp-tests-config.php' )
			. ' ' . escapeshellarg( getenv( 'WP_TESTS_DIR' ) )
			. ' ' . is_multisite()
		);
	}
);

// EOF
