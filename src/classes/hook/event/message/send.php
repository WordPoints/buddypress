<?php

/**
 * Message send hook event class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * An event that fires when a user sends a message to another user.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Hook_Event_Message_Send extends WordPoints_Hook_Event {

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return __( 'Send Message', 'wordpoints' );
	}

	/**
	 * @since 1.0.0
	 */
	public function get_description() {
		return __( 'Sending a message to another user on the BuddyPress social network.', 'wordpoints' );
	}
}

// EOF
