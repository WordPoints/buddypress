<?php

/**
 * Friendship accept hook event class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * An event that fires when a user accepts a friendship request from another user.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Hook_Event_Friendship_Accept extends WordPoints_Hook_Event {

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return __( 'Accept Friendship', 'wordpoints-bp' );
	}

	/**
	 * @since 1.0.0
	 */
	public function get_description() {
		return __( 'Accepting a friendship request from another user on the BuddyPress social network.', 'wordpoints-bp' );
	}
}

// EOF
