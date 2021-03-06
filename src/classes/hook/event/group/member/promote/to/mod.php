<?php

/**
 * Group member promote to mod hook event class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * An event that fires when a group member is promoted to a moderator.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Hook_Event_Group_Member_Promote_To_Mod
	extends WordPoints_Hook_Event
	implements WordPoints_Hook_Event_ReversingI {

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return __( 'Promote Group Member to Moderator', 'wordpoints-bp' );
	}

	/**
	 * @since 1.0.0
	 */
	public function get_description() {
		return __( 'Promoting a group member to be a moderator of a group on the BuddyPress social network.', 'wordpoints-bp' );
	}

	/**
	 * @since 1.0.0
	 */
	public function get_reversal_text() {
		return __( 'Moderator status terminated.', 'wordpoints-bp' );
	}
}

// EOF
