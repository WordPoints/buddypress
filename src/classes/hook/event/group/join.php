<?php

/**
 * Group join hook event class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * An event that fires when a user joins a group.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Hook_Event_Group_Join extends WordPoints_Hook_Event {

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return __( 'Join Group', 'wordpoints-bp' );
	}

	/**
	 * @since 1.0.0
	 */
	public function get_description() {
		return __( 'Joining a group on the BuddyPress social network.', 'wordpoints-bp' );
	}
}

// EOF
