<?php

/**
 * Friendship request hook event class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * An event that fires when a user requests friendship with another user.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Hook_Event_Friendship_Request
	extends WordPoints_Hook_Event
	implements WordPoints_Hook_Event_ReversingI {

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return __( 'Request Friendship', 'wordpoints-bp' );
	}

	/**
	 * @since 1.0.0
	 */
	public function get_description() {
		return __( 'Sending a friendship request to another user on the BuddyPress social network.', 'wordpoints-bp' );
	}

	/**
	 * @since 1.0.0
	 */
	public function get_reversal_text() {
		return __( 'Request withdrawn.', 'wordpoints-bp' );
	}
}

// EOF
