<?php

/**
 * Activity comment post hook event class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * An event that fires when a user posts a comment on an activity item.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Hook_Event_Activity_Comment_Post
	extends WordPoints_Hook_Event {

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return __( 'Post Activity Comment', 'wordpoints-bp' );
	}

	/**
	 * @since 1.0.0
	 */
	public function get_description() {
		return __( 'Commenting on an item in the activity stream on the BuddyPress social network.', 'wordpoints-bp' );
	}
}

// EOF
