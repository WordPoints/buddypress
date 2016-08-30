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

// Hook to load BuddyPress.
tests_add_filter( 'muplugins_loaded', 'wordpoints_bp_tests_manually_load_buddypress' );

/**
 * Manually load the BuddyPress plugin.
 *
 * @since 1.0.0
 */
function wordpoints_bp_tests_manually_load_buddypress() {

	if ( ! getenv( 'BP_TESTS_DIR' ) ) {
		echo( 'BP_TESTS_DIR is not set.' . PHP_EOL );
		exit( 1 );
	}

/*
	// Remove all of BuddyPress's tables from the DB so we start with a clean slate.
	global $wpdb;

	$wpdb->query(
		'
			SELECT CONCAT("DROP TABLE ",GROUP_CONCAT(CONCAT(table_schema,".",table_name)),";")
				INTO @dropcmd
				FROM information_schema.tables
				WHERE table_schema=database()
					AND table_name like  "' . $wpdb->esc_like( $wpdb->base_prefix . 'bp_' ) . '%"
		'
	);
	$wpdb->query( 'PREPARE s1 FROM @dropcmd' );
	$wpdb->query( 'EXECUTE s1' );
	$wpdb->query( 'DEALLOCATE PREPARE s1' );
*/
	require( getenv( 'BP_TESTS_DIR' ) . '/includes/loader.php' );

	// Disable this until after WordPress is fully loaded.
	foreach ( array( 'add_option', 'add_site_option', 'update_option', 'update_site_option' ) as $action ) {
		remove_action( $action, 'bp_core_clear_root_options_cache' );
	}

	add_action( 'init', 'wordpoints_bp_tests_clear_root_options_cache' );
}

/**
 * Set up BuddyPress to properly clear the root options cache.
 *
 * We temporarily disable this while WordPoints is being installed, because that
 * happens before the pluggable functions are loaded, and
 * `bp_core_clear_root_options_cache()` calls `bp_get_default_options()` which calls
 * `wp_generate_password()`, which is pluggable.
 *
 * @since 1.0.0
 */
function wordpoints_bp_tests_clear_root_options_cache() {

	foreach ( array( 'add_option', 'add_site_option', 'update_option', 'update_site_option' ) as $action ) {
		add_action( $action, 'bp_core_clear_root_options_cache' );
	}

	wp_cache_delete( 'root_blog_options', 'bp' );
}

// EOF
