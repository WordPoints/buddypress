<?php

/**
 * Activity comment entity class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Represents a BuddyPress activity item comment.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Entity_Activity_Comment
	extends WordPoints_BP_Entity_Activity {

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return __( 'Activity Comment', 'wordpoints-bp' );
	}
}

// EOF
