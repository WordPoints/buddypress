<?php

/**
 * Load code relating to the ranks component.
 *
 * @package WordPoints_BuddyPress
 * @since   1.0.0
 */

if ( wordpoints_component_is_active( 'points' ) ) {

	/**
	 * The functions integrating the ranks component with the points component.
	 *
	 * @since 1.0.0
	 */
	require_once( WORDPOINTS_BP_DIR . '/components/ranks/includes/integration/points/functions.php' );

	/**
	 * Hooks up the actions and filters integrating ranks with the points component.
	 *
	 * @since 1.0.0
	 */
	require_once( WORDPOINTS_BP_DIR . '/components/ranks/includes/integration/points/actions.php' );
}

// EOF
