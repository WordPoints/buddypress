<?php

/**
 * Group membership request send hook event class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * An event that fires when a user requests to become a member of a group.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Hook_Event_Group_Membership_Request_Send
	extends WordPoints_Hook_Event
	implements WordPoints_Hook_Event_ReversingI {

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return __( 'Send Group Membership Request', 'wordpoints-bp' );
	}

	/**
	 * @since 1.0.0
	 */
	public function get_description() {
		return __( 'Requesting to become a member of a group on the BuddyPress social network.', 'wordpoints-bp' );
	}

	/**
	 * @since 1.0.0
	 */
	public function get_reversal_text() {
		return __( 'Request deleted.', 'wordpoints-bp' );
	}
}

// EOF
