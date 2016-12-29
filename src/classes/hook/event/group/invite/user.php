<?php

/**
 * Group invite user hook event class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * An event that fires when a user is invited to a group.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Hook_Event_Group_Invite_User
	extends WordPoints_Hook_Event
	implements WordPoints_Hook_Event_ReversingI {

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return __( 'Invite User to Group', 'wordpoints-bp' );
	}

	/**
	 * @since 1.0.0
	 */
	public function get_description() {
		return __( 'Inviting a user to a group on the BuddyPress social network.', 'wordpoints-bp' );
	}

	/**
	 * @since 1.0.0
	 */
	public function get_reversal_text() {
		return __( 'Invitation deleted.', 'wordpoints-bp' );
	}
}

// EOF
