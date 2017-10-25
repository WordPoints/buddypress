<?php

/**
 * Group avatar upload hook event class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * An event that fires when the avatar for a group is set.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Hook_Event_Group_Avatar_Upload
	extends WordPoints_Hook_Event
	implements WordPoints_Hook_Event_ReversingI {

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return __( 'Set Group Profile Photo', 'wordpoints-bp' );
	}

	/**
	 * @since 1.0.0
	 */
	public function get_description() {
		return __( 'Setting the profile photo for a group on the BuddyPress social network.', 'wordpoints-bp' );
	}

	/**
	 * @since 1.0.0
	 */
	public function get_reversal_text() {
		return __( 'Image deleted.', 'wordpoints-bp' );
	}
}

// EOF
