<?php

/**
 * Group invite accept hook event class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * An event that fires when a user accepts an invitation to a group.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Hook_Event_Group_Invite_Accept
	extends WordPoints_Hook_Event
	implements WordPoints_Hook_Event_ReversingI {

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return __( 'Accept Group Invitation', 'wordpoints-bp' );
	}

	/**
	 * @since 1.0.0
	 */
	public function get_description() {
		return __( 'Accepting an invitation to join a group on the BuddyPress social network.', 'wordpoints-bp' );
	}

	/**
	 * @since 1.0.0
	 */
	public function get_reversal_text() {
		return __( 'Member removed from group.', 'wordpoints-bp' );
	}
}

// EOF
