<?php

/**
 * Activity favorite hook event class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * An event that fires when a user marks an activity item as a favorite.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Hook_Event_Activity_Favorite
	extends WordPoints_Hook_Event
	implements WordPoints_Hook_Event_ReversingI {

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return __( 'Favorite Activity', 'wordpoints-bp' );
	}

	/**
	 * @since 1.0.0
	 */
	public function get_description() {
		return __( 'Marking an item as a favorite in the activity stream on the BuddyPress social network.', 'wordpoints-bp' );
	}

	/**
	 * @since 1.0.0
	 */
	public function get_reversal_text() {
		return __( 'Activity unfavorited.', 'wordpoints-bp' );
	}
}

// EOF
