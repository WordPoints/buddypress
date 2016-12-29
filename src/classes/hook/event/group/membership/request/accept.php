<?php

/**
 * Group membership request accept hook event class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * An event that fires when a user request to become a member of a group is accepted.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Hook_Event_Group_Membership_Request_Accept
	extends WordPoints_Hook_Event
	implements WordPoints_Hook_Event_ReversingI {

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return __( 'Accept Group Membership Request', 'wordpoints-bp' );
	}

	/**
	 * @since 1.0.0
	 */
	public function get_description() {
		return __( 'Accepting a user&#8217;s request to become a member of a group on the BuddyPress social network.', 'wordpoints-bp' );
	}

	/**
	 * @since 1.0.0
	 */
	public function get_reversal_text() {
		return __( 'Member removed from group.', 'wordpoints-bp' );
	}
}

// EOF
